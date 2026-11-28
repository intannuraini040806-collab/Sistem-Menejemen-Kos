<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Profil Penghuni (NIK, kontak darurat, pekerjaan, status aktif)
        Schema::create('tenant_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('nik', 20)->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('kontak_darurat_nama', 100)->nullable();
            $table->string('kontak_darurat_telepon', 20)->nullable();
            $table->string('foto_ktp')->nullable();
            $table->enum('status_penghuni', ['calon', 'aktif', 'keluar'])->default('calon');
            $table->timestamps();
        });

        // 2. Master Fasilitas & Pivot Kamar-Fasilitas
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('ikon', 50)->nullable();
            $table->enum('kategori', ['kamar', 'umum'])->default('kamar');
            $table->timestamps();
        });

        Schema::create('facility_kamar', function (Blueprint $table) {
            $table->foreignId('kamar_id')->constrained('kamars')->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained('facilities')->cascadeOnDelete();
            $table->primary(['kamar_id', 'facility_id']);
        });

        // 3. Penambahan kolom DP, tenggat, dan kebijakan pada tabel bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('nominal_dp')->default(0)->after('tanggal_keluar');
            $table->timestamp('tenggat_dp')->nullable()->after('nominal_dp');
            $table->text('kebijakan_dp')->nullable()->after('tenggat_dp');
        });

        // 4. Tabel Kontrak Sewa (memisahkan booking awal dengan masa huni aktif)
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('kamar_id')->constrained('kamars')->restrictOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->unsignedBigInteger('harga_sewa');
            $table->enum('siklus_tagihan', ['bulanan', 'per_3_bulan', 'tahunan'])->default('bulanan');
            $table->text('kondisi_awal')->nullable();
            $table->text('kondisi_akhir')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif')->index();
            $table->timestamps();
        });

        // 5. Tabel Security Deposit (Uang Jaminan)
        Schema::create('security_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->unique()->constrained('contracts')->cascadeOnDelete();
            $table->unsignedBigInteger('nominal_deposit');
            $table->unsignedBigInteger('potongan_kerusakan')->default(0);
            $table->unsignedBigInteger('potongan_tunggakan')->default(0);
            $table->unsignedBigInteger('nominal_dikembalikan')->default(0);
            $table->text('catatan_potongan')->nullable();
            $table->enum('status', ['ditahan', 'dikembalikan_sebagian', 'dikembalikan_penuh', 'hangus'])->default('ditahan');
            $table->date('tanggal_pengembalian')->nullable();
            $table->timestamps();
        });

        // 6. Penyesuaian Tabel Tagihans (dukung contract_id, cicilan/dibayar_sebagian, denda)
        Schema::table('tagihans', function (Blueprint $table) {
            $table->foreignId('contract_id')->nullable()->after('booking_id')->constrained('contracts')->restrictOnDelete();
            $table->string('nomor_invoice', 30)->nullable()->unique()->after('id');
            $table->unsignedBigInteger('denda')->default(0)->after('jumlah');
        });

        // Penyesuaian enum status khusus PostgreSQL dan MySQL
        if (DB::connection()->getDriverName() === 'pgsql') {
            // Hapus batasan status lama yang hanya mengizinkan empat nilai
            DB::statement('
                ALTER TABLE tagihans
                DROP CONSTRAINT IF EXISTS tagihans_status_check
            ');

            // Buat batasan status baru dengan enam nilai
            DB::statement("
                ALTER TABLE tagihans
                ADD CONSTRAINT tagihans_status_check
                CHECK (status IN (
                    'belum_dibayar',
                    'menunggu_verifikasi',
                    'dibayar_sebagian',
                    'lunas',
                    'terlambat',
                    'dibatalkan'
                ))
            ");
        } else {
            // Pertahankan perilaku enum pada MySQL
            Schema::table('tagihans', function (Blueprint $table) {
                $table->enum('status', [
                    'belum_dibayar',
                    'menunggu_verifikasi',
                    'dibayar_sebagian',
                    'lunas',
                    'terlambat',
                    'dibatalkan',
                ])->default('belum_dibayar')->change();
            });
        }

        // 7. Rincian Item Tagihan (sewa pokok, listrik, air, parkir, denda)
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihans')->cascadeOnDelete();
            $table->string('nama_item', 100);
            $table->enum('jenis', ['sewa_pokok', 'listrik', 'air', 'parkir', 'kebersihan', 'denda', 'lainnya'])->default('sewa_pokok');
            $table->unsignedBigInteger('nominal');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // 8. Penyesuaian Tabel Pembayarans (dukung DP booking & Midtrans gateway)
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreignId('tagihan_id')->nullable()->change();
            $table->foreignId('booking_id')->nullable()->after('tagihan_id')->constrained('bookings')->restrictOnDelete();
            $table->enum('jenis_pembayaran', ['dp_booking', 'cicilan_tagihan', 'deposit', 'refund'])->default('cicilan_tagihan')->after('booking_id');
            $table->string('referensi_gateway', 100)->nullable()->after('bukti_pembayaran');
        });

        // 9. Keluhan Penghuni
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kamar_id')->constrained('kamars')->cascadeOnDelete();
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->string('kategori', 50);
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->text('catatan_petugas')->nullable();
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru')->index();
            $table->timestamps();
        });

        // 10. Pengeluaran Operasional Kos
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dicatat_oleh')->constrained('users')->restrictOnDelete();
            $table->string('kategori', 50);
            $table->string('deskripsi');
            $table->unsignedBigInteger('nominal');
            $table->date('tanggal_pengeluaran');
            $table->string('bukti_nota')->nullable();
            $table->timestamps();
        });

        // 11. Pengumuman Kos
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->string('judul', 150);
            $table->text('isi');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // 12. Pengaturan Kos & Rekening Bank
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank', 50);
            $table->string('nomor_rekening', 50);
            $table->string('atas_nama', 100);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('security_deposits');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('facility_kamar');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('tenant_profiles');
    }
};
