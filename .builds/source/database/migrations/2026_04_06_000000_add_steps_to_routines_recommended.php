<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('routines_recommended', function (Blueprint $table) {
            // Agregar campo para los pasos de la rutina
            $table->json('steps')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('routines_recommended', function (Blueprint $table) {
            $table->dropColumn('steps');
        });
    }
};
