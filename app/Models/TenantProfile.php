<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'alamat_asal',
        'pekerjaan',
        'kontak_darurat_nama',
        'kontak_darurat_telepon',
        'foto_ktp',
        'status_penghuni',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}