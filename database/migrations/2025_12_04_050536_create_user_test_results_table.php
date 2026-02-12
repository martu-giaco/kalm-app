<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('routine_id')->nullable(); // Ahora es nullable
            $table->string('test_key')->nullable();
            $table->string('result_key')->nullable();
            $table->json('answers')->nullable();
            $table->timestamps();

            // FK (opcional: comenta si no querés fk)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('routine_id')->references('routine_id')->on('routines')->onDelete('set null'); // Set null en lugar de cascade
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_test_results');
    }
};
