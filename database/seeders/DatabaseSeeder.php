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
use App\Models\Edition;
use App\Models\Organization;
use App\Models\Page;
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

        BCRProject::factory()->count(10)->create();

        $this->seedBadges();

        $this->seedArticleCategories();

        Page::factory()->count(10)->create();

		$this->seedSpecificAboutAndFaqsPages();

        Edition::factory(['active' => true])
            ->count(1)
            ->create();

        Edition::factory(['active' => false])
            ->count(3)
            ->create();

        Organization::factory()
            ->count(150)
            ->approved()
            ->create();

        Organization::factory()
            ->count(5)
            ->rejected()
            ->create();

        Organization::factory()
            ->count(5)
            ->pending()
            ->create();
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
            'Cultură',
            'Drepturile omului',
            'Educație',
            'Mediu',
            'Protecția animalelor',
            'Sănătate',
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

	private function seedSpecificAboutAndFaqsPages(): void
	{
		// Add the /about page
		Page::create([
			'title' => ['ro' => 'Despre BB'],
			'slug' => ['ro' => 'about'],
			'description' => ['ro' => 'Răspunsuri la întrebările frecvente despre Bursa Binelui.'],
			'content' => ['ro' => '<p>Bursa Binelui, singura platformă online de donații fără comision dedicată ONG-urilor din România, este un proiect creat și susținut de Banca Comercială Română (BCR) și coordonat în parteneriat Grupul PONT. Platforma aduce împreună organizațiile care au nevoie de sprijin pentru a-și desfășura activitatea și oamenii care vor să investească în faptele bune din comunitatea lor.</p>'],
		]);

		// Add the /faqs page
		Page::create([
			'title' => ['ro' => 'Întrebări frecvente'],
			'slug' => ['ro' => 'faqs'],
			'description' => ['ro' => 'Răspunsuri la întrebările frecvente despre Bursa Binelui.'],
			'content' => ['ro' => '
				<h2>Întrebări frecvente</h2>
				<p>Aici găsiți răspunsuri la cele mai frecvente întrebări referitoare la Bursa Binelui.</p>
				
				<h3>1. Ce este Bursa Binelui?</h3>
				<p>Bursa Binelui este o platformă dedicată strângerii de fonduri și voluntariatului pentru cauze sociale.</p>
				
				<h3>2. Cum pot dona?</h3>
				<p>Puteți dona prin intermediul proiectelor disponibile pe platformă, folosind metoda de plată preferată.</p>
				
				<h3>3. Cum mă pot înscrie ca voluntar?</h3>
				<p>Accesați pagina proiectului și folosiți formularul de înscriere voluntar pentru a vă oferi sprijinul.</p>
    		'],
		]);
	}
}
