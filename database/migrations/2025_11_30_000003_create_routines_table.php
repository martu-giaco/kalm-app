<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Deshabilitar FK temporalmente para evitar conflictos
        Schema::disableForeignKeyConstraints();

        // Eliminar tablas si existen
        Schema::dropIfExists('routine_product');
        Schema::dropIfExists('routines_have_types');
        Schema::dropIfExists('routines');
        Schema::dropIfExists('routine_types');
        Schema::dropIfExists('routine_needs');
        Schema::dropIfExists('routine_times');

        // Re-habilitar FK
        Schema::enableForeignKeyConstraints();

        // Tabla de tiempos de rutina
        Schema::create('routine_times', function (Blueprint $table) {
            $table->bigIncrements('time_id'); // BIGINT UNSIGNED PK
            $table->string('name');
            $table->timestamps();
        });

        // Tabla de tipos de rutina
        Schema::create('routine_types', function (Blueprint $table) {
            $table->id('type_id'); // SMALLINT UNSIGNED PK
            $table->string('name');
            $table->timestamps();
        });

        // Tabla de necesidades de rutina
        Schema::create('routine_needs', function (Blueprint $table) {
            $table->id('need_id'); // SMALLINT UNSIGNED PK
            $table->string('name');
            $table->timestamps();
        });

        // Tabla principal de rutinas
        Schema::create('routines', function (Blueprint $table) {
            $table->id('routine_id'); // BIGINT UNSIGNED PK
            $table->string('name');
            $table->json('products')->nullable();
            $table->json('steps')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('time_id')->nullable()->constrained('routine_times', 'time_id')->nullOnDelete();
            $table->foreignId('need_id')->nullable()->constrained('routine_needs', 'need_id')->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('routine_types', 'type_id')->nullOnDelete();
        });

        // Pivot: rutinas <-> productos (muchos a muchos)
        Schema::create('routine_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('routine_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('routine_id')->references('routine_id')->on('routines')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routine_product');
        Schema::dropIfExists('routines_have_types');
        Schema::dropIfExists('routines');
        Schema::dropIfExists('routine_types');
        Schema::dropIfExists('routine_needs');
        Schema::dropIfExists('routine_times');
    }
};
