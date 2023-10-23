<?php

declare(strict_types=1);

use App\Enums\BadgeType;
use App\Models\Badge;
use App\Models\BadgeCategory;
use App\Models\User;
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
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(BadgeCategory::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('rule')->nullable();
            $table->string('type')->default(BadgeType::MANUAL->value);
            $table->text('description')->nullable();
        });

        Schema::create('badge_user', function (Blueprint $table) {
            $table->id();
            $table->timestamp('allocated_at')->nullable();
            $table->foreignIdFor(Badge::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
        });
    }
};
