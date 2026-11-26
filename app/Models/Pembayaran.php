<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'tagihan_id',
        'booking_id',
        'jenis_pembayaran',
        'user_id',
        'metode_pembayaran',
        'jumlah_bayar',
        'tanggal_pembayaran',
        'bukti_pembayaran',
        'referensi_gateway',
        'status',
        'diverifikasi_oleh',
        'tanggal_verifikasi',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'integer',
            'tanggal_pembayaran' => 'date',
            'tanggal_verifikasi' => 'datetime',
        ];
    }

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function getJumlahBayarFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah_bayar, 0, ',', '.');
    }
}