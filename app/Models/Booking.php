<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'kamar_id',
        'tanggal_booking',
        'tanggal_masuk',
        'tanggal_keluar',
        'alasan_keluar',
        'nominal_dp',
        'tenggat_dp',
        'kebijakan_dp',
        'status',
        'catatan',
        'alasan_penolakan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_booking' => 'date',
            'tanggal_masuk' => 'date',
            'tanggal_keluar' => 'date',
            'nominal_dp' => 'integer',
            'tenggat_dp' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class);
    }

    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }
}