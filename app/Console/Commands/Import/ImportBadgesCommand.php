<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Enums\BadgeType;
use App\Models\Badge;
use App\Models\BadgeCategory;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ImportBadgesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:badges
        {--chunk=100 : The number of records to process at a time}
        {--skip-files : Skip importing files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import badges from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

//        $this->importBadgesCategories();
//        $this->importBadges();
        $this->assignBadgesToUsers();

        return static::SUCCESS;
    }

    private function importBadgesCategories()
    {
        $categories = $this->db
            ->table('lkp.BadgeCategoryTypes')
            ->orderBy('lkp.BadgeCategoryTypes.Id');

        $this->createProgressBar('Importing badges categories....', $categories->count());
        $categories->chunk((int) $this->option('chunk'), function (Collection $categories) {
            $categories->each(function ($category) {
                BadgeCategory::forceCreate(
                    [
                        'title' => $category->Name,
                    ]
                );
            });
            $this->progressBar->advance($categories->count());
        });

        $this->finishProgressBar('Imported badges categories.');
    }

    private function importBadges(): void
    {
        $badges = $this->db
            ->table('user.BadgeDefinitions')
            ->orderBy('user.BadgeDefinitions.Id');

        $this->createProgressBar('Importing badges....', $badges->count());
        $badges->chunk((int) $this->option('chunk'), function (Collection $badges) {
            $badges->each(function ($badge) {
                Badge::forceCreate(
                    [
                        'title' => $badge->Title,
                        'description' => $badge->Description,
                        'type' => BadgeType::AUTOMATED,
                        'badge_category_id' => $badge->BadgeCategoryId,
                    ]
                );
            });
            $this->progressBar->advance($badges->count());
        });
        $this->finishProgressBar('Imported badges.');
    }

    private function assignBadgesToUsers()
    {
        $badges = $this->db
            ->table('user.UserBadges')
            ->orderBy('user.UserBadges.Id');

        $this->createProgressBar('Assigning badges to users....', $badges->count());
        $badges->chunk((int) $this->option('chunk'), function (Collection $badges) {
            $badges->each(function ($badge) {
                $user = User::where('id', $badge->UserId)->first();
                if ($user)
                {
                    $user->badges()->attach($badge->BadgeDefinitionId, ['allocated_at' => Carbon::parse($badge->IssueDate)]);
                }
            });
            $this->progressBar->advance($badges->count());
        });

        $this->finishProgressBar('Assigned badges to users.');
    }
}
