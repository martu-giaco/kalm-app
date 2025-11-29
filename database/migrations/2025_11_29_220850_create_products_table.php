<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('brand_id'); //marca del producto
            $table->string('image')->nullable();
            $table->text('description');
            $table->string('ingredients');
            $table->string('activos');
            $table->string('paso');
            $table->string('formato');
            $table->string('tipo'); //piel o pelo -- oleosa, mixta seca o sensible
            $table->tinyInteger('rating'); //lo de las estrellitas ni idea como vamos a hacer ughh
            $table->string('dondeComprar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
