<?php

namespace App\Console\Commands;

use App\Models\County;
use Illuminate\Console\Command;

class SeedCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding coordinates...');

        $counties = County::all();

        $counties->each(function (County $county) {
            $this->info("Seeding coordinates for {$county->name}...");
            $response = \Http::get('https://nominatim.openstreetmap.org/search', [
                'format' => 'json',
                'q' => $county->name.', Romania',
            ]);
            $data = $response->json();
            $latitude = $data[0]['lat'] ?? null;
            $longitude = $data[0]['lon'] ?? null;
            if (! $latitude || ! $longitude) {
                $this->error("Coordinates for {$county->name} not found.");
                return;
            }
            $county->update([
                'coordinates' => \DB::raw("POINT({$latitude}, {$longitude})"),
            ]);
            $this->info("Coordinates for {$county->name} seeded.");
            $this->info("Sleeping for 5 seconds...");
            sleep(5);
        });

        $this->info('Coordinates seeded.');
    }
}
