<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_test_results', function (Blueprint $table) {
            // Cambiar routine_id para que sea nullable
            $table->unsignedBigInteger('routine_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_test_results', function (Blueprint $table) {
            $table->unsignedBigInteger('routine_id')->nullable(false)->change();
        });
    }
};
