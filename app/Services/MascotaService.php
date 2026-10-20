<?php

namespace App\Services;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class MascotaService
{
    public const MAX_DUENOS = 2;

    /**
     * Asegura la existencia de la tabla pivote y migra los datos preexistentes.
     */
    public static function asegurarTablaMascotaDuenos(): void
    {
        if (! Schema::hasTable('mascota_duenos')) {
            Schema::create('mascota_duenos', function (Blueprint $table) {
                $table->unsignedInteger('id_mascota');
                $table->unsignedInteger('id_usuario');
                $table->boolean('es_principal')->default(false);
                $table->timestamp('fecha_asignacion')->useCurrent();

                $table->primary(['id_mascota', 'id_usuario']);
            });

            if (Schema::hasTable('mascotas') && Schema::hasColumn('mascotas', 'id_usuario')) {
                $existentes = DB::table('mascotas')->whereNotNull('id_usuario')->get();
                foreach ($existentes as $m) {
                    if ($m->id_usuario > 0) {
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
    }

    /**
     * Comprueba si un usuario ya tiene una mascota con el mismo nombre y especie (evitar doble registro).
     */
    public static function usuarioTieneMascotaConNombre(int $userId, string $nombre, ?string $especie = null, ?int $excludeMascotaId = null): bool
    {
        self::asegurarTablaMascotaDuenos();

        $nombreLimpio = mb_strtolower(trim($nombre));
        $especieLimpia = $especie ? mb_strtolower(trim($especie)) : null;

        $mascotaIds = DB::table('mascotas')
            ->where('id_usuario', $userId)
            ->pluck('id_mascota')
            ->toArray();

        $duenosIds = DB::table('mascota_duenos')
            ->where('id_usuario', $userId)
            ->pluck('id_mascota')
            ->toArray();

        $todosIds = array_unique(array_merge($mascotaIds, $duenosIds));

        if (empty($todosIds)) {
            return false;
        }

        $query = DB::table('mascotas')
            ->whereIn('id_mascota', $todosIds)
            ->whereRaw('LOWER(TRIM(nombre)) = ?', [$nombreLimpio]);

        if ($especieLimpia) {
            $query->whereRaw('LOWER(TRIM(especie)) = ?', [$especieLimpia]);
        }

        if ($excludeMascotaId) {
            $query->where('id_mascota', '!=', $excludeMascotaId);
        }

        return $query->exists();
    }

    /**
     * Valida que no exista doble registro antes de guardar. Lanza ValidationException si ya existe.
     */
    public static function validarNoDobleRegistro(int $userId, string $nombre, ?string $especie = null, ?int $excludeMascotaId = null): void
    {
        if (self::usuarioTieneMascotaConNombre($userId, $nombre, $especie, $excludeMascotaId)) {
            $especieTexto = $especie ? " ({$especie})" : '';
            throw ValidationException::withMessages([
                'duplicado' => "El usuario ya tiene una mascota registrada con el nombre '".trim($nombre)."'{$especieTexto}. No se permite el doble registro de la misma mascota para el mismo usuario.",
            ]);
        }
    }

    /**
     * Obtiene los dueños actuales de una mascota (máximo 2).
     */
    public static function getDuenosDeMascota(int $mascotaId): Collection
    {
        self::asegurarTablaMascotaDuenos();

        $duenosPivot = DB::table('mascota_duenos')
            ->join('usuarios', 'mascota_duenos.id_usuario', '=', 'usuarios.id_usuario')
            ->where('mascota_duenos.id_mascota', $mascotaId)
            ->select('usuarios.*', 'mascota_duenos.es_principal', 'mascota_duenos.fecha_asignacion')
            ->orderBy('mascota_duenos.es_principal', 'desc')
            ->orderBy('mascota_duenos.fecha_asignacion', 'asc')
            ->get();

        if ($duenosPivot->isNotEmpty()) {
            return $duenosPivot;
        }

        $mascota = DB::table('mascotas')->where('id_mascota', $mascotaId)->first();
        if ($mascota && ! empty($mascota->id_usuario)) {
            $usuario = DB::table('usuarios')->where('id_usuario', $mascota->id_usuario)->first();
            if ($usuario) {
                DB::table('mascota_duenos')->insertOrIgnore([
                    'id_mascota' => $mascotaId,
                    'id_usuario' => $usuario->id_usuario,
                    'es_principal' => true,
                    'fecha_asignacion' => now(),
                ]);
                $usuario->es_principal = true;
                $usuario->fecha_asignacion = now();

                return collect([$usuario]);
            }
        }

        return collect();
    }

    /**
     * Comprueba si un usuario es dueño de una mascota.
     */
    public static function usuarioEsDuenoDeMascota(int $userId, int $mascotaId): bool
    {
        self::asegurarTablaMascotaDuenos();

        $enPivot = DB::table('mascota_duenos')
            ->where('id_mascota', $mascotaId)
            ->where('id_usuario', $userId)
            ->exists();

        if ($enPivot) {
            return true;
        }

        return DB::table('mascotas')
            ->where('id_mascota', $mascotaId)
            ->where('id_usuario', $userId)
            ->exists();
    }

    /**
     * Obtiene todas las mascotas que pertenecen a un usuario (como dueño principal o secundario).
     */
    public static function getMascotasDeUsuario(int $userId): Collection
    {
        self::asegurarTablaMascotaDuenos();

        $idsPivot = DB::table('mascota_duenos')
            ->where('id_usuario', $userId)
            ->pluck('id_mascota')
            ->toArray();

        $idsDirectos = DB::table('mascotas')
            ->where('id_usuario', $userId)
            ->pluck('id_mascota')
            ->toArray();

        $todosIds = array_unique(array_merge($idsPivot, $idsDirectos));

        if (empty($todosIds)) {
            return collect();
        }

        return DB::table('mascotas')
            ->whereIn('id_mascota', $todosIds)
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * Asignar una mascota a un cliente (por admin o recepcionista).
     *
     * Valida:
     * 1. Que no exceda el límite máximo de 2 dueños por mascota.
     * 2. Que la mascota no esté ya asignada a ese cliente.
     * 3. Que el cliente no tenga ya otra mascota con el mismo nombre y especie.
     */
    public static function asignarDueno(int $mascotaId, int $userId): array
    {
        self::asegurarTablaMascotaDuenos();

        $mascota = DB::table('mascotas')->where('id_mascota', $mascotaId)->first();
        if (! $mascota) {
            throw ValidationException::withMessages([
                'mascota' => 'La mascota especificada no existe.',
            ]);
        }

        $usuario = DB::table('usuarios')->where('id_usuario', $userId)->first();
        if (! $usuario) {
            throw ValidationException::withMessages([
                'usuario' => 'El cliente especificado no existe.',
            ]);
        }

        // 1. Evitar asignar la misma mascota al mismo usuario dos veces
        if (self::usuarioEsDuenoDeMascota($userId, $mascotaId)) {
            throw ValidationException::withMessages([
                'duplicado' => "El cliente {$usuario->nombre} ya está registrado como dueño de {$mascota->nombre}.",
            ]);
        }

        // 2. Comprobar límite de máximo 2 dueños
        $duenosActuales = self::getDuenosDeMascota($mascotaId);
        if ($duenosActuales->count() >= self::MAX_DUENOS) {
            throw ValidationException::withMessages([
                'limite' => 'La mascota ya cuenta con el número máximo de '.self::MAX_DUENOS.' dueños permitidos. Quita un dueño antes de asignar uno nuevo.',
            ]);
        }

        // 3. Evitar que el usuario tenga otra mascota con el mismo nombre y especie (evitar doble registro)
        if (self::usuarioTieneMascotaConNombre($userId, $mascota->nombre, $mascota->especie, $mascotaId)) {
            throw ValidationException::withMessages([
                'duplicado' => "El cliente {$usuario->nombre} ya tiene otra mascota registrada con el nombre '{$mascota->nombre}' ({$mascota->especie}). No se permite doble registro.",
            ]);
        }

        // Asignar en tabla pivote
        $esPrincipal = $duenosActuales->isEmpty();
        DB::table('mascota_duenos')->insert([
            'id_mascota' => $mascotaId,
            'id_usuario' => $userId,
            'es_principal' => $esPrincipal,
            'fecha_asignacion' => now(),
        ]);

        // Si la mascota no tenía dueño directo, actualizar id_usuario
        if (empty($mascota->id_usuario) || $esPrincipal) {
            DB::table('mascotas')->where('id_mascota', $mascotaId)->update([
                'id_usuario' => $userId,
            ]);
        }

        return [
            'success' => true,
            'mensaje' => "Se ha asignado a {$usuario->nombre} como dueño de {$mascota->nombre} exitosamente.",
        ];
    }

    /**
     * Quitar/desasignar un dueño de una mascota (por admin o recepcionista).
     */
    public static function quitarDueno(int $mascotaId, int $userId): array
    {
        self::asegurarTablaMascotaDuenos();

        $mascota = DB::table('mascotas')->where('id_mascota', $mascotaId)->first();
        if (! $mascota) {
            throw ValidationException::withMessages([
                'mascota' => 'La mascota especificada no existe.',
            ]);
        }

        $usuario = DB::table('usuarios')->where('id_usuario', $userId)->first();
        $nombreUsuario = $usuario ? $usuario->nombre : "Usuario #{$userId}";

        if (! self::usuarioEsDuenoDeMascota($userId, $mascotaId)) {
            throw ValidationException::withMessages([
                'dueno' => 'El usuario no figura como dueño de esta mascota.',
            ]);
        }

        DB::table('mascota_duenos')
            ->where('id_mascota', $mascotaId)
            ->where('id_usuario', $userId)
            ->delete();

        $otroDueno = DB::table('mascota_duenos')
            ->where('id_mascota', $mascotaId)
            ->first();

        if ($otroDueno) {
            DB::table('mascota_duenos')
                ->where('id_mascota', $mascotaId)
                ->where('id_usuario', $otroDueno->id_usuario)
                ->update(['es_principal' => true]);

            DB::table('mascotas')->where('id_mascota', $mascotaId)->update([
                'id_usuario' => $otroDueno->id_usuario,
            ]);
        } else {
            try {
                DB::table('mascotas')->where('id_mascota', $mascotaId)->update([
                    'id_usuario' => null,
                ]);
            } catch (\Throwable $e) {
                // Si la columna id_usuario no permite nulos en SQLite, no romper
            }
        }

        return [
            'success' => true,
            'mensaje' => "Se ha quitado a {$nombreUsuario} como dueño de {$mascota->nombre}.",
        ];
    }

    /**
     * Crear una mascota con validación de doble registro y asociación automática de 1 o 2 dueños.
     */
    public static function crearMascotaConDuenos(array $datos, int $idUsuarioPrincipal, ?int $idUsuarioSecundario = null): int
    {
        self::asegurarTablaMascotaDuenos();

        $nombre = trim($datos['nombre']);
        $especie = trim($datos['especie']);

        self::validarNoDobleRegistro($idUsuarioPrincipal, $nombre, $especie);

        if ($idUsuarioSecundario) {
            if ($idUsuarioSecundario === $idUsuarioPrincipal) {
                throw ValidationException::withMessages([
                    'id_usuario_secundario' => 'El segundo dueño no puede ser el mismo que el dueño principal.',
                ]);
            }
            self::validarNoDobleRegistro($idUsuarioSecundario, $nombre, $especie);
        }

        $mascotaData = [
            'id_usuario' => $idUsuarioPrincipal,
            'nombre' => $nombre,
            'especie' => $especie,
            'raza' => ! empty($datos['raza']) ? trim($datos['raza']) : null,
            'peso' => ! empty($datos['peso']) ? $datos['peso'] : null,
        ];

        if (Schema::hasColumn('mascotas', 'edad')) {
            $mascotaData['edad'] = isset($datos['edad']) && $datos['edad'] !== '' && $datos['edad'] !== null ? (int) $datos['edad'] : null;
        }

        $mascotaId = DB::table('mascotas')->insertGetId($mascotaData);

        DB::table('mascota_duenos')->insert([
            'id_mascota' => $mascotaId,
            'id_usuario' => $idUsuarioPrincipal,
            'es_principal' => true,
            'fecha_asignacion' => now(),
        ]);

        if ($idUsuarioSecundario) {
            DB::table('mascota_duenos')->insert([
                'id_mascota' => $mascotaId,
                'id_usuario' => $idUsuarioSecundario,
                'es_principal' => false,
                'fecha_asignacion' => now(),
            ]);
        }

        return $mascotaId;
    }

    /**
     * Buscar mascota de un usuario por nombre y opcionalmente especie.
     */
    public static function buscarMascotaDeUsuarioPorNombre(int $userId, string $nombre, ?string $especie = null): ?object
    {
        self::asegurarTablaMascotaDuenos();

        $mascotas = self::getMascotasDeUsuario($userId);
        $nombreLimpio = mb_strtolower(trim($nombre));
        $especieLimpia = $especie ? mb_strtolower(trim($especie)) : null;

        return $mascotas->first(function ($m) use ($nombreLimpio, $especieLimpia) {
            $nombreCoincide = mb_strtolower(trim($m->nombre)) === $nombreLimpio;
            if (! $nombreCoincide) {
                return false;
            }
            if ($especieLimpia) {
                return mb_strtolower(trim($m->especie)) === $especieLimpia;
            }

            return true;
        });
    }
}
