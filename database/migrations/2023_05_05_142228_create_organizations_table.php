<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\County;
use App\Models\City;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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
            $table->string('website');
            $table->boolean('accepts_volunteers')->default(true);
            $table->text('why_volunteer')->nullable();
            $table->string('activity_domains');
            $table->enum('status', ['pending', 'active', 'disabled']);
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
