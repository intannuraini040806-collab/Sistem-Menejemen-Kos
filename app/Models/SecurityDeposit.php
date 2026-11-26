<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityDeposit extends Model
{
    protected $fillable = [
        'contract_id',
        'nominal_deposit',
        'potongan_kerusakan',
        'potongan_tunggakan',
        'nominal_dikembalikan',
        'catatan_potongan',
        'status',
        'tanggal_pengembalian',
    ];

    protected function casts(): array
    {
        return [
            'nominal_deposit' => 'integer',
            'potongan_kerusakan' => 'integer',
            'potongan_tunggakan' => 'integer',
            'nominal_dikembalikan' => 'integer',
            'tanggal_pengembalian' => 'date',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}