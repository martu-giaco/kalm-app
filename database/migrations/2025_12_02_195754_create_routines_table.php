<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routines', function (Blueprint $table) {
            $table->id('routine_id');

            // FK al usuario dueño de la rutina
            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade'); // si el user se borra, se borran sus rutinas

            $table->string('name');

            // Solo permite 'dia' o 'noche'
            $table->enum('type', ['dia', 'noche']);

            // Productos en JSON (lista, ids, etc.)
            $table->json('products')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routines');
    }
};
