<?php

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
        Schema::create('championship_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Championship::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('championship_stages')->cascadeOnDelete();
            $table->date('start_date')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('championship_stages');
    }
};
