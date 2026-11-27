<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('nomor_kuitansi', 30)->nullable()->unique()->after('referensi_gateway');
            $table->timestamp('tanggal_kuitansi')->nullable()->after('nomor_kuitansi');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropUnique(['nomor_kuitansi']);
            $table->dropColumn(['nomor_kuitansi', 'tanggal_kuitansi']);
        });
    }
};
