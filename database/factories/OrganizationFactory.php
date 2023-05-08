<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\County;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** Choose a random county. */
        $countyId = fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 51, 52]);
        $cityId = County::find($countyId)->cities->random()->id;
        $activityDomains = [
            'Protecția mediului',
            'Educație și formare',
            'Sănătate și asistență medicală',
            'Drepturile omului',
            'Dezvoltare rurală',
            'Sprijinirea persoanelor cu dizabilități',
            'Promovarea egalității de gen',
            'Combaterea sărăciei',
            'Integrarea minorităților',
            'Ajutorarea copiilor și tinerilor în dificultate',
            'Sprijin pentru vârstnici',
            'Conservarea patrimoniului cultural',
            'Artă și cultură',
            'Susținerea sportului și activităților recreative',
            'Dezvoltare comunitară',
            'Prevenirea violenței în familie',
            'Ajutorarea imigranților și refugiaților',
            'Combaterea traficului de persoane',
            'Promovarea democrației și bunei guvernări',
            'Protecția animalelor',
            'Prevenirea și combaterea dependenței de droguri',
            'Advocacy și politici publice',
            'Combaterea discriminării și intoleranței',
            'Îmbunătățirea infrastructurii și serviciilor publice',
            'Antreprenoriat social și economie solidară',
            'Prevenirea și gestionarea dezastrelor naturale',
            'Apărarea drepturilor consumatorilor',
            'Susținerea familiei și a copilului',
            'Promovarea voluntariatului',
            'Asistență juridică și acces la justiție',
            'Protecția datelor și a vieții private',
            'Combaterea corupției și a fraudei',
            'Sănătate mintală și bunăstare emoțională',
            'Apărarea drepturilor animalelor',
            'Susținerea educației și cercetării științifice',
            'Dezvoltare durabilă și reducerea emisiilor de CO2',
            'Securitate alimentară și combaterea foametei',
            'Prevenirea și controlul bolilor infecțioase',
            'Sprijin pentru veteranii de război și familiile acestora',
            'Susținerea dezvoltării regionale și internaționale'
        ];

        return [
            'name' => fake()->company(),
            'cif' => fake()->unixTime(),
            'description' => fake()->text(500),
            'county_id' => $countyId,
            'city_id' => $cityId,
            'street_address' => fake()->streetName(),
            'contact_person' => fake()->name(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_email' => fake()->companyEmail(),
            'website' => fake()->url(),
            'accepts_volunteers' => fake()->boolean(),
            'why_volunteer' => fake()->text(333),
            'activity_domains' => implode(',', fake()->randomElements($activityDomains, 3)),
            'status' => fake()->randomElement(['pending', 'active', 'disabled'])
        ];
    }
}
