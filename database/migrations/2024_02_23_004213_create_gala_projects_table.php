<?php

declare(strict_types=1);

use App\Models\Gala;
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
        Schema::create('gala_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Gala::class);
            $table->foreignIdFor(Organization::class);
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('youth')->nullable();
            $table->string('organization_type')->nullable();
            $table->text('reason')->nullable();
            $table->text('solution')->nullable();
            $table->text('project_details')->nullable();
            $table->text('special')->nullable();
            $table->text('results')->nullable();
            $table->text('proud')->nullable();
            $table->boolean('partnership')->nullable();
            $table->text('partnership_details')->nullable();
            $table->text('budget_details')->nullable();
            $table->string('area')->nullable();
            $table->text('participants')->nullable();
            $table->text('team_details')->nullable();
            $table->json('contact')->nullable();
            $table->boolean('info_by_email')->nullable();
            $table->string('status')->nullable();
            $table->boolean('eligible')->nullable();
            $table->boolean('short_list')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gala_projects');
    }
};
