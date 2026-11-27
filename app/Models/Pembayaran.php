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
        'nomor_kuitansi',
        'tanggal_kuitansi',
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
            'tanggal_kuitansi' => 'datetime',
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

    /**
     * Menerbitkan kuitansi resmi. Kuitansi hanya terbit untuk pembayaran yang
     * sudah diverifikasi (disetujui) dan nomornya bersifat tetap (idempotent).
     * Format: KWT-{TahunBulan}-{ID 5 digit}, contoh KWT-202611-00012.
     */
    public function terbitkanKuitansi(): ?string
    {
        if ($this->status !== 'disetujui') {
            return null;
        }

        if ($this->nomor_kuitansi) {
            return $this->nomor_kuitansi;
        }

        $tanggal = $this->tanggal_verifikasi ?? now();

        $this->forceFill([
            'nomor_kuitansi' => 'KWT-' . $tanggal->format('Ym') . '-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT),
            'tanggal_kuitansi' => $tanggal,
        ])->save();

        return $this->nomor_kuitansi;
    }
}
