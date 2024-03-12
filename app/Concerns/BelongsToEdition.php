<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Edition;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToEdition
{
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }
}
