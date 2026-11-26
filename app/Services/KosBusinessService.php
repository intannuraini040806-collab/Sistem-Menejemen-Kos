<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Contract;
use App\Models\InvoiceItem;
use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\SecurityDeposit;
use App\Models\Setting;
use App\Models\Tagihan;
use App\Models\TenantProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class KosBusinessService
{
    /**
     * POIN 5 & 7: Hitung nominal DP, tenggat waktu, dan simpan kebijakan saat booking dibuat.
     */
    public function hitungDanSiapkanDp(Booking $booking, Kamar $kamar): Booking
    {
        $dpTipe = Setting::getVal('dp_tipe', 'persentase');
        $dpNilai = (int) Setting::getVal('dp_nilai', 30);
        $tenggatJam = (int) Setting::getVal('tenggat_dp_jam', 24);
        $kebijakanDp = Setting::getVal(
            'kebijakan_dp',
            'DP dibayarkan sebelum tenggat waktu. Pembatalan sepihak mengikuti aturan kos.'
        );

        $nominalDp = $dpTipe === 'persentase'
            ? (int) round(($dpNilai / 100) * $kamar->harga)
            : $dpNilai;

        $booking->update([
            'nominal_dp' => $nominalDp,
            'tenggat_dp' => now()->addHours($tenggatJam),
            'kebijakan_dp' => $kebijakanDp,
        ]);

        return $booking->fresh();
    }

    /**
     * POIN 5: Proses Check-In & Pembuatan Kontrak Aktif + Security Deposit.
     */
    public function prosesCheckInDanKontrak(
        Booking $booking,
        ?string $kondisiAwal = null,
        string $siklusTagihan = 'bulanan',
        ?int $nominalDeposit = null
    ): Contract {
        return DB::transaction(function () use ($booking, $kondisiAwal, $siklusTagihan, $nominalDeposit) {
            $booking = Booking::with(['kamar', 'user'])->lockForUpdate()->findOrFail($booking->id);

            if ($booking->contract()->exists()) {
                return $booking->contract;
            }

            $kamar = $booking->kamar;
            $tanggalMulai = $booking->tanggal_masuk ?? today();
            $tanggalAkhir = match ($siklusTagihan) {
                'per_3_bulan' => Carbon::parse($tanggalMulai)->addMonths(3),
                'tahunan' => Carbon::parse($tanggalMulai)->addYear(),
                default => Carbon::parse($tanggalMulai)->addMonth(),
            };

            // 1. Buat Kontrak Sewa Aktif
            $contract = Contract::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'kamar_id' => $kamar->id,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_akhir' => $tanggalAkhir,
                'harga_sewa' => $kamar->harga,
                'siklus_tagihan' => $siklusTagihan,
                'kondisi_awal' => $kondisiAwal ?? 'Kamar dalam kondisi bersih, kunci lengkap, dan fasilitas berfungsi baik.',
                'status' => 'aktif',
            ]);

            // 2. Buat Security Deposit (Uang Jaminan)
            $depositAmount = $nominalDeposit ?? (int) Setting::getVal('nominal_deposit_default', 500000);
            SecurityDeposit::create([
                'contract_id' => $contract->id,
                'nominal_deposit' => $depositAmount,
                'potongan_kerusakan' => 0,
                'potongan_tunggakan' => 0,
                'nominal_dikembalikan' => $depositAmount,
                'status' => 'ditahan',
            ]);

            // 3. Aktifkan status penghuni di TenantProfile
            TenantProfile::updateOrCreate(
                ['user_id' => $booking->user_id],
                ['status_penghuni' => 'aktif']
            );

            // 4. Terbitkan Tagihan Pertama beserta Rincian Item (memperhitungkan DP jika sudah lunas)
            $this->terbitkanTagihanDenganItem($contract, $tanggalMulai->format('Y-m'), [], true);

            return $contract;
        });
    }

    /**
     * POIN 6: Terbitkan Tagihan (Invoice) beserta rincian item (sewa pokok, listrik, air, parkir, dll).
     */
    public function terbitkanTagihanDenganItem(
        Contract $contract,
        string $periode,
        array $biayaTambahan = [],
        bool $potongDpJikaAda = false
    ): Tagihan {
        return DB::transaction(function () use ($contract, $periode, $biayaTambahan, $potongDpJikaAda) {
            $existing = Tagihan::where('contract_id', $contract->id)
                ->where('periode', $periode)
                ->first();

            if ($existing) {
                return $existing;
            }

            $nomorInvoice = 'INV-' . str_replace('-', '', $periode) . '-' . str_pad((string) $contract->id, 4, '0', STR_PAD_LEFT) . '-' . rand(10, 99);

            $tagihan = Tagihan::create([
                'nomor_invoice' => $nomorInvoice,
                'booking_id' => $contract->booking_id,
                'contract_id' => $contract->id,
                'periode' => $periode,
                'jumlah' => 0,
                'denda' => 0,
                'tanggal_terbit' => today(),
                'tanggal_jatuh_tempo' => today()->addDays(7),
                'status' => 'belum_dibayar',
                'keterangan' => "Tagihan sewa kamar {$contract->kamar->nomor_kamar} periode {$periode}.",
            ]);

            // Item wajib: Sewa Pokok
            InvoiceItem::create([
                'tagihan_id' => $tagihan->id,
                'nama_item' => "Sewa Pokok Kamar {$contract->kamar->nomor_kamar} ({$periode})",
                'jenis' => 'sewa_pokok',
                'nominal' => $contract->harga_sewa,
            ]);

            $totalTagihan = $contract->harga_sewa;

            // Item tambahan (listrik, air, parkir, kebersihan, dll.)
            foreach ($biayaTambahan as $item) {
                $nominal = (int) ($item['nominal'] ?? 0);
                if ($nominal <= 0) {
                    continue;
                }

                InvoiceItem::create([
                    'tagihan_id' => $tagihan->id,
                    'nama_item' => $item['nama_item'],
                    'jenis' => $item['jenis'] ?? 'lainnya',
                    'nominal' => $nominal,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);

                $totalTagihan += $nominal;
            }

            $tagihan->update(['jumlah' => $totalTagihan]);

            // Jika DP booking sudah dibayar dan disetujui, catat sebagai pembayaran awal pada tagihan pertama
            if ($potongDpJikaAda && $contract->booking_id) {
                $dpTerbayar = (int) Pembayaran::where('booking_id', $contract->booking_id)
                    ->where('jenis_pembayaran', 'dp_booking')
                    ->where('status', 'disetujui')
                    ->sum('jumlah_bayar');

                if ($dpTerbayar > 0) {
                    Pembayaran::create([
                        'tagihan_id' => $tagihan->id,
                        'booking_id' => $contract->booking_id,
                        'jenis_pembayaran' => 'cicilan_tagihan',
                        'user_id' => $contract->user_id,
                        'metode_pembayaran' => 'transfer',
                        'jumlah_bayar' => min($dpTerbayar, $totalTagihan),
                        'tanggal_pembayaran' => today(),
                        'status' => 'disetujui',
                        'tanggal_verifikasi' => now(),
                        'catatan' => 'Konversi otomatis dari DP Booking yang telah diverifikasi.',
                    ]);

                    $this->hitungUlangSaldoTagihan($tagihan);
                }
            }

            return $tagihan->fresh(['items', 'pembayarans']);
        });
    }

    /**
     * POIN 6: Hitung & terapkan denda keterlambatan setelah melewati masa tenggang.
     */
    public function hitungDendaKeterlambatan(Tagihan $tagihan): Tagihan
    {
        if (in_array($tagihan->status, ['lunas', 'dibatalkan'], true)) {
            return $tagihan;
        }

        $masaTenggang = (int) Setting::getVal('masa_tenggang_hari', 3);
        $dendaHarian = (int) Setting::getVal('denda_harian', 25000);
        $batasDenda = $tagihan->tanggal_jatuh_tempo->copy()->addDays($masaTenggang);

        if (today()->gt($batasDenda)) {
            $hariTerlambat = $batasDenda->diffInDays(today());
            $totalDenda = $hariTerlambat * $dendaHarian;

            $tagihan->update([
                'denda' => $totalDenda,
                'status' => $tagihan->total_terbayar > 0 ? 'dibayar_sebagian' : 'terlambat',
            ]);
        }

        return $tagihan->fresh();
    }

    /**
     * POIN 7: Validasi Cicilan & Hitung Ulang Akumulasi Pembayaran + Sisa Tagihan.
     */
    public function hitungUlangSaldoTagihan(Tagihan $tagihan): Tagihan
    {
        $tagihan = $tagihan->fresh();
        $totalKewajiban = $tagihan->jumlah + $tagihan->denda;
        $totalTerbayar = (int) $tagihan->pembayarans()
            ->where('status', 'disetujui')
            ->sum('jumlah_bayar');

        $adaMenungguVerifikasi = $tagihan->pembayarans()
            ->where('status', 'menunggu_verifikasi')
            ->exists();

        if ($totalTerbayar >= $totalKewajiban && $totalKewajiban > 0) {
            $statusBaru = 'lunas';
        } elseif ($adaMenungguVerifikasi) {
            $statusBaru = 'menunggu_verifikasi';
        } elseif ($totalTerbayar > 0) {
            $statusBaru = 'dibayar_sebagian';
        } elseif (today()->gt($tagihan->tanggal_jatuh_tempo)) {
            $statusBaru = 'terlambat';
        } else {
            $statusBaru = 'belum_dibayar';
        }

        $tagihan->update(['status' => $statusBaru]);

        return $tagihan->fresh();
    }

    /**
     * POIN 8: Proses Check-Out, Perhitungan Potongan Deposit, dan Pelepasan Kamar.
     */
    public function prosesCheckOut(
        Contract $contract,
        string $kondisiAkhir,
        int $potonganKerusakan = 0,
        ?string $catatanPotongan = null,
        string $statusKamarSetelahCheckout = 'tersedia'
    ): array {
        if ($contract->status !== 'aktif') {
            throw new RuntimeException('Kontrak ini sudah tidak aktif.');
        }

        return DB::transaction(function () use (
            $contract,
            $kondisiAkhir,
            $potonganKerusakan,
            $catatanPotongan,
            $statusKamarSetelahCheckout
        ) {
            $contract = Contract::with(['kamar', 'booking', 'deposit', 'tagihans'])
                ->lockForUpdate()
                ->findOrFail($contract->id);

            // 1. Hitung sisa tunggakan tagihan yang belum lunas pada kontrak ini
            $sisaTunggakan = 0;
            foreach ($contract->tagihans as $tagihan) {
                if (!in_array($tagihan->status, ['lunas', 'dibatalkan'], true)) {
                    $sisaTunggakan += $tagihan->sisa_tagihan;
                }
            }

            // 2. Hitung potongan dan pengembalian Security Deposit
            $deposit = $contract->deposit;
            $ringkasanDeposit = null;

            if ($deposit) {
                $totalPotongan = $potonganKerusakan + $sisaTunggakan;
                $dikembalikan = max(0, $deposit->nominal_deposit - $totalPotongan);

                $statusDeposit = match (true) {
                    $dikembalikan === $deposit->nominal_deposit => 'dikembalikan_penuh',
                    $dikembalikan > 0 => 'dikembalikan_sebagian',
                    default => 'hangus',
                };

                $deposit->update([
                    'potongan_kerusakan' => $potonganKerusakan,
                    'potongan_tunggakan' => $sisaTunggakan,
                    'nominal_dikembalikan' => $dikembalikan,
                    'catatan_potongan' => $catatanPotongan,
                    'status' => $statusDeposit,
                    'tanggal_pengembalian' => today(),
                ]);

                $ringkasanDeposit = $deposit->fresh();
            }

            // 3. Tutup Kontrak & Booking terkait
            $contract->update([
                'tanggal_akhir' => today(),
                'kondisi_akhir' => $kondisiAkhir,
                'status' => 'selesai',
            ]);

            if ($contract->booking) {
                $contract->booking->update([
                    'tanggal_keluar' => today(),
                    'status' => 'selesai',
                ]);
            }

            // 4. Ubah status penghuni menjadi keluar
            TenantProfile::where('user_id', $contract->user_id)
                ->update(['status_penghuni' => 'keluar']);

            // 5. Kurangi jumlah penghuni kamar dan perbarui status kamar ('tersedia' atau 'maintenance')
            $kamar = $contract->kamar;
            $penghuniBaru = max(0, $kamar->jumlah_penghuni - 1);
            $kamar->jumlah_penghuni = $penghuniBaru;

            if ($statusKamarSetelahCheckout === 'maintenance') {
                $kamar->status = 'maintenance';
                $kamar->save();
            } else {
                $kamar->status = 'tersedia';
                $kamar->perbaruiStatusOtomatis();
            }

            return [
                'contract' => $contract->fresh(),
                'deposit' => $ringkasanDeposit,
                'sisa_tunggakan' => $sisaTunggakan,
            ];
        });
    }
}