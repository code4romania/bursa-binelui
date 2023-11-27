<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Illuminate\Console\Command as BaseCommand;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

abstract class Command extends BaseCommand
{
    use ConfirmableTrait;

    protected readonly Connection $db;

    protected ?ProgressBar $progressBar = null;

    protected int $errorsCount = 0;

    public function __construct()
    {
        parent::__construct();

        $this->db = DB::connection('import');
    }

    public function createProgressBar(string $message, int $max): void
    {
        $this->progressBar = $this->output->createProgressBar($max);
        $this->progressBar->setFormat("\n<options=bold>%message%</>\n[%bar%] %current%/%max%\n");
        $this->progressBar->setMessage('⏳ ' . $message);
        $this->progressBar->setMessage('', 'status');
        $this->progressBar->setBarWidth(48);
        $this->progressBar->setBarCharacter('<comment>=</>');
        $this->progressBar->setEmptyBarCharacter('<fg=gray>-</>');
        $this->progressBar->setProgressCharacter('<comment>></>');
        $this->progressBar->start();
    }

    public function finishProgressBar(string $message): void
    {
        if ($this->hasErrors()) {
            $this->progressBar->setMessage('🚨 <fg=red>' . $message . ' with ' . $this->errorsCount . ' errors</>');
        } else {
            $this->progressBar->setMessage('✅ <info>' . $message . '</>');
        }

        $this->progressBar->finish();
        $this->resetErrors();
    }

    public function logError(string $message, array $context = []): void
    {
        logger()->error($message, $context);

        $this->errorsCount++;
    }

    public function hasErrors(): bool
    {
        return $this->errorsCount > 0;
    }

    public function resetErrors(): void
    {
        $this->errorsCount = 0;
    }

    public function getRejectedOrganizations(): Collection
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

    public function addFilesToCollection(Model $model, int|array|null $fileIds, string $collection = 'default'): void
    {
        $this->db
            ->table('dbo.Files')
            ->join('dbo.FilesData', 'dbo.FilesData.Id', 'dbo.Files.Id')
            ->whereIn(
                'dbo.Files.Id',
                collect($fileIds)
                    ->filter()
                    ->all()
            )
            ->get()
            ->each(function (object $file) use ($model, $collection) {
                $filename = rtrim($file->FileName, '.') . '.' . ltrim($file->FileExtension, '.');

                $model->addMediaFromString($file->Data)
                    ->usingFileName($filename)
                    ->usingName($filename)
                    ->toMediaCollection($collection);
            });
    }

    public function parseDate(?string $input): ?Carbon
    {
        if ($input === null) {
            return null;
        }

        return Carbon::createFromFormat('M d Y H:i:s:A', $input);
    }

    public function mapCounty(int $oldCountyId): int
    {
        $countiesMap = [
            1 => 1, //Alba
            2 => 2, //Arad
            3 => 3, //Arges
            4 => 4, //Bacau
            5 => 5, //Bihor
            6 => 6, //Bistrita-Nasaud
            7 => 7, //Botosani
            8 => 9, //Braila
            9 => 8, //Brasov
            10 => 40, //Bucuresti
            11 => 10, //Buzau
            12 => 51, //Calarasi
            13 => 11, //Caras-Severin
            14 => 12, //Cluj
            15 => 13, //Constanta
            16 => 14, //Covasna
            17 => 15, //Dambovita
            18 => 16, //Dolj
            19 => 17, //Galati
            20 => 52, //Giurgiu
            21 => 18, //Gorj
            22 => 19, //Harghita
            23 => 20, //Hunedoara
            24 => 21, //Ialomita
            25 => 22, //Iasi
            26 => 23, //Ilfov
            27 => 24, //Maramures
            28 => 25, //Mehedinti
            29 => 26, //Mures
            30 => 27, //Neamt
            31 => 28, //Olt
            32 => 29, //Prahova
            33 => 31, //Salaj
            34 => 30, //Satu Mare
            35 => 32, //Sibiu
            36 => 33, //Suceava
            37 => 34, //Teleorman
            38 => 35, //Timis
            39 => 36, //Tulcea
            40 => 38, //Valcea
            41 => 37, //Vaslui
            42 => 39, //Vrancea

        ];

        return $countiesMap[$oldCountyId];
    }
}
