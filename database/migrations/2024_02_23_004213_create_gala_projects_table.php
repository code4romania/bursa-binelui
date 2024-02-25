<?php

use App\Models\Edition;
use App\Models\Gala;
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
            $table->foreignIdFor(Edition::class);
            $table->foreignIdFor(Gala::class);
            $table->string('title', 200);
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('categories');
            $table->boolean('youth');
            $table->string('organization_type');
            $table->text('reason');
            $table->text('solution');
            $table->text('project_details');
            $table->text('special');
            $table->text('results');
            $table->text('proud');
            $table->boolean('partnership');
            $table->text('partnership_details');
            $table->text('budget_details');
            $table->string('area');
            $table->text('participants');
            $table->text('team_details');
            $table->text('contact_name');
            $table->text('contact_position');
            $table->text('contact_phone_number');
            $table->text('contact_email');
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
