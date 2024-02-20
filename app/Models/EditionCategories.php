<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionCategories extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
