<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use Illuminate\Console\Command as BaseCommand;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

abstract class Command extends BaseCommand
{
    protected readonly Connection $db;

    protected ?ProgressBar $progressBar = null;

    public function __construct()
    {
        parent::__construct();

        $this->db = DB::connection('import');
    }

    public function createProgressBar(string $status, int $max): void
    {
        $this->progressBar = $this->output->createProgressBar($max);
        $this->progressBar->setFormat("\n<options=bold>%status:-30s% %current%/%max%</>\n[%bar%] %remaining%\n");
        $this->progressBar->setMessage($status, 'status');
        $this->progressBar->setBarCharacter('<fg=green>=</>');
        $this->progressBar->setEmptyBarCharacter('<fg=gray>-</>');
        $this->progressBar->setProgressCharacter('<fg=green>></>');
        $this->progressBar->start();
    }

    protected function getRejectedOrganizations(): Collection
    {
        return Cache::driver('array')
            ->rememberForever(
                'import-rejected-organizations',
                fn () => $this->db
                    ->table('dbo.ONGs')
                    ->orderBy('dbo.ONGs.Id')
                    ->select([
                        'dbo.ONGs.Id',
                        'dbo.ONGs.CIF',
                        'dbo.ONGs.ONGStatusId',
                        'ProjectsCount' => $this->db
                            ->table('dbo.ONGProjects')
                            ->whereColumn('dbo.ONGs.Id', 'dbo.ONGProjects.ONGId')
                            ->selectRaw('count(*)'),
                    ])
                    ->get()
                    ->groupBy('CIF')
                    ->reject(fn (Collection $collection) => $collection->count() < 2)
                    ->flatMap(
                        fn (Collection $collection) => $collection
                            ->sortBy([
                                ['ONGStatusId', 'asc'],
                                ['ProjectsCount', 'desc'],
                            ])
                            ->skip(1)
                    )
                    ->pluck('Id')
            );
    }

    protected function addFileToCollection(Model $model, ?int $fileId, string $collection = 'default'): void
    {
        if (\is_null($fileId)) {
            return;
        }

        $file = $this->db
            ->table('dbo.Files')
            ->join('dbo.FilesData', 'dbo.FilesData.Id', 'dbo.Files.Id')
            ->where('dbo.Files.Id', $fileId)
            ->first();

        if (\is_null($file)) {
            return;
        }

        $filename = rtrim($file->FileName, '.') . '.' . ltrim($file->FileExtension, '.');

        $model->addMediaFromString($file->Data)
            ->usingFileName($filename)
            ->usingName($filename)
            ->toMediaCollection($collection);
    }
}
