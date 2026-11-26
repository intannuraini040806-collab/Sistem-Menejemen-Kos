<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = [
        'tagihan_id',
        'nama_item',
        'jenis',
        'nominal',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'integer',
        ];
    }

    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }
}