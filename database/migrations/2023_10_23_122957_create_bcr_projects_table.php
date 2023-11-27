<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\County;
use App\Models\ProjectCategory;
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
        Schema::create('bcr_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProjectCategory::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(County::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(City::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('facebook_link')->nullable();
            $table->boolean('is_national')->default(false);
            $table->boolean('accepting_comments')->default(false);
            $table->json('videos')->nullable();
            $table->json('external_links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_c_r_projects');
    }
};
