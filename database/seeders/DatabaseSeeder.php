<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;

class DatabaseSeeder extends Seeder
{
    const USER_DONOR_NUMBER = 45;
    const USER_NGO_ADMIN_NUMBER = 50;
    const USER_BB_MANAGER_NUMBER = 1;
    const USER_BB_ADMIN_NUMBER = 1;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ('production' !== config('app.env', 'production')) {
            for ($i=0; $i < self::USER_DONOR_NUMBER; $i++) {
                User::factory()->donor()->create();
            }

            for ($i=0; $i < self::USER_NGO_ADMIN_NUMBER; $i++) {
                $organization = Organization::factory()->create();

                User::factory()->ngoAdmin()->for($organization)->create();
            }

            for ($i=0; $i < self::USER_BB_MANAGER_NUMBER; $i++) {
                User::factory()->bbManager()->create();
            }

            for ($i=0; $i < self::USER_BB_ADMIN_NUMBER; $i++) {
                User::factory()->bbAdmin()->create();
            }
        }
    }
}
