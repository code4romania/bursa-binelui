<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionCategoriesRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'edition_categories_id',
        'edition_id',
        ];
}
