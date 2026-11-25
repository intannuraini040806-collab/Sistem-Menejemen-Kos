
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();

            // Identitas kamar
            $table->string('nomor_kamar', 20)->unique();

            // Tipe dan harga kamar
            $table->enum('tipe', ['single', 'double']);
            $table->unsignedBigInteger('harga');

            // Kapasitas penghuni
            $table->unsignedTinyInteger('kapasitas');
            $table->unsignedTinyInteger('jumlah_penghuni')
                ->default(0);

            // Informasi kamar
            $table->text('deskripsi')->nullable();

            // Daftar fasilitas disimpan dalam format JSON
            $table->json('fasilitas')->nullable();

            // Jenis kamar mandi
            $table->enum('jenis_kamar_mandi', [
                'dalam_kamar',
                'bersama'
            ]);

            // Foto kamar
            $table->string('foto')->nullable();

            // Status kamar
            $table->enum('status', [
                'tersedia',
                'terisi',
                'maintenance'
            ])->default('tersedia');

            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
