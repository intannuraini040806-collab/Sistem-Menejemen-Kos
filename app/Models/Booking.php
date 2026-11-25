<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'kamar_id',
        'tanggal_booking',
        'tanggal_masuk',
        'tanggal_keluar',
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
}
