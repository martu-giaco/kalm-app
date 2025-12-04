<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->unsignedBigInteger('time_id')->nullable()->after('user_id');
            $table->foreign('time_id')->references('time_id')->on('routine_times')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->dropForeign(['time_id']);
            $table->dropColumn('time_id');
        });
    }
};

