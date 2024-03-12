<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToEdition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EditionCategories extends Model
{
    use HasFactory;
    use BelongsToEdition;

    protected $fillable = ['name'];

    public function galaProjects(): BelongsToMany
    {
        return $this->belongsToMany(GalaProject::class,'edition_categories_gala_project');
    }
}
