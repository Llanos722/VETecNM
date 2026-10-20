<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('mascota_duenos')) {
            Schema::create('mascota_duenos', function (Blueprint $table) {
                $table->integer('id_mascota');
                $table->integer('id_usuario');
                $table->boolean('es_principal')->default(false);
                $table->timestamp('fecha_asignacion')->useCurrent();

                $table->primary(['id_mascota', 'id_usuario']);
            });
        }

        // Migrar dueños existentes de la tabla mascotas a la tabla pivote
        if (Schema::hasTable('mascotas') && Schema::hasTable('mascota_duenos')) {
            $mascotas = DB::table('mascotas')->whereNotNull('id_usuario')->get();
            foreach ($mascotas as $m) {
                if ($m->id_usuario) {
                    DB::table('mascota_duenos')->insertOrIgnore([
                        'id_mascota' => $m->id_mascota,
                        'id_usuario' => $m->id_usuario,
                        'es_principal' => true,
                        'fecha_asignacion' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascota_duenos');
    }
};
