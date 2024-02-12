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
        Schema::create('championship_testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Championship::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('author');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('championship_testimonials');
    }
};
