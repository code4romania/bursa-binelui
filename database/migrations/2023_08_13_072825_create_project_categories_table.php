<?php

declare(strict_types=1);

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\RegionalProject;
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
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('project_category', function (Blueprint $table) {
            $table->foreignIdFor( Project::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProjectCategory::class)->constrained()->cascadeOnDelete();
        });
        Schema::create('regional_project_category', function (Blueprint $table) {
            $table->foreignIdFor(RegionalProject::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProjectCategory::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_categories');
    }
};
