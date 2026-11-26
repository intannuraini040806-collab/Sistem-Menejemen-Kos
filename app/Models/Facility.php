<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    protected $fillable = [
        'nama',
        'ikon',
        'kategori',
    ];

    public function kamars(): BelongsToMany
    {
        return $this->belongsToMany(Kamar::class, 'facility_kamar');
    }
}