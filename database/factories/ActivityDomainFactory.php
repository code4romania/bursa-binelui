<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ActivityDomain;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActivityDomainFactory extends Factory
{
    protected $model = ActivityDomain::class;

    public function definition(): array
    {
        $name = $this->faker->word;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
