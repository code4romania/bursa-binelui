<?php

declare(strict_types=1);

use App\Enums\OrganizationStatus;
use App\Models\City;
use App\Models\County;
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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('cif');
            $table->string('logo')->nullable();
            $table->text('description');
            $table->string('status_document')->nullable();
            $table->foreignIdFor(County::class)->constrained();
            $table->foreignIdFor(City::class)->constrained();
            $table->string('street_address');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('website')->nullable();
            $table->boolean('accepts_volunteers')->default(true);
            $table->text('why_volunteer')->nullable();
            $table->json('activity_domains');
            $table->string('status')->default(OrganizationStatus::pending->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
