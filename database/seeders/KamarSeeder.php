<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitasSingle = [
            'AC',
            'Wi-Fi',
            'Lemari',
            'Meja',
        ];

        $fasilitasDouble = [
            'AC',
            'Wi-Fi',
            'CCTV',
            'Lemari',
            'Meja',
        ];

        /*
         * 15 kamar Single: A01 sampai A15.
         */
        for ($i = 1; $i <= 15; $i++) {
            $nomor = 'A' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $penghuni = $i <= 4 ? 1 : 0;

            $status = match (true) {
                $i === 5 => 'maintenance',
                $penghuni >= 1 => 'terisi',
                default => 'tersedia',
            };

            Kamar::firstOrCreate(
                ['nomor_kamar' => $nomor],
                [
                    'tipe' => 'single',
                    'harga' => 1500000,
                    'kapasitas' => 1,
                    'jumlah_penghuni' => $penghuni,
                    'deskripsi' => 'Kamar Single yang nyaman untuk satu penghuni.',
                    'fasilitas' => $fasilitasSingle,
                    'jenis_kamar_mandi' => 'dalam_kamar',
                    'foto' => null,
                    'status' => $status,
                ]
            );
        }

        /*
         * 15 kamar Double: B01 sampai B15.
         */
        for ($i = 1; $i <= 15; $i++) {
            $nomor = 'B' . str_pad($i, 2, '0', STR_PAD_LEFT);

            $penghuni = $i <= 4 ? 2 : 0;

            $status = match (true) {
                $i === 5 => 'maintenance',
                $penghuni >= 2 => 'terisi',
                default => 'tersedia',
            };

            Kamar::firstOrCreate(
                ['nomor_kamar' => $nomor],
                [
                    'tipe' => 'double',
                    'harga' => 2000000,
                    'kapasitas' => 2,
                    'jumlah_penghuni' => $penghuni,
                    'deskripsi' => 'Kamar Double yang nyaman untuk dua penghuni.',
                    'fasilitas' => $fasilitasDouble,
                    'jenis_kamar_mandi' => 'dalam_kamar',
                    'foto' => null,
                    'status' => $status,
                ]
            );
        }

        $this->command->info('Seeder kamar berhasil dijalankan.');
        $this->command->info('Target data: 30 kamar.');
    }
}
