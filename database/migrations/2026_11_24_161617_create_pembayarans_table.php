<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tagihan_id')
                ->constrained('tagihans')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->enum('metode_pembayaran', [
                'transfer',
                'tunai',
            ]);

            $table->unsignedBigInteger('jumlah_bayar');

            $table->date('tanggal_pembayaran');

            $table->string('bukti_pembayaran')->nullable();

            $table->enum('status', [
                'menunggu_verifikasi',
                'disetujui',
                'ditolak',
            ])->default('menunggu_verifikasi')->index();

            $table->foreignId('diverifikasi_oleh')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
