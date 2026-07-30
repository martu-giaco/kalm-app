<?php
// database/migrations/2026_07_17_221748_add_reminder_fields_to_routines_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            if (!Schema::hasColumn('routines', 'reminder_frequency')) {
                $table->string('reminder_frequency')->default('none')->after('is_reminder_enabled');
            }
            if (!Schema::hasColumn('routines', 'reminder_days')) {
                $table->json('reminder_days')->nullable()->after('reminder_frequency');
            }
            if (!Schema::hasColumn('routines', 'reminder_interval')) {
                $table->unsignedTinyInteger('reminder_interval')->nullable()->after('reminder_days');
            }
        });
    }

    public function down(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->dropColumn(['reminder_frequency', 'reminder_days', 'reminder_interval']);
        });
    }
};