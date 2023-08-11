<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\ActivityDomain as ActivityDomainEnum;
use App\Models\ActivityDomain;
use App\Models\Article;
use App\Models\Championship;
use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public const USER_DONOR_NUMBER = 45;

    public const USER_NGO_ADMIN_NUMBER = 50;

    public const USER_BB_MANAGER_NUMBER = 1;

    public const USER_BB_ADMIN_NUMBER = 1;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ('production' !== config('app.env', 'production')) {
            $this->seedProjectCategories();
            $this->seedActivityDomains();

            Championship::factory()->count(3)->create();
            User::factory(['email' => 'bb-admin@example.com'])->bbAdmin()->create();
            for ($i = 0; $i < self::USER_DONOR_NUMBER; $i++) {
                User::factory()->donor()->create();
            }

            for ($i = 0; $i < self::USER_NGO_ADMIN_NUMBER; $i++) {
                $organization = Organization::factory(['eu_platesc_merchant_id'=>config('services.eu_platesc.merchant_id'), 'eu_platesc_private_key'=>config('services.eu_platesc.private_key')])->create();
                if ($i === 0) {
                    User::factory(['email' => 'admin@example.com'])->ngoAdmin()->for($organization)->create();
                } else {
                    User::factory()->ngoAdmin()->for($organization)->create();
                }
                $project = Project::factory()->for($organization)->count(10)->create();
                $project->each(function ($project) {
                    $project->volunteers()->attach(Volunteer::factory()->count(10)->create());
                });
            }

            for ($i = 0; $i < self::USER_BB_MANAGER_NUMBER; $i++) {
                User::factory()->bbManager()->create();
            }

            for ($i = 0; $i < self::USER_BB_ADMIN_NUMBER; $i++) {
                User::factory()->bbAdmin()->create();
            }

            $articleCategories = ['Social', 'Educație', 'Sănătate', 'Cultură', 'Mediu', 'Sport', 'Animale', 'Altele'];
            foreach ($articleCategories as $category) {
                \App\Models\ArticleCategory::factory(['name' => $category, 'slug' => \Str::slug($category)])
                    ->has(Article::factory()->count(4))->create();
            }
        }
    }

    /**
     * @return void
     */
    private function seedActivityDomains(): void
    {
        $activityDomains = ActivityDomainEnum::values();
        $tmpActivityDomains = [];
        foreach ($activityDomains as $domain) {
            $tmpActivityDomains[] = ['name' => $domain, 'slug' => \Str::slug($domain)];
        }
        ActivityDomain::insert($tmpActivityDomains);
    }

    private function seedProjectCategories()
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
       $projectCategories  =   collect($projectCategories)->transform(function ($category) {
            return ['name' => $category, 'slug' => \Str::slug($category)];
        });
       ProjectCategory::insert($projectCategories->toArray());
    }
}
