<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_test_results', function (Blueprint $table) {

            $table->dropForeign(['routine_id']);

            Schema::table('user_test_results', function (Blueprint $table) {
            // Índice único compuesto: 1 resultado por usuario y por test_key
            $table->unique(['user_id', 'test_key'], 'unique_user_test_per_type');
        });

            // 2. Hacer la columna nullable
            $table->unsignedBigInteger('routine_id')->nullable()->change();

            // 3. Recrear la foreign key con SET NULL
            $table->foreign('routine_id')
                ->references('routine_id')           // clave primaria de la tabla routines
                ->on('routines')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('user_test_results', function (Blueprint $table) {
            // Revertir: eliminar FK actual
            $table->dropForeign(['routine_id']);

            // Volver a NOT NULL (como estaba originalmente)
            $table->unsignedBigInteger('routine_id')->nullable(false)->change();

            // Recrear FK sin SET NULL (la versión más común por defecto es RESTRICT)
            $table->foreign('routine_id')
                ->references('routine_id')
                ->on('routines')
                ->cascadeOnDelete();

            $table->dropUnique('unique_user_test_per_type');
        });
    }
};
