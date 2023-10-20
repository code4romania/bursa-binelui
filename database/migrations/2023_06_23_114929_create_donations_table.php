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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Organization::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Project::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\ChampionshipStage::class)->nullable()->constrained()->cascadeOnDelete();
            $table->uuid('uuid');
            $table->float('amount');
            $table->float('charge_amount');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('status');
            $table->string('card_status')->nullable();
            $table->string('card_holder_status_message')->nullable();
            $table->dateTime('approval_date')->nullable();
            $table->dateTime('charge_date')->nullable();
            $table->boolean('updated_without_correct_e_pid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
