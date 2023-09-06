<?php

declare(strict_types=1);

use App\Enums\VolunteerStatus;
use App\Models\Volunteer;
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
        Schema::create('model_has_volunteers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('model');
            $table->foreignIdFor(Volunteer::class)->constrained()->cascadeOnDelete();
            $table->string('status')->default(VolunteerStatus::PENDING->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_volunteers');
    }
};
