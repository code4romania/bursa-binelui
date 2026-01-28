<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const DEFAULTS = [
        ['slug' => 'contact_phone', 'value' => '0757055590'],
        ['slug' => 'contact_email', 'value' => 'contact@bursabinelui.ro'],
        ['slug' => 'project_expiration_notification_days_before', 'value' => '10'],
        ['slug' => 'project_expiration_notification_days_before_reminder', 'value' => '2'],
        ['slug' => 'donation_min_amount', 'value' => '5'],
        ['slug' => 'donation_max_amount', 'value' => '1000'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $now = now();
        foreach (self::DEFAULTS as $row) {
            DB::table('settings')->insert([
                'slug' => $row['slug'],
                'value' => $row['value'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
