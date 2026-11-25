<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminPetugasSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@koshaven.test'],
            [
                'name' => 'Admin KosHaven',
                'phone' => '081234567890',
                'password' => Hash::make('AdminKos123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'petugas@koshaven.test'],
            [
                'name' => 'Petugas KosHaven',
                'phone' => '081234567891',
                'password' => Hash::make('PetugasKos123'),
                'role' => 'petugas',
            ]
        );
    }
}