<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar tablas si existen
        Schema::dropIfExists('routine_product');
        Schema::dropIfExists('routines_have_types');
        Schema::dropIfExists('routines');
        Schema::dropIfExists('routine_types');
        Schema::dropIfExists('routine_times');

        // Tabla de tiempos de rutina
        Schema::create('routine_times', function (Blueprint $table) {
            $table->bigIncrements('time_id'); // BIGINT UNSIGNED PK
            $table->string('name');
            $table->timestamps();
        });

        // Tabla de tipos de rutina
        Schema::create('routine_types', function (Blueprint $table) {
            $table->smallIncrements('type_id'); // SMALLINT UNSIGNED PK
            $table->string('name');
            $table->timestamps();
        });

        // Tabla principal de rutinas
        Schema::create('routines', function (Blueprint $table) {
            $table->bigIncrements('routine_id'); // BIGINT UNSIGNED PK
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('time_id')->nullable();
            $table->string('name');
            $table->json('products')->nullable();
            $table->json('steps')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('time_id')->references('time_id')->on('routine_times')->onDelete('set null');
        });

        // Pivot: rutinas <-> tipos (muchos a muchos)
        Schema::create('routines_have_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('routine_fk');
            $table->unsignedSmallInteger('type_fk');
            $table->timestamps();

            $table->foreign('routine_fk')->references('routine_id')->on('routines')->onDelete('cascade');
            $table->foreign('type_fk')->references('type_id')->on('routine_types')->onDelete('cascade');
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
        Schema::dropIfExists('routine_times');
    }
};
