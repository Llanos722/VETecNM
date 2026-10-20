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
        if (Schema::hasTable('mascotas') && ! Schema::hasColumn('mascotas', 'edad')) {
            Schema::table('mascotas', function (Blueprint $table) {
                $table->integer('edad')->nullable()->after('raza');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mascotas') && Schema::hasColumn('mascotas', 'edad')) {
            Schema::table('mascotas', function (Blueprint $table) {
                $table->dropColumn('edad');
            });
        }
    }
};
