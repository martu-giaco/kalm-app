<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('routines', function (Blueprint $table) {
            $table->id('routine_id');
            $table->string('name');
            $table->json('products')->nullable(); // aquí guardamos los productos
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routines');
    }
};
