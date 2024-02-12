<?php

declare(strict_types=1);

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
        Schema::create('championship_stage_project', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Project::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\ChampionshipStage::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Championship::class)->constrained()->cascadeOnDelete();
            $table->string('status')->default(false);
            $table->integer('number_of_donation')->nullable()->default(null);
            $table->integer('amount_of_donation')->nullable()->default(null);
            $table->integer('rating')->storedAs('`number_of_donation`*`amount_of_donation`')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('championship_stage_project');
    }
};
