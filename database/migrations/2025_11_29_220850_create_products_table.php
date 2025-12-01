<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Relaciones
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('product_types')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();

            // Datos del producto
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('activos')->nullable();
            $table->string('formato')->nullable();
            $table->integer('rating')->nullable();
            $table->string('donde_comprar')->nullable(); // mejor usar snake_case

            $table->timestamps();

            // Índices opcionales
            $table->index('type_id');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
