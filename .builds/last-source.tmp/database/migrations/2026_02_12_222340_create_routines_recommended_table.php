<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('routines_recommended', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('test_key');        // Ej: piel, cabello
            $table->string('result_key');      // Ej: normal, seco, graso, mixto, sensible

            $table->string('name');            // Nombre de la rutina
            $table->text('description');       // Descripción de la rutina
            $table->string('frequency')->nullable(); // diaria, semanal, etc.
            $table->string('time_of_day')->nullable(); // mañana, noche, lavado, etc.
            $table->json('products')->nullable();     // IDs de productos recomendados

            $table->unsignedBigInteger('user_test_result_id')->nullable();

            $table->timestamps();

            $table->foreign('user_test_result_id')
                ->references('id')
                ->on('user_test_results')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routines_recommended');
    }
};
