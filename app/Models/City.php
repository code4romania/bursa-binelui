<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    protected function getNameWithCountyAttribute(): string
    {
        return "{$this->name}, {$this->county->name}";
    }
}
