<?php

declare(strict_types=1);

use App\Models\ArticleCategory;
use App\Models\Championship;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('title');
            $table->json('slug');
            $table->json('content');
            $table->json('author');
            $table->boolean('is_published')->default(true);

            $table->foreignIdFor(ArticleCategory::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Championship::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
