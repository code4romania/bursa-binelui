<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToEdition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionFaq extends Model
{
    use HasFactory;
    use BelongsToEdition;

    protected $fillable = [
        'question',
        'answer',
    ];
}
