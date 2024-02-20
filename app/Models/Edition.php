<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Edition extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'short_description',
        'start_date',
        'end_date',
    ];

    public $preventsLazyLoading = true;

    public function edition_categories()
    {
        return $this->hasMany(EditionCategories::class);
    }

    public function faq()
    {
        return $this->hasMany(EditionFaq::class);
    }

    public function gales()
    {
        return $this->hasMany(Gala::class);
    }

    public function prize()
    {
        return $this->hasMany(Prize::class);
    }
}
