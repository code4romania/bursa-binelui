<?php

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
        Schema::create('regional_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignIdFor(Organization::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('for_youth')->default(false);
            $table->text('identified_need')->nullable();
            $table->text('proposed_solution')->nullable();
            $table->text('project_progress')->nullable();
            $table->text('project_differentiator')->nullable();
            $table->text('key_results')->nullable();
            $table->text('pride_success')->nullable();
            $table->boolean('had_partners')->default(false);
            $table->text('project_budget')->nullable();
            $table->string('impact_area')->nullable();
            $table->text('participant_count')->nullable();
            $table->text('project_team')->nullable();
            $table->text('info_sources')->nullable();
            $table->json('contact_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regional_projects');
    }
};
