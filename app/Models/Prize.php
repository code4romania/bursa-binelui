<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToEdition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prize extends Model
{
    use HasFactory;
    use BelongsToEdition;

    protected $fillable = [
        'name',
        'edition_categories_id',
    ];

    public function editionCategories(): BelongsTo
    {
        return $this->belongsTo(EditionCategories::class);
    }

    public function galaProjects(): BelongsToMany
    {
        return $this->belongsToMany(GalaProject::class);
    }
}
