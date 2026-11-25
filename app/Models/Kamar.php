<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kamar extends Model
{
    protected $table = 'kamars';

    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga',
        'kapasitas',
        'jumlah_penghuni',
        'deskripsi',
        'fasilitas',
        'jenis_kamar_mandi',
        'foto',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'kapasitas' => 'integer',
            'jumlah_penghuni' => 'integer',
            'fasilitas' => 'array',
        ];
    }

    /**
     * Format harga kamar.
     */
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Periksa apakah kamar masih tersedia.
     */
    public function getTersediaAttribute(): bool
    {
        return $this->status === 'tersedia'
            && $this->jumlah_penghuni < $this->kapasitas;
    }

    /**
     * Perbarui status berdasarkan kapasitas.
     */
    public function perbaruiStatusOtomatis(): void
    {
        if ($this->status === 'maintenance') {
            return;
        }

        $this->status = $this->jumlah_penghuni >= $this->kapasitas
            ? 'terisi'
            : 'tersedia';

        $this->save();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    
}
