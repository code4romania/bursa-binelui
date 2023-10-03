<?php

declare(strict_types=1);

use App\Models\Organization;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class)->constrained()->cascadeOnDelete();
            $table->string('status')->default('draft');
            $table->boolean('is_national')->default(false);
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->integer('target_budget')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->date('archived_at')->nullable();
            $table->text('description')->nullable();
            $table->text('scope')->nullable();
            $table->text('beneficiaries')->nullable();
            $table->text('reason_to_donate')->nullable();
            $table->boolean('accepting_volunteers')->default(false);
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
        Schema::dropIfExists('projects');
    }
};
