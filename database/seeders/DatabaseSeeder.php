<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ActivityDomain as ActivityDomainEnum;
use App\Models\ActivityDomain;
use App\Models\ArticleCategory;
use App\Models\Badge;
use App\Models\BadgeCategory;
use App\Models\BCRProject;
use App\Models\Championship;
use App\Models\Organization;
use App\Models\ProjectCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
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

        Mail::fake();

        User::factory(['email' => 'superadmin@example.com'])
            ->superAdmin()
            ->create();

        User::factory(['email' => 'supermanager@example.com'])
            ->count(1)
            ->superManager()
            ->create();

        User::factory()
            ->count(5)
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

        $this->seedProjectCategories();

        Championship::factory()
            ->count(3)
            ->create();

        Organization::factory()
            ->count(5)
            ->approved()
            ->create();

        Organization::factory()
            ->count(1)
            ->rejected()
            ->create();

        Organization::factory()
            ->count(1)
            ->pending()
            ->create();

        BCRProject::factory()->count(10)->create();

        $this->seedBadges();

        $this->seedArticleCategories();
    }

    private function seedArticleCategories(): void
    {
        $articleCategories = [
            'Social',
            'Educație',
            'Sănătate',
            'Cultură',
            'Mediu',
            'Sport',
            'Animale',
            'Altele',
        ];

        foreach ($articleCategories as $category) {
            ArticleCategory::factory()
                ->name($category)
                ->hasArticles(4)
                ->create();
        }
    }

    private function seedProjectCategories(): void
    {
        $projectCategories = [
            'Antreprenoriat social',
            'Cultura',
            'Drepturile omului',
            'Educație',
            'Mediu',
            'Protecția animalelor',
            'Sanatate',
            'Social',
            'Sport',
        ];

        foreach ($projectCategories as $category) {
            ProjectCategory::factory()
                ->name($category)
                ->create();
        }
    }

    private function seedBadges(): void
    {
        $oldCategories = [
            'Donatii',
            'Voluntariat',
            'Sharing',
            'Proiect ONG',
            'Activitate lunara',
        ];
        foreach ($oldCategories as $category) {
            BadgeCategory::factory()
                ->state(['title' => $category])
                ->has(Badge::factory()->count(5))
                ->create();
        }
    }
}
