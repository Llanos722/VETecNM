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
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'telefono')) {
            // Limpiar duplicados previos conservando solo el primer registro
            $duplicados = DB::table('usuarios')
                ->select('telefono')
                ->whereNotNull('telefono')
                ->groupBy('telefono')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('telefono');

            foreach ($duplicados as $tel) {
                $ids = DB::table('usuarios')
                    ->where('telefono', $tel)
                    ->orderBy('id_usuario', 'asc')
                    ->pluck('id_usuario')
                    ->toArray();

                // El primer id conserva el teléfono, los registros posteriores se limpian a null
                array_shift($ids);
                if (! empty($ids)) {
                    DB::table('usuarios')
                        ->whereIn('id_usuario', $ids)
                        ->update(['telefono' => null]);
                }
            }

            try {
                Schema::table('usuarios', function (Blueprint $table) {
                    $table->unique('telefono', 'usuarios_telefono_unique');
                });
            } catch (Throwable $e) {
                // Si el motor de base de datos no soporta añadir la restricción en caliente
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'telefono')) {
            try {
                Schema::table('usuarios', function (Blueprint $table) {
                    $table->dropUnique('usuarios_telefono_unique');
                });
            } catch (Throwable $e) {
                // Ignore if not exists
            }
        }
    }
};
