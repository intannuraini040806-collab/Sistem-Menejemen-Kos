<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'dicatat_oleh',
        'kategori',
        'deskripsi',
        'nominal',
        'tanggal_pengeluaran',
        'bukti_nota',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'integer',
            'tanggal_pengeluaran' => 'date',
        ];
    }

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}