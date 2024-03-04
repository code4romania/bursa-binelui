<?php

declare(strict_types=1);

use App\Models\EditionCategories;
use App\Models\GalaProject;
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
        Schema::create('edition_categories_gala_project', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EditionCategories::class);
            $table->foreignIdFor(GalaProject::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_edition_categories_gala_project');
    }
};
