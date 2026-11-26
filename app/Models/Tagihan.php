<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    protected $fillable = [
        'nomor_invoice',
        'booking_id',
        'contract_id',
        'periode',
        'jumlah',
        'denda',
        'tanggal_terbit',
        'tanggal_jatuh_tempo',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'denda' => 'integer',
            'tanggal_terbit' => 'date',
            'tanggal_jatuh_tempo' => 'date',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Menghitung total tagihan + denda
    public function getTotalTagihanAttribute(): int
    {
        return $this->jumlah + $this->denda;
    }

    // Menghitung total cicilan yang sudah diverifikasi (disetujui)
    public function getTotalTerbayarAttribute(): int
    {
        return (int) $this->pembayarans()
            ->where('status', 'disetujui')
            ->sum('jumlah_bayar');
    }

    // Menghitung sisa kewajiban yang belum lunas
    public function getSisaTagihanAttribute(): int
    {
        return max(0, $this->total_tagihan - $this->total_terbayar);
    }

    public function getJumlahFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }
}