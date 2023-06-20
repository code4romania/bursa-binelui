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
        Schema::create('activity_domain_organization', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ActivityDomain::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Organization::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_domain_organization');
    }
};
