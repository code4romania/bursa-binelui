<?php

namespace App\Models;

use App\Concerns\HasCounties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Gala extends Model implements HasMedia
{
    use HasFactory;
    use HasCounties;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'start_sign_up',
        'end_sign_up',
        'start_validate',
        'end_validate',
        'start_evaluation',
        'end_evaluation',
        'start_gale',
        'location'
    ];
}
