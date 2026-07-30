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
        Schema::dropIfExists('routine_needs');
        Schema::dropIfExists('routine_times');

        // Re-habilitar FK
        Schema::enableForeignKeyConstraints();

        // Tabla de tiempos de rutina
        Schema::create('routine_times', function (Blueprint $table) {
            $table->bigIncrements('time_id');
            $table->string('name');
            $table->timestamps();
        });

        // Tabla de necesidades de rutina
        Schema::create('routine_needs', function (Blueprint $table) {
            $table->bigIncrements('need_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('routines', function (Blueprint $table) {
            $table->bigIncrements('routine_id');
            $table->string('name');
            $table->json('steps')->nullable();

            // Columnas para notificaciones del dispositivo
            $table->time('reminder_time')->nullable();
            $table->boolean('is_reminder_enabled')->default(false);

            // Frecuencia y configuración del recordatorio
            $table->string('reminder_frequency')->default('none'); // none | daily | weekly | every_x_days
            $table->json('reminder_days')->nullable(); // ['mon','wed','fri'] para frecuencia semanal
            $table->unsignedTinyInteger('reminder_interval')->nullable(); // cada X días

            // Seguimiento del estado del recordatorio (push notifications)
            $table->date('last_completed_at')->nullable(); // última fecha en que se marcó como completada
            $table->timestamp('last_notified_at')->nullable(); // última vez que se envió la notificación
            $table->timestamp('snoozed_until')->nullable(); // si el usuario pospuso, hasta cuándo

            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('time_id')->nullable();
            $table->unsignedBigInteger('need_id')->nullable();

            // FKs
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('time_id')->references('time_id')->on('routine_times')->nullOnDelete();
            $table->foreign('need_id')->references('need_id')->on('routine_needs')->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('types')->nullOnDelete();
        });

        // Pivot
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
        Schema::dropIfExists('routine_needs');
        Schema::dropIfExists('routine_times');
    }
};