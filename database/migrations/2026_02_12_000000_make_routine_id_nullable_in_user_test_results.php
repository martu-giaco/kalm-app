<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_test_results', function (Blueprint $table) {

            // 1 eliminar foreign key
            $table->dropForeign(['routine_id']);

            // 2 hacer nullable
            $table->unsignedBigInteger('routine_id')->nullable()->change();

            // 3 volver a crear foreign key
            $table->foreign('routine_id')
                ->references('id')
                ->on('routines')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('user_test_results', function (Blueprint $table) {

            $table->dropForeign(['routine_id']);

            $table->unsignedBigInteger('routine_id')->nullable(false)->change();

            $table->foreign('routine_id')
                ->references('id')
                ->on('routines');
        });
    }
};
