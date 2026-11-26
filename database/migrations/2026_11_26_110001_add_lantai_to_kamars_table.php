<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kamars', function (Blueprint $table) {
            if (!Schema::hasColumn('kamars', 'lantai')) {
                $table->unsignedTinyInteger('lantai')->default(1)->after('nomor_kamar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kamars', function (Blueprint $table) {
            if (Schema::hasColumn('kamars', 'lantai')) {
                $table->dropColumn('lantai');
            }
        });
    }
};