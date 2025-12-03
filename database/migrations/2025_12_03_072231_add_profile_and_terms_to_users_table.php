<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Verificamos cada columna antes de intentar crearla
        if (! Schema::hasTable('users')) {
            // Si no existe la tabla users algo anda mal; podrías lanzar excepción o crearla.
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            // Agregá sólo si NO existe cada columna
            // NOTA: Schema::hasColumn se llama fuera del closure cuando sea necesario
        });

        // Comprobaciones fuera del closure (más seguras para hasColumn)
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->unique();
            });
        }

        if (! Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar')->nullable();
            });
        }

        if (! Schema::hasColumn('users', 'bio')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('bio')->nullable();
            });
        }

        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user');
            });
        }

        if (! Schema::hasColumn('users', 'theme')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('theme')->nullable();
            });
        }

        if (! Schema::hasColumn('users', 'accepted_terms')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('accepted_terms')->default(false);
            });
        }

        if (! Schema::hasColumn('users', 'terms_accepted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('terms_accepted_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        // En down() hacé lo inverso sólo si querés eliminar columnas
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'terms_accepted_at')) {
                $table->dropColumn('terms_accepted_at');
            }
            if (Schema::hasColumn('users', 'accepted_terms')) {
                $table->dropColumn('accepted_terms');
            }
            if (Schema::hasColumn('users', 'theme')) {
                $table->dropColumn('theme');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'bio')) {
                $table->dropColumn('bio');
            }
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
