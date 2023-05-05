<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\County;

class CountySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** Truncate the existing data. */
        County::truncate();

        /** Add the list of counties. */
        County::create(["id" => 1,  "slug" => "alba",            "name" => "Alba"]);
        County::create(["id" => 2,  "slug" => "arad",            "name" => "Arad"]);
        County::create(["id" => 3,  "slug" => "arges",           "name" => "Arges"]);
        County::create(["id" => 4,  "slug" => "bacau",           "name" => "Bacau"]);
        County::create(["id" => 5,  "slug" => "bihor",           "name" => "Bihor"]);
        County::create(["id" => 6,  "slug" => "bistrita-nasaud", "name" => "Bistrita-Nasaud"]);
        County::create(["id" => 7,  "slug" => "botosani",        "name" => "Botosani"]);
        County::create(["id" => 8,  "slug" => "braila",          "name" => "Braila"]);
        County::create(["id" => 9,  "slug" => "brasov",          "name" => "Brasov"]);
        County::create(["id" => 10, "slug" => "bucuresti",       "name" => "Bucuresti"]);
        County::create(["id" => 11, "slug" => "buzau",           "name" => "Buzau"]);
        County::create(["id" => 12, "slug" => "calarasi",        "name" => "Calarasi"]);
        County::create(["id" => 13, "slug" => "caras-severin",   "name" => "Caras-Severin"]);
        County::create(["id" => 14, "slug" => "cluj",            "name" => "Cluj"]);
        County::create(["id" => 15, "slug" => "constanta",       "name" => "Constanta"]);
        County::create(["id" => 16, "slug" => "covasna",         "name" => "Covasna"]);
        County::create(["id" => 17, "slug" => "dambovita",       "name" => "Dambovita"]);
        County::create(["id" => 18, "slug" => "dolj",            "name" => "Dolj"]);
        County::create(["id" => 19, "slug" => "galati",          "name" => "Galati"]);
        County::create(["id" => 20, "slug" => "giurgiu",         "name" => "Giurgiu"]);
        County::create(["id" => 21, "slug" => "gorj",            "name" => "Gorj"]);
        County::create(["id" => 22, "slug" => "harghita",        "name" => "Harghita"]);
        County::create(["id" => 23, "slug" => "hunedoara",       "name" => "Hunedoara"]);
        County::create(["id" => 24, "slug" => "ialomita",        "name" => "Ialomita"]);
        County::create(["id" => 25, "slug" => "iasi",            "name" => "Iasi"]);
        County::create(["id" => 26, "slug" => "ilfov",           "name" => "Ilfov"]);
        County::create(["id" => 27, "slug" => "maramures",       "name" => "Maramures"]);
        County::create(["id" => 28, "slug" => "mehedinti",       "name" => "Mehedinti"]);
        County::create(["id" => 29, "slug" => "mures",           "name" => "Mures"]);
        County::create(["id" => 30, "slug" => "neamt",           "name" => "Neamt"]);
        County::create(["id" => 31, "slug" => "olt",             "name" => "Olt"]);
        County::create(["id" => 32, "slug" => "prahova",         "name" => "Prahova"]);
        County::create(["id" => 33, "slug" => "salaj",           "name" => "Salaj"]);
        County::create(["id" => 34, "slug" => "satu Mare",       "name" => "Satu Mare"]);
        County::create(["id" => 35, "slug" => "sibiu",           "name" => "Sibiu"]);
        County::create(["id" => 36, "slug" => "suceava",         "name" => "Suceava"]);
        County::create(["id" => 37, "slug" => "teleorman",       "name" => "Teleorman"]);
        County::create(["id" => 38, "slug" => "timis",           "name" => "Timis"]);
        County::create(["id" => 39, "slug" => "tulcea",          "name" => "Tulcea"]);
        County::create(["id" => 40, "slug" => "valcea",          "name" => "Valcea"]);
        County::create(["id" => 41, "slug" => "vaslui",          "name" => "Vaslui"]);
        County::create(["id" => 42, "slug" => "vrancea",         "name" => "Vrancea"]);
        County::create(["id" => 43, "slug" => "remote",          "name" => "Remote"]);
    }
}
