<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->text('bio')->nullable()->after('avatar');
        });
    }

    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        if (Schema::hasColumn('users', 'username')) {
            $table->dropColumn('username');
        }
        if (Schema::hasColumn('users', 'avatar')) {
            $table->dropColumn('avatar');
        }
        if (Schema::hasColumn('users', 'bio')) {
            $table->dropColumn('bio');
        }
    });
}


};
