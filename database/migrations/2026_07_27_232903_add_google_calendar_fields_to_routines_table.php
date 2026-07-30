<?php

// database/migrations/xxxx_xx_xx_add_google_calendar_fields_to_routines_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            if (!Schema::hasColumn('routines', 'is_reminder_enabled')) {
                $table->boolean('is_reminder_enabled')->default(false);
            }
            if (!Schema::hasColumn('routines', 'reminder_time')) {
                $table->time('reminder_time')->nullable();
            }
            if (!Schema::hasColumn('routines', 'reminder_frequency')) {
                $table->string('reminder_frequency')->default('daily');
            }
            if (!Schema::hasColumn('routines', 'reminder_days')) {
                $table->json('reminder_days')->nullable();
            }
            if (!Schema::hasColumn('routines', 'reminder_interval')) {
                $table->integer('reminder_interval')->nullable();
            }
            if (!Schema::hasColumn('routines', 'google_event_id')) {
                $table->string('google_event_id')->nullable();
            }
            if (!Schema::hasColumn('routines', 'notification_channel')) {
                $table->string('notification_channel')->default('google_calendar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->dropColumn([
                'is_reminder_enabled',
                'reminder_time',
                'reminder_frequency',
                'reminder_days',
                'reminder_interval',
                'google_event_id',
                'notification_channel'
            ]);
        });
    }
};
