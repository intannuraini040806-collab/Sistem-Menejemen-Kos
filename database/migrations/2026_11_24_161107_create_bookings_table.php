<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('kamar_id')
                ->constrained('kamars')
                ->restrictOnDelete();

            $table->date('tanggal_booking');

            $table->date('tanggal_masuk');

            $table->date('tanggal_keluar')->nullable();

            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'dibatalkan',
                'selesai',
            ])->default('menunggu')->index();

            $table->text('catatan')->nullable();

            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['kamar_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
