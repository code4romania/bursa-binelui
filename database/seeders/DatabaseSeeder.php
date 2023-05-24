<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Donation;
use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
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
            for ($i = 0; $i < self::USER_DONOR_NUMBER; $i++) {
                User::factory()->donor()->create();
            }

            for ($i = 0; $i < self::USER_NGO_ADMIN_NUMBER; $i++) {
                $organization = Organization::factory()->create();

                User::factory()->ngoAdmin()->for($organization)->create();
                Project::factory()->for($organization)->has(Donation::factory()->count(3))->count(1000)->create();
            }

            for ($i = 0; $i < self::USER_BB_MANAGER_NUMBER; $i++) {
                User::factory()->bbManager()->create();
            }

            for ($i = 0; $i < self::USER_BB_ADMIN_NUMBER; $i++) {
                User::factory()->bbAdmin()->create();
            }
        }
    }
}
