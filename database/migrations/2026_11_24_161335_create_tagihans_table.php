<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->restrictOnDelete();

            $table->string('periode', 7);

            $table->unsignedBigInteger('jumlah');

            $table->date('tanggal_terbit');

            $table->date('tanggal_jatuh_tempo');

            $table->enum('status', [
                'belum_dibayar',
                'menunggu_verifikasi',
                'lunas',
                'terlambat',
            ])->default('belum_dibayar')->index();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(
                ['booking_id', 'periode'],
                'tagihans_booking_periode_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
