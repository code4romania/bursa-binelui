<?php

declare(strict_types=1);

use App\Models\GalaProject;
use App\Models\Prize;
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
        Schema::create('gala_project_prize', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(GalaProject::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Prize::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }
};
