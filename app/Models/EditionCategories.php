<?php

namespace App\Models;

use App\Concerns\BelongsToEdition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionCategories extends Model
{
    use HasFactory;
    use BelongsToEdition;

    protected $fillable = ['name'];
}
