<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PembayaranService
{
    public function __construct(
        protected KosBusinessService $kosService
    ) {}

    /**
     * Mengajukan pembayaran tagihan (lunas atau cicilan) oleh penghuni.
     *
     * @return array{ok: bool, status: int, message: string, pembayaran?: Pembayaran, tagihan?: Tagihan}
     */
    public function ajukanPembayaranTagihan(
        User $user,
        Tagihan $tagihan,
        array $data,
        ?UploadedFile $buktiFile = null
    ): array {
        $buktiPath = null;

        if ($buktiFile !== null) {
            $folder = 'bukti-pembayaran/' . now()->format('Y-m');
            $buktiPath = $buktiFile->store($folder, 'public');
        }

        try {
            $hasil = DB::transaction(function () use ($user, $tagihan, $data, $buktiPath) {
                $lockedTagihan = Tagihan::with('booking')
                    ->whereKey($tagihan->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! $lockedTagihan->booking || (int) $lockedTagihan->booking->user_id !== (int) $user->id) {
                    return [
                        'ok' => false,
                        'status' => 403,
                        'message' => 'Anda tidak memiliki akses ke tagihan ini.',
                    ];
                }

                if ($lockedTagihan->status === 'lunas') {
                    return [
                        'ok' => false,
                        'status' => 422,
                        'message' => 'Tagihan ini sudah berstatus lunas.',
                    ];
                }

                $adaMenunggu = Pembayaran::where('tagihan_id', $lockedTagihan->id)
                    ->where('status', 'menunggu_verifikasi')
                    ->exists();

                if ($adaMenunggu) {
                    return [
                        'ok' => false,
                        'status' => 422,
                        'message' => 'Tagihan ini sudah memiliki pembayaran yang sedang menunggu verifikasi.',
                    ];
                }

                $lockedTagihan = $this->kosService->hitungDendaKeterlambatan($lockedTagihan);
                $sisaTagihan = $lockedTagihan->sisa_tagihan;
                $jumlahBayar = (int) $data['jumlah_bayar'];

                if ($jumlahBayar <= 0) {
                    return [
                        'ok' => false,
                        'status' => 422,
                        'message' => 'Nominal pembayaran harus lebih dari Rp 0.',
                    ];
                }

                if ($jumlahBayar > $sisaTagihan) {
                    return [
                        'ok' => false,
                        'status' => 422,
                        'message' => 'Nominal pembayaran melebihi sisa tagihan (Rp ' . number_format($sisaTagihan, 0, ',', '.') . ').',
                    ];
                }

                $catatan = isset($data['catatan']) && trim((string) $data['catatan']) !== ''
                    ? trim((string) $data['catatan'])
                    : null;

                $pembayaran = Pembayaran::create([
                    'tagihan_id' => $lockedTagihan->id,
                    'booking_id' => $lockedTagihan->booking_id,
                    'jenis_pembayaran' => 'cicilan_tagihan',
                    'user_id' => $user->id,
                    'metode_pembayaran' => $data['metode_pembayaran'],
                    'jumlah_bayar' => $jumlahBayar,
                    'tanggal_pembayaran' => $data['tanggal_pembayaran'],
                    'bukti_pembayaran' => $buktiPath,
                    'status' => 'menunggu_verifikasi',
                    'catatan' => $catatan,
                ]);

                $tagihanTerbaru = $this->kosService->hitungUlangSaldoTagihan($lockedTagihan);

                return [
                    'ok' => true,
                    'status' => 201,
                    'message' => 'Pembayaran berhasil dikirim dan sedang menunggu verifikasi petugas/admin.',
                    'pembayaran' => $pembayaran,
                    'tagihan' => $tagihanTerbaru,
                ];
            }, 3);

            if (! $hasil['ok'] && $buktiPath) {
                Storage::disk('public')->delete($buktiPath);
            }

            return $hasil;
        } catch (Throwable $e) {
            if ($buktiPath) {
                Storage::disk('public')->delete($buktiPath);
            }

            throw $e;
        }
    }

    /**
     * Memverifikasi (menyetujui) pembayaran oleh Admin atau Petugas.
     *
     * @return array{ok: bool, message: string, pembayaran?: Pembayaran, tagihan?: Tagihan}
     */
    public function verifikasiPembayaran(Pembayaran $pembayaran, User $verifikator): array
    {
        $roleLabel = $verifikator->isAdmin() ? 'admin' : 'petugas';

        return DB::transaction(function () use ($pembayaran, $verifikator, $roleLabel) {
            $dataPembayaran = Pembayaran::whereKey($pembayaran->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($dataPembayaran->status !== 'menunggu_verifikasi') {
                return [
                    'ok' => false,
                    'message' => 'Pembayaran ini sudah pernah diproses.',
                ];
            }

            if ($dataPembayaran->jenis_pembayaran === 'dp_booking') {
                $booking = Booking::whereKey($dataPembayaran->booking_id)
                    ->lockForUpdate()
                    ->first();

                if (! $booking) {
                    return [
                        'ok' => false,
                        'message' => 'Data booking terkait tidak ditemukan.',
                    ];
                }

                if ((int) $dataPembayaran->jumlah_bayar < (int) $booking->nominal_dp) {
                    return [
                        'ok' => false,
                        'message' => 'Nominal transfer DP kurang dari ketentuan minimum DP.',
                    ];
                }

                $dataPembayaran->update([
                    'status' => 'disetujui',
                    'diverifikasi_oleh' => $verifikator->id,
                    'tanggal_verifikasi' => now(),
                    'catatan' => "Pembayaran DP booking berhasil diverifikasi oleh {$roleLabel}.",
                ]);

                $dataPembayaran->terbitkanKuitansi();

                return [
                    'ok' => true,
                    'message' => 'Pembayaran DP booking berhasil diverifikasi. Silakan setujui booking untuk check-in penghuni.',
                    'pembayaran' => $dataPembayaran->fresh(),
                ];
            }

            $tagihan = Tagihan::whereKey($dataPembayaran->tagihan_id)
                ->lockForUpdate()
                ->first();

            if (! $tagihan) {
                return [
                    'ok' => false,
                    'message' => 'Tagihan yang terkait tidak ditemukan.',
                ];
            }

            if ($tagihan->status === 'lunas') {
                return [
                    'ok' => false,
                    'message' => 'Tagihan ini sudah berstatus lunas.',
                ];
            }

            if ((int) $dataPembayaran->jumlah_bayar <= 0) {
                return [
                    'ok' => false,
                    'message' => 'Nominal pembayaran harus lebih dari 0.',
                ];
            }

            if ((int) $dataPembayaran->jumlah_bayar > $tagihan->sisa_tagihan) {
                return [
                    'ok' => false,
                    'message' => 'Nominal pembayaran melebihi sisa tagihan yang harus dibayar.',
                ];
            }

            $dataPembayaran->update([
                'status' => 'disetujui',
                'diverifikasi_oleh' => $verifikator->id,
                'tanggal_verifikasi' => now(),
                'catatan' => "Pembayaran berhasil diverifikasi oleh {$roleLabel}.",
            ]);

            $dataPembayaran->terbitkanKuitansi();

            $tagihanTerbaru = $this->kosService->hitungUlangSaldoTagihan($tagihan);

            $pesan = $tagihanTerbaru->status === 'lunas'
                ? 'Pembayaran berhasil diverifikasi dan tagihan telah lunas.'
                : 'Cicilan pembayaran berhasil diverifikasi. Status tagihan diperbarui menjadi dibayar sebagian.';

            return [
                'ok' => true,
                'message' => $pesan,
                'pembayaran' => $dataPembayaran->fresh(),
                'tagihan' => $tagihanTerbaru,
            ];
        }, 3);
    }

    /**
     * Menolak pembayaran oleh Admin atau Petugas dan menghitung ulang saldo tagihan.
     *
     * @return array{ok: bool, message: string, reason?: string, pembayaran?: Pembayaran}
     */
    public function tolakPembayaran(Pembayaran $pembayaran, User $verifikator, string $alasan): array
    {
        $alasanBersih = trim($alasan);

        return DB::transaction(function () use ($pembayaran, $verifikator, $alasanBersih) {
            $dataPembayaran = Pembayaran::whereKey($pembayaran->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($dataPembayaran->status !== 'menunggu_verifikasi') {
                return [
                    'ok' => false,
                    'message' => 'Pembayaran ini sudah pernah diproses.',
                ];
            }

            $dataPembayaran->update([
                'status' => 'ditolak',
                'diverifikasi_oleh' => $verifikator->id,
                'tanggal_verifikasi' => now(),
                'catatan' => $alasanBersih,
            ]);

            if ($dataPembayaran->tagihan_id) {
                $tagihan = Tagihan::whereKey($dataPembayaran->tagihan_id)
                    ->lockForUpdate()
                    ->first();

                if ($tagihan) {
                    $this->kosService->hitungUlangSaldoTagihan($tagihan);
                }
            }

            return [
                'ok' => true,
                'message' => 'Pembayaran berhasil ditolak. Status tagihan telah diperbarui.',
                'reason' => $alasanBersih,
                'pembayaran' => $dataPembayaran->fresh(),
            ];
        }, 3);
    }
}
