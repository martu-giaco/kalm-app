<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añade la columna 'role' con valor por defecto
            $table->string('role')->default('free')->after('password');

            // Añade la columna 'theme' (nullable)
            // Usamos 'enum' o 'string' con validación en el modelo/request. Usaremos string.
            $table->string('theme')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Para revertir: elimina las columnas
            $table->dropColumn('theme');
            $table->dropColumn('role');
        });
    }
};
