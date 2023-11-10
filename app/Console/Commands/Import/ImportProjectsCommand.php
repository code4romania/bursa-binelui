<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Services\Sanitize;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class ImportProjectsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:projects
        {--chunk=100 : The number of records to process at a time}
        {--skip-files : Skip importing files}
        {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import projects from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return static::FAILURE;
        }

        $this->importProjectCategories();
        $this->importProjects();

        return static::SUCCESS;
    }

    protected function importProjectCategories(): void
    {
        $projectCategories = $this->db
            ->table('lkp.ProjectCategories')
            ->orderBy('lkp.ProjectCategories.Id')
            ->get();

        $this->createProgressBar('Importing project categories...', $projectCategories->count());

        ProjectCategory::upsert(
            $projectCategories->map(fn (object $row) => [
                'id' => (int) $row->Id,
                'name' => Sanitize::text($row->Name),
                'slug' => Sanitize::slug($row->Name),
            ])->all(),
            'id'
        );

        $this->finishProgressBar('Imported project categories');
    }

    protected function importProjects(): void
    {
        $query = $this->db
            ->table('dbo.ONGProjects')
            ->addSelect([
                'dbo.ONGProjects.*',
                'dbo.Projects.*',
                'MainImageId' => $this->db
                    ->table('dbo.ProjectImages')
                    ->select('ImageId')
                    ->whereColumn('dbo.ProjectImages.ProjectId', 'dbo.ONGProjects.Id')
                    ->where('dbo.ProjectImages.IsMainImage', 1),
                'GalleryImageIds' => $this->db
                    ->table('dbo.ProjectImages')
                    ->selectRaw("STRING_AGG(ImageId,',')")
                    ->whereColumn('dbo.ProjectImages.ProjectId', 'dbo.ONGProjects.Id')
                    ->where('dbo.ProjectImages.IsMainImage', 0),
            ])
            ->join('dbo.Projects', 'dbo.Projects.Id', 'dbo.ONGProjects.Id')
            ->orderBy('dbo.ONGProjects.Id');

        $this->createProgressBar(
            $this->option('skip-files')
                ? 'Importing projects [skip-files]...'
                : 'Importing projects...',
            $query->count()
        );

        $query->chunk((int) $this->option('chunk'), function (Collection $items) {
            $items
                ->reject(fn (object $row) => $this->getRejectedOrganizations()->contains($row->ONGId))
                ->each(function (object $row) {
                    $created_at = Carbon::parse($row->CreationDate);

                    try {
                        $project = Project::forceCreate([
                            'id' => (int) $row->Id,
                            'organization_id' => (int) $row->ONGId,
                            'name' => Sanitize::text($row->Name),
                            'slug' => Sanitize::text($row->DynamicUrl),
                            'description' => Sanitize::text($row->Description),
                            'target_budget' => (int) $row->TargetAmmount,
                            'start' => $this->parseDate($row->StartDate),
                            'end' => $this->parseDate($row->EndDate),
                            'accepting_volunteers' => (bool) $row->HasVolunteering,
                            'accepting_comments' => (bool) $row->AcceptComments,

                            'created_at' => $created_at,
                            'updated_at' => $created_at,

                            'status' => match ($row->ProjectStatusTypeId) {
                                1 => ProjectStatus::pending,
                                2 => ProjectStatus::approved,
                                3 => ProjectStatus::approved,//set arhivat
                                4 => ProjectStatus::approved,
                                default => ProjectStatus::draft,
                            },
                        ]);

                        $project->categories()->attach($row->ProjectCategoryId);

                        if (! $this->option('skip-files')) {
                            // Add main image
                            $this->addFilesToCollection($project, $row->MainImageId, 'preview');

                            // Add gallery images
                            if ($row->GalleryImageIds) {
                                $this->addFilesToCollection($project, explode(',', $row->GalleryImageIds), 'gallery');
                            }
                        }
                    } catch (Throwable $th) {
                        $this->logError('Error importing project #' . $row->Id, [$th->getMessage()]);
                    }

                    $this->progressBar->advance();
                });
        });

        $this->finishProgressBar(
            $this->option('skip-files')
            ? 'Imported projects [skip-files]'
            : 'Imported projects'
        );
    }
}
