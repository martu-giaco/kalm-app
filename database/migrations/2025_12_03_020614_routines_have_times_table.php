<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routines_have_times', function (Blueprint $table) {
            $table->id(); // opcional pero recomendado

            $table->foreignId('routine_fk')
                ->constrained('routines', 'routine_id')
                ->onDelete('cascade');

            $table->unsignedSmallInteger('time_fk');
            $table->foreign('time_fk')->references('time_id')->on('routine_times');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routines_have_times');
    }
};
