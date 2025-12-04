<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->unsignedSmallInteger('routine_type_id')->nullable()->after('routine_id');

            $table->foreign('routine_type_id')
                ->references('type_id')
                ->on('routine_types')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('routines', function (Blueprint $table) {
            $table->dropForeign(['routine_type_id']);
            $table->dropColumn('routine_type_id');
        });
    }
};
