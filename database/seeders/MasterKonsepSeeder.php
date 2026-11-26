<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\BankAccount;
use App\Models\Facility;
use App\Models\Kamar;
use App\Models\Setting;
use App\Models\TenantProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterKonsepSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Uji untuk 3 Role (Admin, Petugas, Penghuni)
        $admin = User::updateOrCreate(
            ['email' => 'admin@kos.test'],
            [
                'name' => 'Admin Pengelola Kos',
                'phone' => '081234567890',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@kos.test'],
            [
                'name' => 'Petugas Operasional',
                'phone' => '081234567891',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
            ]
        );

        $penghuni = User::updateOrCreate(
            ['email' => 'penghuni@kos.test'],
            [
                'name' => 'Budi Santoso',
                'phone' => '081234567892',
                'password' => Hash::make('password123'),
                'role' => 'penghuni',
            ]
        );

        TenantProfile::updateOrCreate(
            ['user_id' => $penghuni->id],
            [
                'nik' => '3526011205000001',
                'alamat_asal' => 'Jl. Raya Telang No. 10, Bangkalan',
                'pekerjaan' => 'Mahasiswa',
                'kontak_darurat_nama' => 'Siti Aminah (Ibu)',
                'kontak_darurat_telepon' => '081298765432',
                'status_penghuni' => 'calon',
            ]
        );

        // 2. Master Fasilitas Kamar & Umum
        $fasilitasData = [
            ['nama' => 'AC', 'ikon' => 'snowflake', 'kategori' => 'kamar'],
            ['nama' => 'Wi-Fi', 'ikon' => 'wifi', 'kategori' => 'kamar'],
            ['nama' => 'Lemari', 'ikon' => 'archive', 'kategori' => 'kamar'],
            ['nama' => 'Meja', 'ikon' => 'monitor', 'kategori' => 'kamar'],
            ['nama' => 'Kasur Springbed', 'ikon' => 'bed', 'kategori' => 'kamar'],
            ['nama' => 'Parkir Motor Luas', 'ikon' => 'bike', 'kategori' => 'umum'],
            ['nama' => 'Dapur Bersama', 'ikon' => 'utensils', 'kategori' => 'umum'],
            ['nama' => 'CCTV 24 Jam', 'ikon' => 'video', 'kategori' => 'umum'],
            ['nama' => 'Laundry', 'ikon' => 'shirt', 'kategori' => 'umum'],
        ];

        $facilityMap = [];
        foreach ($fasilitasData as $item) {
            $fac = Facility::firstOrCreate(['nama' => $item['nama']], $item);
            $facilityMap[$item['nama']] = $fac->id;
        }

        // 3. Sinkronkan Kamar yang sudah ada (atau buat default jika kosong)
        if (Kamar::count() === 0) {
            $defaultKamars = [
                [
                    'nomor_kamar' => 'A01',
                    'tipe' => 'single',
                    'harga' => 1500000,
                    'kapasitas' => 1,
                    'jumlah_penghuni' => 0,
                    'jenis_kamar_mandi' => 'dalam_kamar',
                    'status' => 'tersedia',
                    'fasilitas' => ['AC', 'Wi-Fi', 'Lemari', 'Meja'],
                    'deskripsi' => 'Kamar Single nyaman dengan kamar mandi dalam dan sirkulasi udara baik.',
                ],
                [
                    'nomor_kamar' => 'A02',
                    'tipe' => 'single',
                    'harga' => 1500000,
                    'kapasitas' => 1,
                    'jumlah_penghuni' => 0,
                    'jenis_kamar_mandi' => 'bersama',
                    'status' => 'tersedia',
                    'fasilitas' => ['Wi-Fi', 'Lemari', 'Meja'],
                    'deskripsi' => 'Kamar Single ekonomis dekat area dapur bersama.',
                ],
                [
                    'nomor_kamar' => 'B01',
                    'tipe' => 'double',
                    'harga' => 2000000,
                    'kapasitas' => 2,
                    'jumlah_penghuni' => 0,
                    'jenis_kamar_mandi' => 'dalam_kamar',
                    'status' => 'tersedia',
                    'fasilitas' => ['AC', 'Wi-Fi', 'Lemari', 'Meja', 'Laundry'],
                    'deskripsi' => 'Kamar Double luas untuk 2 orang lengkap dengan AC dan kamar mandi dalam.',
                ],
            ];

            foreach ($defaultKamars as $kData) {
                Kamar::create($kData);
            }
        }

        // Hubungkan setiap kamar ke tabel pivot facility_kamar
        Kamar::all()->each(function (Kamar $kamar) use ($facilityMap) {
            $names = is_array($kamar->fasilitas) ? $kamar->fasilitas : [];
            $ids = collect($names)
                ->map(fn ($name) => $facilityMap[$name] ?? null)
                ->filter()
                ->values()
                ->all();

            if (!empty($ids)) {
                $kamar->facilities()->syncWithoutDetaching($ids);
            }
        });

        // 4. Pengaturan Kos & Kebijakan Bisnis (DP, Tenggat, Denda, WA)
        $settings = [
            'nama_kos' => 'Kos Harmoni Residence',
            'alamat_kos' => 'Jl. Trunojoyo No. 45, Bangkalan, Jawa Timur',
            'whatsapp_pengelola' => '6281234567890',
            'dp_tipe' => 'persentase', // 'persentase' atau 'nominal'
            'dp_nilai' => '30', // 30% dari harga sewa
            'tenggat_dp_jam' => '24', // batas bayar DP 24 jam
            'kebijakan_dp' => 'DP minimal 30% dibayarkan maksimal 24 jam setelah booking. Pembatalan sepihak oleh calon penghuni menyebabkan DP hangus 50%.',
            'nominal_deposit_default' => '500000',
            'masa_tenggang_hari' => '3', // 3 hari setelah jatuh tempo sebelum kena denda
            'denda_harian' => '25000', // Rp 25.000 per hari keterlambatan
        ];

        foreach ($settings as $key => $value) {
            Setting::setVal($key, $value);
        }

        // 5. Rekening Bank Pembayaran Manual
        BankAccount::firstOrCreate(
            ['nomor_rekening' => '1234567890'],
            [
                'nama_bank' => 'BCA',
                'atas_nama' => 'Pengelola Kos Harmoni',
                'is_aktif' => true,
            ]
        );

        BankAccount::firstOrCreate(
            ['nomor_rekening' => '0987654321'],
            [
                'nama_bank' => 'BRI',
                'atas_nama' => 'Pengelola Kos Harmoni',
                'is_aktif' => true,
            ]
        );

        // 6. Pengumuman Awal
        Announcement::firstOrCreate(
            ['judul' => 'Selamat Datang di Sistem Manajemen Kos'],
            [
                'dibuat_oleh' => $admin->id,
                'isi' => 'Harap melakukan pembayaran tagihan bulanan sebelum tanggal jatuh tempo untuk menghindari denda keterlambatan.',
                'is_aktif' => true,
            ]
        );
    }
}