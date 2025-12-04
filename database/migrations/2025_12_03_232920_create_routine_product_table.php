<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routine_product', function (Blueprint $table) {
            $table->id(); // id de la tabla pivot
            $table->unsignedBigInteger('routine_id'); // FK hacia routines(routine_id)
            $table->foreign('routine_id')
                  ->references('routine_id') // aquí apuntamos a routine_id
                  ->on('routines')
                  ->onDelete('cascade');

            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // FK hacia products(id)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routine_product');
    }
};
