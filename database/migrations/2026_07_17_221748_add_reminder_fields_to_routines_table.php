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
        Schema::table('routines', function (Blueprint $table) {
            // Agregamos las 3 columnas necesarias para los recordatorios
            $table->string('reminder_frequency')->default('none')->after('is_reminder_enabled');
            $table->json('reminder_days')->nullable()->after('reminder_frequency');
            $table->integer('reminder_interval')->nullable()->after('reminder_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            // Por si alguna vez necesitas hacer un rollback
            $table->dropColumn(['reminder_frequency', 'reminder_days', 'reminder_interval']);
        });
    }
};