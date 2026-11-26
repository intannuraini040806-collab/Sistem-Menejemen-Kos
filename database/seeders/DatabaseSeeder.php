<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Test User jika belum tersedia.
        User::firstOrCreate(
            [
                'email' => 'test@example.com',
            ],
            [
                'name' => 'Test User',
                'password' => 'password123',
                'role' => 'penghuni',
            ]
        );

        // Menjalankan seeder data KosHaven.
        $this->call([
            KamarSeeder::class,
            BookingSeeder::class,
            TagihanSeeder::class,
            PembayaranSeeder::class,
            MasterKonsepSeeder::class,
        ]);
    }
}
