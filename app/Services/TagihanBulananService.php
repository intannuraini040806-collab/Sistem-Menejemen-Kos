<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TagihanBulananService
{
    /**
     * Membuat tagihan bulanan untuk semua booking yang memenuhi syarat.
     */
    public function terbitkanSemua(): array
    {
        $hasil = [
            'diperiksa' => 0,
            'dibuat' => 0,
            'terlambat' => 0,
        ];

        Booking::with('kamar')
            ->whereIn('status', ['disetujui', 'selesai'])
            ->orderBy('id')
            ->chunkById(100, function ($bookings) use (&$hasil) {
                foreach ($bookings as $booking) {
                    $hasil['diperiksa']++;

                    $jumlah = $this->terbitkanUntukBooking($booking);

                    $hasil['dibuat'] += $jumlah['dibuat'];
                    $hasil['terlambat'] += $jumlah['terlambat'];
                }
            });

        return $hasil;
    }

    /**
     * Membuat tagihan bulanan untuk satu booking.
     */
    public function terbitkanUntukBooking(Booking $booking): array
    {
        return DB::transaction(function () use ($booking) {
            $booking = Booking::with('kamar')
                ->lockForUpdate()
                ->findOrFail($booking->id);

            $hasil = [
                'dibuat' => 0,
                'terlambat' => 0,
            ];

            if (!in_array($booking->status, [
                'disetujui',
                'selesai',
            ], true)) {
                return $hasil;
            }

            if (!$booking->kamar) {
                return $hasil;
            }

            if (!$booking->tanggal_masuk) {
                return $hasil;
            }

            $tanggalMasuk = Carbon::parse(
                $booking->tanggal_masuk
            )->startOfDay();

            $tanggalKeluar = $booking->tanggal_keluar
                ? Carbon::parse($booking->tanggal_keluar)->startOfDay()
                : null;

            $hariIni = today();

            // Booking yang belum dimulai tidak boleh ditagih.
            if ($tanggalMasuk->gt($hariIni)) {
                return $hasil;
            }

            // Booking selesai harus memiliki tanggal keluar.
            if (
                $booking->status === 'selesai'
                && !$tanggalKeluar
            ) {
                return $hasil;
            }

            if ($tanggalKeluar && $tanggalKeluar->lt($tanggalMasuk)) {
                return $hasil;
            }

            $periodeAwal = $tanggalMasuk->copy()->startOfMonth();

            $periodeAkhir = $hariIni->copy()->startOfMonth();

            if ($tanggalKeluar) {
                $bulanKeluar = $tanggalKeluar->copy()->startOfMonth();

                if ($bulanKeluar->lt($periodeAkhir)) {
                    $periodeAkhir = $bulanKeluar;
                }
            }

            for (
                $periode = $periodeAwal->copy();
                $periode->lte($periodeAkhir);
                $periode->addMonth()
            ) {
                // Tanggal tagihan mengikuti tanggal masuk setiap bulan.
                $tanggalTerbit = $this->tanggalBulanan(
                    $tanggalMasuk,
                    $periode
                );

                // Belum waktunya menerbitkan tagihan bulan ini.
                if ($tanggalTerbit->gt($hariIni)) {
                    continue;
                }

                // Jika penghuni keluar sebelum tanggal penagihan,
                // bulan tersebut tidak diterbitkan.
                if (
                    $tanggalKeluar
                    && $tanggalTerbit->gt($tanggalKeluar)
                ) {
                    continue;
                }

                $kodePeriode = $periode->format('Y-m');

                $tagihan = Tagihan::firstOrCreate(
                    [
                        'booking_id' => $booking->id,
                        'periode' => $kodePeriode,
                    ],
                    [
                        'jumlah' => $booking->kamar->harga,
                        'tanggal_terbit' => $tanggalTerbit->toDateString(),
                        'tanggal_jatuh_tempo' => $tanggalTerbit
                            ->copy()
                            ->addDays(7)
                            ->toDateString(),
                        'status' => 'belum_dibayar',
                        'keterangan' => 'Tagihan sewa kamar periode '
                            . $kodePeriode,
                    ]
                );

                if ($tagihan->wasRecentlyCreated) {
                    $hasil['dibuat']++;
                }

                // Jangan mengubah tagihan lunas atau yang sedang
                // menunggu verifikasi pembayaran.
                if (
                    $tagihan->status === 'belum_dibayar'
                    && $tagihan->tanggal_jatuh_tempo
                    && $tagihan->tanggal_jatuh_tempo->lt($hariIni)
                ) {
                    $tagihan->update([
                        'status' => 'terlambat',
                    ]);

                    $hasil['terlambat']++;
                }
            }

            return $hasil;
        }, 3);
    }

    /**
     * Menentukan tanggal penagihan bulanan.
     * Contoh: tanggal masuk 31 Januari akan menggunakan
     * tanggal terakhir bulan Februari.
     */
    private function tanggalBulanan(
        Carbon $tanggalMasuk,
        Carbon $periode
    ): Carbon {
        $tanggal = $periode->copy()->startOfMonth();

        $hari = min(
            $tanggalMasuk->day,
            $tanggal->daysInMonth
        );

        return $tanggal->day($hari)->startOfDay();
    }
}
