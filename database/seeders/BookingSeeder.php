<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            /*
             * 1. Daftar nama untuk 18 akun penghuni.
             */
            $namaPenghuni = [
                'Aini Rahmawati',
                'Andi Pratama',
                'Siti Rahma',
                'Budi Santoso',
                'Dina Putri',
                'Rizky Maulana',
                'Nadia Safitri',
                'Fajar Ramadhan',
                'Putri Amelia',
                'Dimas Saputra',
                'Nabila Azzahra',
                'Reza Firmansyah',
                'Ayu Lestari',
                'Rian Kurniawan',
                'Maya Salsabila',
                'Aditya Prakoso',
                'Fitri Handayani',
                'Yoga Pratama',
            ];

            /*
             * 2. Ambil akun penghuni yang sudah tersedia.
             * Akun lama tetap digunakan agar ID dan relasinya aman.
             */
            $users = User::where('role', 'penghuni')
                ->orderBy('id')
                ->limit(18)
                ->get()
                ->values();

            $phoneAvailable = Schema::hasColumn('users', 'phone');

            /*
             * 3. Buat akun baru hanya jika jumlahnya belum 18.
             */
            while ($users->count() < 18) {
                $number = $users->count() + 1;

                $email = 'penghuni' .
                    str_pad($number, 2, '0', STR_PAD_LEFT) .
                    '@koshaven.test';

                $existingUser = User::where('email', $email)->first();

                if ($existingUser) {
                    if ($existingUser->role !== 'penghuni') {
                        throw new RuntimeException(
                            "Email {$email} sudah digunakan oleh akun non-penghuni."
                        );
                    }

                    $users->push($existingUser);
                    continue;
                }

                $attributes = [
                    'name' => $namaPenghuni[$number - 1],
                    'email' => $email,
                    'password' => 'password123',
                    'role' => 'penghuni',
                ];

                if ($phoneAvailable) {
                    $attributes['phone'] =
                        '08130000' .
                        str_pad($number, 4, '0', STR_PAD_LEFT);
                }

                $user = User::create($attributes);

                $users->push($user);
            }

            /*
             * 4. Perbarui nama akun penghuni yang sudah ada.
             * Tidak mengubah ID, email, password, maupun nomor HP.
             */
            foreach ($users as $index => $user) {
                $user->name = $namaPenghuni[$index];
                $user->save();
            }

            /*
             * 5. Ambil kamar yang tersedia dan terisi.
             * Kamar maintenance tidak digunakan.
             */
            $kamarTerisi = Kamar::where('status', 'terisi')
                ->orderBy('nomor_kamar')
                ->take(5)
                ->get();

            $kamarTersedia = Kamar::where('status', 'tersedia')
                ->orderBy('nomor_kamar')
                ->take(13)
                ->get();

            $kamars = $kamarTerisi
                ->concat($kamarTersedia)
                ->values();

            if ($kamars->count() < 18) {
                throw new RuntimeException(
                    'Dibutuhkan minimal 18 kamar non-maintenance untuk membuat data booking.'
                );
            }

            /*
             * 6. Variasi status booking.
             */
            $statuses = [
                'disetujui',
                'disetujui',
                'disetujui',
                'disetujui',
                'disetujui',

                'menunggu',
                'menunggu',
                'menunggu',
                'menunggu',

                'ditolak',
                'ditolak',
                'ditolak',

                'dibatalkan',
                'dibatalkan',

                'selesai',
                'selesai',
                'selesai',
                'selesai',
            ];

            /*
             * 7. Buat atau perbarui 18 data booking.
             */
            foreach ($users as $index => $user) {
                $status = $statuses[$index];
                $kamar = $kamars[$index];

                $tanggalBooking = now()
                    ->subDays(20 + $index);

                if ($status === 'selesai') {
                    $tanggalMasuk = now()
                        ->subDays(90 + $index);

                    $tanggalKeluar = now()
                        ->subDays(10 + $index);
                } elseif ($status === 'disetujui') {
                    $tanggalMasuk = now()
                        ->subDays(10 + $index);

                    $tanggalKeluar = null;
                } else {
                    $tanggalMasuk = now()
                        ->addDays(7 + $index);

                    $tanggalKeluar = null;
                }

                $catatan = 'Data dummy dari BookingSeeder';

                $alasanPenolakan = $status === 'ditolak'
                    ? 'Kamar tidak tersedia pada tanggal yang diminta.'
                    : null;

                DB::table('bookings')->updateOrInsert(
                    [
                        'user_id' => $user->id,
                        'catatan' => $catatan,
                    ],
                    [
                        'kamar_id' => $kamar->id,
                        'tanggal_booking' => $tanggalBooking->toDateString(),
                        'tanggal_masuk' => $tanggalMasuk->toDateString(),
                        'tanggal_keluar' => $tanggalKeluar?->toDateString(),
                        'status' => $status,
                        'alasan_penolakan' => $alasanPenolakan,
                        'updated_at' => now(),
                        'created_at' => $tanggalBooking,
                    ]
                );
            }
        });

        $this->command->info('Seeder booking berhasil dijalankan.');
        $this->command->info('Total akun penghuni: 18.');
        $this->command->info('Nama akun penghuni berhasil diperbarui.');
        $this->command->info('Target data booking: 18.');
    }
}