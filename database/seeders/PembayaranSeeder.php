<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $tagihans = Tagihan::with('booking')
                ->orderBy('id')
                ->get();

            if ($tagihans->isEmpty()) {
                throw new RuntimeException(
                    'Belum ada data tagihan. Jalankan TagihanSeeder terlebih dahulu.'
                );
            }

            $verifikator = User::whereIn('role', ['admin', 'petugas'])
                ->orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")
                ->first();

            if (!$verifikator) {
                throw new RuntimeException(
                    'Akun Admin atau Petugas belum tersedia untuk verifikasi pembayaran.'
                );
            }

            $statuses = [
                'disetujui',
                'disetujui',
                'disetujui',
                'disetujui',
                'menunggu_verifikasi',
                'menunggu_verifikasi',
                'menunggu_verifikasi',
                'ditolak',
                'ditolak',
            ];

            $jumlahDibuat = 0;

            foreach ($tagihans as $index => $tagihan) {
                if (!$tagihan->booking) {
                    continue;
                }

                $booking = $tagihan->booking;
                $status = $statuses[$index % count($statuses)];

                $tanggalPembayaran = now()
                    ->subDays(8 + $index);

                $tanggalVerifikasi = $status === 'menunggu_verifikasi'
                    ? null
                    : $tanggalPembayaran->copy()->addDay();

                $metode = $index % 2 === 0
                    ? 'transfer'
                    : 'tunai';

                $pembayaran = Pembayaran::firstOrCreate(
                    [
                        'tagihan_id' => $tagihan->id,
                    ],
                    [
                        'user_id' => $booking->user_id,
                        'metode_pembayaran' => $metode,
                        'jumlah_bayar' => $tagihan->jumlah,
                        'tanggal_pembayaran' => $tanggalPembayaran->toDateString(),
                        'bukti_pembayaran' => null,
                        'status' => $status,
                        'diverifikasi_oleh' => $status === 'menunggu_verifikasi'
                            ? null
                            : $verifikator->id,
                        'tanggal_verifikasi' => $tanggalVerifikasi,
                        'catatan' => 'Data dummy dari PembayaranSeeder',
                    ]
                );

                if ($pembayaran->wasRecentlyCreated) {
                    $jumlahDibuat++;
                }

                /*
                 * Sesuaikan status tagihan berdasarkan
                 * status pembayaran yang tersimpan.
                 */
                if ($pembayaran->status === 'disetujui') {
                    $tagihan->update([
                        'status' => 'lunas',
                    ]);
                } elseif ($pembayaran->status === 'menunggu_verifikasi') {
                    $tagihan->update([
                        'status' => 'menunggu_verifikasi',
                    ]);
                }
            }

            $this->command->info(
                "Seeder pembayaran berhasil dijalankan. {$jumlahDibuat} pembayaran baru dibuat."
            );
        });
    }
}
