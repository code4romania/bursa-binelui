<?php

declare(strict_types=1);

use App\Enums\OrganizationStatus;
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
            $table->string('slug')->unique();
            $table->string('cif')->unique();
            $table->text('description');
            $table->string('address');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->boolean('accepts_volunteers')->default(true);
            $table->text('why_volunteer')->nullable();
            $table->string('status')->default(OrganizationStatus::pending->value);
            $table->text('eu_platesc_merchant_id')->nullable();
            $table->text('eu_platesc_private_key')->nullable();
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
