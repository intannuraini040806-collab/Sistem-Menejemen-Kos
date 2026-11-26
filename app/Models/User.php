<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'email',
    'phone',
    'password',
    'role',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mendapatkan atribut yang harus di-cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Memeriksa role pengguna.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Memeriksa apakah pengguna adalah Admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Memeriksa apakah pengguna adalah Petugas.
     */
    public function isPetugas(): bool
    {
        return $this->hasRole('petugas');
    }

    /**
     * Memeriksa apakah pengguna adalah Penghuni.
     */
    public function isPenghuni(): bool
    {
        return $this->hasRole('penghuni');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pembayaranDiverifikasi(): HasMany
    {
        return $this->hasMany(
            Pembayaran::class,
            'diverifikasi_oleh'
        );
    }

        public function tenantProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(TenantProfile::class);
    }

    public function contracts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
