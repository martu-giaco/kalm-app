<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->unsignedSmallInteger('time_fk')->nullable()->after('name');
            $table->foreign('time_fk')->references('time_id')->on('routine_times');
        });
    }

    public function down(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->dropForeign(['time_fk']);
            $table->dropColumn('time_fk');
        });
    }
};
