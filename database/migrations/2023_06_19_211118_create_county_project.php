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
        Schema::create('county_project', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\County::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Project::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('county_project');
    }
};
