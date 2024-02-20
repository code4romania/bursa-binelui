<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionFaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer'
    ];

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
