<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDomain extends Model
{
    use HasFactory;
    use HasSlug;

    public $timestamps = false;
}
