<?php

namespace App\Models;

use App\Concerns\BelongsToEdition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;
    use BelongsToEdition;

    protected $fillable = [
        'name',
        'edition_categories_id'
    ];

    public function editionCategories()
    {
        return $this->belongsTo(EditionCategories::class);
    }
}
