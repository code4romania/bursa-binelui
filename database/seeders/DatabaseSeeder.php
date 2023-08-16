<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ActivityDomain as ActivityDomainEnum;
use App\Models\ActivityDomain;
use App\Models\ArticleCategory;
use App\Models\Badge;
use App\Models\Championship;
use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->isProduction()) {
            return;
        }

        User::factory(['email' => 'bb-admin@example.com'])
            ->bbAdmin()
            ->create();

        User::factory(['email' => 'bb-manager@example.com'])
            ->count(1)
            ->bbManager()
            ->create();

        User::factory()
            ->count(50)
            ->donor()
            ->create();

        collect(ActivityDomainEnum::values())
            ->map(fn ($domain) => [
                'name' => $domain,
                'slug' => Str::slug($domain),
            ])
            ->tap(function (Collection $collection) {
                ActivityDomain::insert($collection->toArray());
            });

        Championship::factory()
            ->count(3)
            ->create();

        Organization::factory()
            ->count(50)
            ->has(
                User::factory()
                    ->ngoAdmin()
                    ->sequence(fn (Sequence $sequence) => [
                        'email' => $sequence->index
                            ? "admin-{$sequence->index}@example.com"
                            : 'admin@example.com',
                    ])
            )
            ->has(
                Project::factory()
                    ->count(10)
                    ->hasVolunteers(10)
            )
            ->create();

        Badge::factory()
            ->count(30)
            ->create();

        $articleCategories = ['Social', 'Educație', 'Sănătate', 'Cultură', 'Mediu', 'Sport', 'Animale', 'Altele'];
        foreach ($articleCategories as $category) {
            ArticleCategory::factory()
                ->name($category)
                ->hasArticles(4)
                ->create();
        }
    }
}
