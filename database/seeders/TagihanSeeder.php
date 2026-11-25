<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Tagihan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $bookings = Booking::with('kamar')
                ->whereIn('status', ['disetujui', 'selesai'])
                ->orderBy('id')
                ->get();

            if ($bookings->isEmpty()) {
                $this->command->warn(
                    'Tidak ada booking disetujui atau selesai. Seeder tagihan dilewati.'
                );

                return;
            }

            $jumlahDibuat = 0;

            foreach ($bookings as $index => $booking) {
                if (!$booking->kamar) {
                    continue;
                }

                $tanggalMasuk = \Illuminate\Support\Carbon::parse(
                    $booking->tanggal_masuk
                );

                $periode = $tanggalMasuk->format('Y-m');

                $tanggalTerbit = $tanggalMasuk->copy();

                $tanggalJatuhTempo = $tanggalTerbit
                    ->copy()
                    ->addDays(7);

                /*
                 * Status dibuat bervariasi.
                 * Tagihan yang lunas atau menunggu verifikasi
                 * akan dibuat pada tahap pembayaran nanti.
                 */
                $status = ($index % 3 === 0)
                    ? 'terlambat'
                    : 'belum_dibayar';

                $tagihan = Tagihan::firstOrCreate(
                    [
                        'booking_id' => $booking->id,
                        'periode' => $periode,
                    ],
                    [
                        'jumlah' => $booking->kamar->harga,
                        'tanggal_terbit' => $tanggalTerbit->toDateString(),
                        'tanggal_jatuh_tempo' => $tanggalJatuhTempo->toDateString(),
                        'status' => $status,
                        'keterangan' => 'Tagihan sewa kamar periode ' . $periode,
                    ]
                );

                if ($tagihan->wasRecentlyCreated) {
                    $jumlahDibuat++;
                }
            }

            $this->command->info(
                "Seeder tagihan berhasil dijalankan. {$jumlahDibuat} tagihan baru dibuat."
            );
        });
    }
}
