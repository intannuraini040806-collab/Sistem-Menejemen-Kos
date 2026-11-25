<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan role hanya jika kolomnya belum tersedia.
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 20)
                    ->default('penghuni')
                    ->after('password')
                    ->index();
            });
        }
    }

    public function down(): void
    {
        // Kolom role tidak dihapus otomatis karena mungkin
        // sudah tersedia sebelum migration ini dijalankan.
    }
};