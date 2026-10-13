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
        if (Schema::hasTable('usuarios') && ! Schema::hasColumn('usuarios', 'telefono')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->string('telefono', 20)->nullable()->after('email');
            });
        }

        if (Schema::hasTable('citas') && ! Schema::hasColumn('citas', 'telefono_contacto')) {
            Schema::table('citas', function (Blueprint $table) {
                $table->string('telefono_contacto', 20)->nullable()->after('hora');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'telefono')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropColumn('telefono');
            });
        }

        if (Schema::hasTable('citas') && Schema::hasColumn('citas', 'telefono_contacto')) {
            Schema::table('citas', function (Blueprint $table) {
                $table->dropColumn('telefono_contacto');
            });
        }
    }
};
