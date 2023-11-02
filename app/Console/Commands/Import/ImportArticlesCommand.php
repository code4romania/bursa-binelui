<?php

declare(strict_types=1);

namespace App\Console\Commands\Import;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Services\Sanitize;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class ImportArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:articles {--chunk=100 : The number of records to process at a time} {--skip-files : Skip importing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import articles from the old database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->importArticleCategories();
        $this->importArticles();

        return static::SUCCESS;
    }

    protected function importArticleCategories(): void
    {
        $articleCategories = $this->db
            ->table('lkp.ArticleCategories')
            ->orderBy('lkp.ArticleCategories.Id')
            ->get();

        $this->createProgressBar('Importing article categories...', $articleCategories->count());

        foreach ($this->progressBar->iterate($articleCategories) as $row) {
            ArticleCategory::forceCreate([
                'id' => (int) $row->Id,
                'name' => Sanitize::text($row->Name),
                'slug' => Sanitize::slug($row->Name),
            ]);
        }

        $this->finishProgressBar('Imported article categories');
    }

    protected function importArticles(): void
    {
        $query = $this->db
            ->table('dbo.Articles')
            ->addSelect([
                'dbo.Articles.*',
                'MainImageId' => $this->db
                    ->table('dbo.ArticleImages')
                    ->select('ImageId')
                    ->whereColumn('dbo.ArticleImages.ArticleId', 'dbo.Articles.Id')
                    ->where('dbo.ArticleImages.IsMainImage', 1),
                'GalleryImageIds' => $this->db
                    ->table('dbo.ArticleImages')
                    ->selectRaw("STRING_AGG(ImageId,',')")
                    ->whereColumn('dbo.ArticleImages.ArticleId', 'dbo.Articles.Id')
                    ->where('dbo.ArticleImages.IsMainImage', 0),
                'AttachmentIds' => $this->db
                    ->table('dbo.ArticleAttachments')
                    ->selectRaw("STRING_AGG(GenericFileId,',')")
                    ->whereColumn('dbo.ArticleAttachments.ArticleId', 'dbo.Articles.Id'),
            ])
            ->orderBy('dbo.Articles.Id');

        $this->createProgressBar(
            $this->option('skip-files')
                ? 'Importing articles [skip-files]...'
                : 'Importing articles...',
            $query->count()
        );

        $query->chunk((int) $this->option('chunk'), function (Collection $items) {
            $items->each(function (object $row) {
                $created_at = Carbon::parse($row->CreationDate);

                try {
                    $article = Article::forceCreate([
                        'id' => (int) $row->Id,
                        'title' => Sanitize::text($row->Title),
                        'slug' => Sanitize::text($row->DynamicUrl),
                        'author' => Sanitize::text($row->Author),
                        'content' => $row->Content,
                        'article_category_id' => (int) $row->ArticleCategoryId,
                        'created_at' => $created_at,
                        'updated_at' => $created_at,
                        'published_at' => $this->parseDate($row->PublishDate),
                    ]);

                    if (! $this->option('skip-files')) {
                        // Add main image
                        $this->addFilesToCollection($article, $row->MainImageId, 'preview');

                        // Add gallery images
                        if ($row->GalleryImageIds) {
                            $this->addFilesToCollection($article, explode(',', $row->GalleryImageIds), 'gallery');
                        }

                        // Add attachments
                        if ($row->AttachmentIds) {
                            $this->addFilesToCollection($article, explode(',', $row->AttachmentIds));
                        }
                    }
                } catch (Throwable $th) {
                    $this->logError('Error importing article #' . $row->Id, [$th->getMessage()]);
                }

                $this->progressBar->advance();
            });
        });

        $this->finishProgressBar(
            $this->option('skip-files')
            ? 'Imported article [skip-files]'
            : 'Imported article'
        );
    }
}
