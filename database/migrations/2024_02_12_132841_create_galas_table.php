<?php

use App\Models\Edition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Edition::class);
            $table->string('title');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->date('start_sign_up');
            $table->date('end_sign_up');
            $table->date('start_validate');
            $table->date('end_validate');
            $table->date('start_evaluation');
            $table->date('end_evaluation');
            $table->dateTime('start_gale');
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galas');
    }
};
