<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class CitaService
{
    /**
     * Lista oficial de profesionales de salud y estética de VETecNM.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getProfesionales(): array
    {
        return [
            [
                'id' => 'dra-valenzuela',
                'nombre' => 'Dra. Sofía Valenzuela Méndez',
                'puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'especialidad' => 'Cirugía Veterinaria & Traumatología',
                'tipo' => 'salud',
                'categorias' => [
                    'Cirugía y Hospitalización',
                    'Consultas y Diagnóstico',
                    'Medicina Preventiva',
                    'Urgencias Médicas',
                    'Urgencias',
                ],
                'servicios' => [
                    'Cirugía de Tejidos Blandos y Traumatología',
                    'Esterilización y Castración Segura',
                    'Hospitalización y Cuidados Intensivos (UCI)',
                    'Consulta Médica General y Pediátrica',
                    'Consulta Médica General',
                    'Consulta Médica',
                    'Revisión General de Rutina',
                    'Urgencia Médica Inmediata',
                    'Laboratorio Clínico y Análisis Sanguíneo',
                    'Esquema de Vacunación Canina y Felina',
                    'Desparasitación Interna y Externa',
                    'Implantación de Microchip y Certificados',
                ],
            ],
            [
                'id' => 'dr-gomez',
                'nombre' => 'Dr. Alejandro Gómez Morales',
                'puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'especialidad' => 'Medicina Interna & Diagnóstico por Imagen',
                'tipo' => 'salud',
                'categorias' => [
                    'Consultas y Diagnóstico',
                    'Cirugía y Hospitalización',
                    'Medicina Preventiva',
                    'Urgencias Médicas',
                    'Urgencias',
                ],
                'servicios' => [
                    'Imagenología (Rayos X y Ultrasonido Digital)',
                    'Imagenología',
                    'Laboratorio Clínico y Análisis Sanguíneo',
                    'Consulta Médica General y Pediátrica',
                    'Consulta Médica General',
                    'Consulta Médica',
                    'Revisión General de Rutina',
                    'Hospitalización y Cuidados Intensivos (UCI)',
                    'Esquema de Vacunación Canina y Felina',
                    'Desparasitación Interna y Externa',
                    'Implantación de Microchip y Certificados',
                    'Urgencia Médica Inmediata',
                ],
            ],
            [
                'id' => 'dra-rivas',
                'nombre' => 'Dra. Mariana Rivas Torres',
                'puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'especialidad' => 'Medicina Preventiva & Dermatología',
                'tipo' => 'salud',
                'categorias' => [
                    'Medicina Preventiva',
                    'Consultas y Diagnóstico',
                    'Urgencias Médicas',
                    'Urgencias',
                ],
                'servicios' => [
                    'Esquema de Vacunación Canina y Felina',
                    'Desparasitación Interna y Externa',
                    'Implantación de Microchip y Certificados',
                    'Vacunación y Desparasitación',
                    'Vacunación',
                    'Consulta Médica General y Pediátrica',
                    'Consulta Médica General',
                    'Consulta Médica',
                    'Revisión General de Rutina',
                    'Laboratorio Clínico y Análisis Sanguíneo',
                    'Urgencia Médica Inmediata',
                ],
            ],
            [
                'id' => 'tec-silva',
                'nombre' => 'Téc. Roberto Silva Hernández',
                'puesto' => 'Técnico Veterinario Certificado (T.V.C.)',
                'especialidad' => 'Estilismo Canino Profesional & Manejo Fear Free',
                'tipo' => 'estetica',
                'categorias' => [
                    'Estética Mascotas',
                    'Estética',
                ],
                'servicios' => [
                    'Baño Médico / Antipulgas y Spa Canino',
                    'Corte de Raza y Estilismo Profesional',
                    'Profilaxis y Limpieza Dental Ultrasónica',
                ],
            ],
        ];
    }

    /**
     * Retorna los profesionales aptos para un servicio determinado o categoría.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getProfesionalesPorServicio(?string $nombreServicio): array
    {
        $todos = self::getProfesionales();

        if (empty($nombreServicio)) {
            return $todos;
        }

        $srvNorm = strtolower(trim($nombreServicio));

        // 1. Filtrar por coincidencia en la lista específica de servicios del profesional
        $filtrados = array_filter($todos, function ($p) use ($srvNorm) {
            if (! empty($p['servicios'])) {
                foreach ($p['servicios'] as $s) {
                    if (strtolower(trim($s)) === $srvNorm || str_contains($srvNorm, strtolower(trim($s))) || str_contains(strtolower(trim($s)), $srvNorm)) {
                        return true;
                    }
                }
            }

            return false;
        });

        if (! empty($filtrados)) {
            return array_values($filtrados);
        }

        // 2. Si no hubo coincidencia directa por nombre, buscar la categoría del servicio
        $categoria = null;
        if (Schema::hasTable('servicios')) {
            $registro = DB::table('servicios')
                ->where(function ($q) use ($srvNorm) {
                    $q->whereRaw('LOWER(TRIM(nombre)) = ?', [$srvNorm])
                        ->orWhereRaw('? LIKE CONCAT("%", LOWER(TRIM(nombre)), "%")', [$srvNorm]);
                })
                ->first();
            if ($registro && ! empty($registro->categoria)) {
                $categoria = trim($registro->categoria);
            }
        }

        // Deducir categoría por palabras clave si no está en la BD
        if (! $categoria) {
            if (str_contains($srvNorm, 'estétic') || str_contains($srvNorm, 'baño') || str_contains($srvNorm, 'corte') || str_contains($srvNorm, 'profilaxis') || str_contains($srvNorm, 'spa')) {
                $categoria = 'Estética Mascotas';
            } elseif (str_contains($srvNorm, 'cirug') || str_contains($srvNorm, 'esteril') || str_contains($srvNorm, 'castra') || str_contains($srvNorm, 'hospital')) {
                $categoria = 'Cirugía y Hospitalización';
            } elseif (str_contains($srvNorm, 'vacun') || str_contains($srvNorm, 'desparasit') || str_contains($srvNorm, 'microchip') || str_contains($srvNorm, 'preventiv')) {
                $categoria = 'Medicina Preventiva';
            } else {
                $categoria = 'Consultas y Diagnóstico';
            }
        }

        $filtradosCat = array_filter($todos, function ($p) use ($categoria) {
            if (! empty($p['categorias'])) {
                foreach ($p['categorias'] as $cat) {
                    if (strcasecmp($cat, $categoria) === 0) {
                        return true;
                    }
                }
            }
            if ($categoria === 'Estética Mascotas') {
                return ($p['tipo'] ?? '') === 'estetica';
            }

            return ($p['tipo'] ?? '') === 'salud';
        });

        return ! empty($filtradosCat) ? array_values($filtradosCat) : $todos;
    }

    /**
     * Valida si un profesional dado está capacitado para prestar un servicio específico.
     */
    public static function esProfesionalAptoParaServicio(?string $profesional, ?string $servicio): bool
    {
        if (empty($profesional) || empty($servicio)) {
            return true;
        }

        $profesionalesAptos = self::getProfesionalesPorServicio($servicio);
        $profNorm = strtolower(trim($profesional));

        foreach ($profesionalesAptos as $p) {
            if (strtolower(trim($p['nombre'])) === $profNorm || strtolower(trim($p['id'])) === $profNorm) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mapa estructurado de servicio => nombres de profesionales aptos para consumo frontend.
     *
     * @return array<string, array<int, string>>
     */
    public static function getMapaServiciosProfesionales(): array
    {
        $servicios = self::getServicios();
        $mapa = [];

        foreach ($servicios as $srv) {
            $aptos = self::getProfesionalesPorServicio($srv['nombre']);
            $mapa[$srv['nombre']] = array_map(fn ($p) => $p['nombre'], $aptos);
        }

        // Servicios adicionales comunes (Urgencia, Revisión de Rutina)
        $extras = ['Urgencia Médica Inmediata', 'Revisión General de Rutina', 'Consulta Médica General'];
        foreach ($extras as $extra) {
            if (! isset($mapa[$extra])) {
                $aptos = self::getProfesionalesPorServicio($extra);
                $mapa[$extra] = array_map(fn ($p) => $p['nombre'], $aptos);
            }
        }

        return $mapa;
    }

    /**
     * Valida que la fecha y hora no hayan pasado y que tengan al menos 30 minutos de anticipación.
     *
     * @throws ValidationException
     */
    public static function validarTiempoMinimo(string $fecha, string $hora): void
    {
        $horaPartes = explode(':', trim($hora));
        if (count($horaPartes) >= 2) {
            $h = str_pad($horaPartes[0], 2, '0', STR_PAD_LEFT);
            $m = str_pad($horaPartes[1], 2, '0', STR_PAD_LEFT);
            $horaNormalizada = "{$h}:{$m}";
        } else {
            $horaNormalizada = substr($hora, 0, 5);
        }

        try {
            $citaDateTime = Carbon::createFromFormat('Y-m-d H:i', "{$fecha} {$horaNormalizada}", config('app.timezone'));
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'hora' => ['Formato de fecha u hora no válido.'],
            ]);
        }

        $ahora = Carbon::now(config('app.timezone'));
        $minimoPermitido = (clone $ahora)->addMinutes(30);

        if ($citaDateTime->lessThanOrEqualTo($ahora)) {
            throw ValidationException::withMessages([
                'hora' => ['No es posible agendar una cita en un horario que ya ha pasado. Por favor selecciona una fecha y hora futura.'],
            ]);
        }

        if ($citaDateTime->lessThan($minimoPermitido)) {
            throw ValidationException::withMessages([
                'hora' => ['No es posible agendar una cita con menos de media hora (30 minutos) de anticipación respecto al horario actual.'],
            ]);
        }
    }

    /**
     * Comprueba si una mascota ya tiene una cita activa agendada en la fecha dada.
     */
    public static function mascotaTieneCitaEnFecha(int $idMascota, string $fecha, ?int $excludeCitaId = null): bool
    {
        if (! Schema::hasTable('citas')) {
            return false;
        }

        $query = DB::table('citas')
            ->where('id_mascota', $idMascota)
            ->where('fecha', $fecha)
            ->where('estado', '!=', 'Cancelada');

        if ($excludeCitaId) {
            $query->where('id_cita', '!=', $excludeCitaId);
        }

        return $query->exists();
    }

    /**
     * Valida que una mascota solo tenga como máximo UNA cita por día.
     * Impide registrar más de una cita para la misma mascota en la misma fecha (excepto canceladas).
     *
     * @throws ValidationException
     */
    public static function validarDuplicado(int $idMascota, string $fecha, string $hora, string $motivo, ?string $servicio = null, ?int $excludeCitaId = null): void
    {
        if (! Schema::hasTable('citas')) {
            return;
        }

        $query = DB::table('citas')
            ->where('id_mascota', $idMascota)
            ->where('fecha', $fecha)
            ->where('estado', '!=', 'Cancelada');

        if ($excludeCitaId) {
            $query->where('id_cita', '!=', $excludeCitaId);
        }

        $citaExistente = $query->first();

        if ($citaExistente) {
            $horaExistente = substr($citaExistente->hora, 0, 5);
            $nombreMascota = '';
            if (Schema::hasTable('mascotas')) {
                $m = DB::table('mascotas')->where('id_mascota', $idMascota)->first();
                if ($m) {
                    $nombreMascota = " '{$m->nombre}'";
                }
            }

            throw ValidationException::withMessages([
                'duplicado' => ["La mascota{$nombreMascota} ya cuenta con una cita agendada para el día {$fecha} a las {$horaExistente} hrs. Solo se permite una cita al día por mascota."],
            ]);
        }
    }

    /**
     * Valida que el profesional no tenga citas simultáneas ni bloqueos/recesos (R-32).
     * Retorna array con resultado y mensaje si no está disponible.
     *
     * @return array{disponible: bool, mensaje: ?string}
     */
    public static function verificarDisponibilidadTrabajador(?string $profesional, string $fecha, string $hora, ?int $excludeCitaId = null): array
    {
        if (! Schema::hasTable('citas')) {
            return ['disponible' => true, 'mensaje' => null];
        }

        $horaPartes = explode(':', trim($hora));
        $horaCorta = (count($horaPartes) >= 2)
            ? str_pad($horaPartes[0], 2, '0', STR_PAD_LEFT).':'.str_pad($horaPartes[1], 2, '0', STR_PAD_LEFT)
            : substr($hora, 0, 5);
        $horaNormalizada = "{$horaCorta}:00";

        // Si no se especificó un profesional (por ejemplo "Cualquier Profesional"), verificar si la capacidad total de la clínica está llena
        if (empty($profesional)) {
            $totalProfesionales = count(self::getProfesionales());
            $citasMismaHora = DB::table('citas')
                ->where('fecha', $fecha)
                ->where(function ($q) use ($horaCorta, $horaNormalizada) {
                    $q->where('hora', $horaNormalizada)
                        ->orWhere('hora', 'like', "{$horaCorta}%");
                })
                ->where('estado', '!=', 'Cancelada');

            if ($excludeCitaId) {
                $citasMismaHora->where('id_cita', '!=', $excludeCitaId);
            }

            if ($citasMismaHora->count() >= $totalProfesionales) {
                return [
                    'disponible' => false,
                    'mensaje' => "Todos los especialistas se encuentran ocupados en ese horario ({$horaCorta}). Por favor selecciona otro horario o doctor.",
                ];
            }

            return ['disponible' => true, 'mensaje' => null];
        }

        $profesional = trim($profesional);

        // 1. Impedir citas simultáneas para el mismo trabajador
        if (Schema::hasColumn('citas', 'profesional')) {
            $citaSimultaneaQuery = DB::table('citas')
                ->where(function ($q) use ($profesional) {
                    $q->where('profesional', $profesional)
                        ->orWhereRaw('LOWER(TRIM(profesional)) = ?', [strtolower($profesional)]);
                })
                ->where('fecha', $fecha)
                ->where(function ($q) use ($horaCorta, $horaNormalizada) {
                    $q->where('hora', $horaNormalizada)
                        ->orWhere('hora', 'like', "{$horaCorta}%");
                })
                ->where('estado', '!=', 'Cancelada');

            if ($excludeCitaId) {
                $citaSimultaneaQuery->where('id_cita', '!=', $excludeCitaId);
            }

            if ($citaSimultaneaQuery->exists()) {
                return [
                    'disponible' => false,
                    'mensaje' => "El profesional {$profesional} ya tiene una cita asignada en ese horario ({$horaCorta}).",
                ];
            }
        }

        // 2. Verificar bloqueos de disponibilidad del personal (R-34)
        if (Schema::hasTable('bloqueos_personal')) {
            $bloqueo = DB::table('bloqueos_personal')
                ->where(function ($q) use ($profesional) {
                    $q->where('profesional', $profesional)
                        ->orWhereRaw('LOWER(TRIM(profesional)) = ?', [strtolower($profesional)]);
                })
                ->where('fecha', $fecha)
                ->where('activo', true)
                ->where(function ($q) use ($horaNormalizada) {
                    $q->where(function ($sub) {
                        $sub->whereNull('hora_inicio')->whereNull('hora_fin'); // Todo el día
                    })->orWhere(function ($sub) use ($horaNormalizada) {
                        $sub->where('hora_inicio', '<=', $horaNormalizada)
                            ->where('hora_fin', '>', $horaNormalizada);
                    });
                })
                ->first();

            if ($bloqueo) {
                return [
                    'disponible' => false,
                    'mensaje' => "El profesional {$profesional} no se encuentra disponible debido a: {$bloqueo->motivo}.",
                ];
            }
        }

        return ['disponible' => true, 'mensaje' => null];
    }

    /**
     * Calcula los horarios disponibles según el trabajador, horario de la clínica,
     * recesos, días no laborables y la regla de tiempo (R-31).
     *
     * @return array{disponible: bool, motivo_cierre: ?string, slots: array<int, string>}
     */
    public static function obtenerHorariosDisponibles(string $fecha, ?string $profesional = null, ?string $servicio = null, ?int $idMascota = null, ?int $excludeCitaId = null): array
    {
        // 0. Verificar si la mascota ya tiene una cita activa para este día (R-Cita-Unica)
        if ($idMascota && self::mascotaTieneCitaEnFecha($idMascota, $fecha, $excludeCitaId)) {
            return [
                'disponible' => false,
                'motivo_cierre' => 'Esta mascota ya cuenta con una cita agendada para esta fecha. Solo se permite una cita al día por mascota.',
                'slots' => [],
            ];
        }

        // 1. Verificar si es un día no laborable oficial (R-31, R-34)
        if (Schema::hasTable('dias_no_laborables')) {
            $diaNoLaborable = DB::table('dias_no_laborables')
                ->where('fecha', $fecha)
                ->where('activo', true)
                ->first();

            if ($diaNoLaborable) {
                return [
                    'disponible' => false,
                    'motivo_cierre' => "Día no laborable en la clínica: {$diaNoLaborable->motivo}",
                    'slots' => [],
                ];
            }
        }

        $dateObj = Carbon::parse($fecha);
        $diaSemana = $dateObj->dayOfWeekIso; // 1 = Lunes ... 7 = Domingo

        // 2. Horario laboral de la clínica para este día (R-31, R-34)
        $configHorario = null;
        if (Schema::hasTable('configuracion_horarios')) {
            $configHorario = DB::table('configuracion_horarios')
                ->where('dia_semana', $diaSemana)
                ->first();
        }

        if ($configHorario && ! $configHorario->activo) {
            return [
                'disponible' => false,
                'motivo_cierre' => 'La clínica no presta servicio en este día de la semana.',
                'slots' => [],
            ];
        }

        if (! $configHorario && $diaSemana === 7) {
            $horaApertura = Carbon::parse("{$fecha} 09:00:00");
            $horaCierre = Carbon::parse("{$fecha} 14:00:00");
            $intervalo = 30;
        } elseif (! $configHorario && $diaSemana === 6) {
            $horaApertura = Carbon::parse("{$fecha} 09:00:00");
            $horaCierre = Carbon::parse("{$fecha} 17:00:00");
            $intervalo = 30;
        } else {
            $aperturaStr = $configHorario ? $configHorario->hora_apertura : '08:00:00';
            $cierreStr = $configHorario ? $configHorario->hora_cierre : '20:00:00';
            $horaApertura = Carbon::parse("{$fecha} {$aperturaStr}");
            $horaCierre = Carbon::parse("{$fecha} {$cierreStr}");
            $intervalo = (int) ($configHorario ? ($configHorario->intervalo_minutos ?: 30) : 30);
        }

        // 3. Recesos activos (R-31, R-34)
        $recesos = collect();
        if (Schema::hasTable('horarios_recesos')) {
            $recesos = DB::table('horarios_recesos')
                ->where('activo', true)
                ->where(function ($q) use ($profesional) {
                    $q->where('aplica_a', 'todos');
                    if ($profesional) {
                        $q->orWhere('aplica_a', $profesional);
                    }
                })
                ->get();
        }

        // 4. Bloqueos de disponibilidad del profesional (R-34)
        $bloqueos = collect();
        if ($profesional && Schema::hasTable('bloqueos_personal')) {
            $bloqueos = DB::table('bloqueos_personal')
                ->where('profesional', $profesional)
                ->where('fecha', $fecha)
                ->where('activo', true)
                ->get();
        }

        // Si tiene bloqueo de día completo
        $bloqueoDiaCompleto = $bloqueos->first(fn ($b) => empty($b->hora_inicio) && empty($b->hora_fin));
        if ($bloqueoDiaCompleto) {
            return [
                'disponible' => false,
                'motivo_cierre' => "El profesional {$profesional} no tiene disponibilidad en esta fecha: {$bloqueoDiaCompleto->motivo}",
                'slots' => [],
            ];
        }

        // 5. Citas ya agendadas con el profesional para no permitir simultáneas (R-32)
        $citasOcupadas = [];
        if (Schema::hasTable('citas')) {
            if ($profesional && Schema::hasColumn('citas', 'profesional')) {
                $profesional = trim($profesional);
                $citasOcupadas = DB::table('citas')
                    ->where(function ($q) use ($profesional) {
                        $q->where('profesional', $profesional)
                            ->orWhereRaw('LOWER(TRIM(profesional)) = ?', [strtolower($profesional)]);
                    })
                    ->where('fecha', $fecha)
                    ->where('estado', '!=', 'Cancelada')
                    ->pluck('hora')
                    ->map(fn ($h) => substr($h, 0, 5))
                    ->toArray();
            } else {
                $profesionalesAptos = self::getProfesionalesPorServicio($servicio);
                $nombresAptos = array_map(fn ($p) => $p['nombre'], $profesionalesAptos);
                $totalProfesionales = count($profesionalesAptos) ?: count(self::getProfesionales());

                $queryCitas = DB::table('citas')
                    ->where('fecha', $fecha)
                    ->where('estado', '!=', 'Cancelada');

                if (! empty($servicio) && ! empty($nombresAptos)) {
                    $queryCitas->whereIn('profesional', $nombresAptos);
                }

                $citasOcupadas = $queryCitas
                    ->select(DB::raw('SUBSTRING(hora, 1, 5) as hora_corta'), DB::raw('COUNT(*) as total'))
                    ->groupBy('hora_corta')
                    ->having('total', '>=', $totalProfesionales)
                    ->pluck('hora_corta')
                    ->toArray();
            }
        }

        // 6. Generar todos los intervalos y filtrar
        $slots = [];
        $cursor = clone $horaApertura;
        $tz = config('app.timezone');
        $ahora = Carbon::now($tz);
        $minimoPermitido = (clone $ahora)->addMinutes(30);

        while ($cursor->copy()->addMinutes($intervalo)->lessThanOrEqualTo($horaCierre)) {
            $horaSlotStr = $cursor->format('H:i');
            $slotDateTime = Carbon::parse("{$fecha} {$horaSlotStr}", $tz);

            $valido = true;

            // Regla de tiempo: descartar si ya pasó o si faltan menos de 30 minutos
            if ($slotDateTime->lessThan($minimoPermitido)) {
                $valido = false;
            }

            // Descartar si cae dentro de algún receso
            if ($valido) {
                foreach ($recesos as $rec) {
                    $iniRec = Carbon::parse("{$fecha} {$rec->hora_inicio}", $tz);
                    $finRec = Carbon::parse("{$fecha} {$rec->hora_fin}", $tz);

                    if ($cursor->greaterThanOrEqualTo($iniRec) && $cursor->lessThan($finRec)) {
                        $valido = false;
                        break;
                    }
                }
            }

            // Descartar si cae en bloqueo por rango de horas del trabajador
            if ($valido && $profesional) {
                foreach ($bloqueos as $blq) {
                    if (! empty($blq->hora_inicio) && ! empty($blq->hora_fin)) {
                        $iniBlq = Carbon::parse("{$fecha} {$blq->hora_inicio}", $tz);
                        $finBlq = Carbon::parse("{$fecha} {$blq->hora_fin}", $tz);

                        if ($cursor->greaterThanOrEqualTo($iniBlq) && $cursor->lessThan($finBlq)) {
                            $valido = false;
                            break;
                        }
                    }
                }
            }

            // Descartar si el horario ya está ocupado
            if ($valido && in_array($horaSlotStr, $citasOcupadas, true)) {
                $valido = false;
            }

            if ($valido) {
                $slots[] = $horaSlotStr;
            }

            $cursor->addMinutes($intervalo);
        }

        return [
            'disponible' => count($slots) > 0,
            'motivo_cierre' => count($slots) === 0 ? 'No hay horarios disponibles para los criterios seleccionados en esta fecha.' : null,
            'slots' => $slots,
        ];
    }

    /**
     * Obtiene el listado de todos los servicios activos con sus precios y detalles.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getServicios(): array
    {
        if (Schema::hasTable('servicios')) {
            $servicios = DB::table('servicios')->where('activo', true)->orderBy('id_servicio')->get();
            if ($servicios->isNotEmpty()) {
                return $servicios->map(function ($s) {
                    return [
                        'id_servicio' => $s->id_servicio,
                        'categoria' => $s->categoria,
                        'nombre' => $s->nombre,
                        'descripcion' => $s->descripcion,
                        'precio' => (float) $s->precio,
                        'precio_texto' => $s->precio_texto ?? ('$'.number_format($s->precio, 2).' MXN'),
                        'duracion' => $s->duracion,
                        'incluye' => $s->incluye,
                    ];
                })->toArray();
            }
        }

        return [
            [
                'id_servicio' => 1,
                'categoria' => 'Consultas y Diagnóstico',
                'nombre' => 'Consulta Médica General y Pediátrica',
                'descripcion' => 'Evaluación clínica completa para cachorros y adultos.',
                'precio' => 350.00,
                'precio_texto' => '$350 MXN',
                'duracion' => '30 - 45 min',
                'incluye' => 'Toma de signos vitales, pesaje, diagnóstico clínico y receta.',
            ],
        ];
    }

    /**
     * Obtiene los servicios agrupados por categoría con sus precios y detalles.
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    public static function getServiciosPorCategoria(): array
    {
        $todos = self::getServicios();
        $agrupados = [];

        foreach ($todos as $srv) {
            $cat = $srv['categoria'];
            if (! isset($agrupados[$cat])) {
                $agrupados[$cat] = [];
            }
            $agrupados[$cat][] = $srv;
        }

        return $agrupados;
    }

    /**
     * Obtiene el precio numérico base de un servicio por su nombre.
     */
    public static function getPrecioServicio(?string $nombreServicio): float
    {
        if (empty($nombreServicio)) {
            return 350.00;
        }

        $nombreLimpio = trim($nombreServicio);

        if (Schema::hasTable('servicios')) {
            $srv = DB::table('servicios')
                ->where(function ($q) use ($nombreLimpio) {
                    $q->where('nombre', $nombreLimpio)
                        ->orWhereRaw('LOWER(TRIM(nombre)) = ?', [strtolower($nombreLimpio)]);
                })
                ->first();

            if ($srv) {
                return (float) $srv->precio;
            }
        }

        $defaultMap = [
            'Consulta Médica General y Pediátrica' => 350.00,
            'Consulta Médica General' => 350.00,
            'Consulta Médica' => 350.00,
            'Revisión General de Rutina' => 350.00,
            'Urgencia Médica Inmediata' => 500.00,
            'Laboratorio Clínico y Análisis Sanguíneo' => 450.00,
            'Imagenología (Rayos X y Ultrasonido Digital)' => 600.00,
            'Esterilización y Castración Segura' => 1200.00,
            'Cirugía de Tejidos Blandos y Traumatología' => 1500.00,
            'Hospitalización y Cuidados Intensivos (UCI)' => 800.00,
            'Esquema de Vacunación Canina y Felina' => 280.00,
            'Desparasitación Interna y Externa' => 150.00,
            'Implantación de Microchip y Certificados' => 650.00,
            'Baño Médico / Antipulgas y Spa Canino' => 250.00,
            'Corte de Raza y Estilismo Profesional' => 350.00,
            'Profilaxis y Limpieza Dental Ultrasónica' => 900.00,
        ];

        return $defaultMap[$nombreLimpio] ?? 350.00;
    }

    /**
     * Formatea los datos de una cita garantizando que el precio y el motivo estén claramente definidos.
     *
     * @param  object|array<string, mixed>  $cita
     * @return array<string, mixed>
     */
    public static function formatearDetallesCita($cita): array
    {
        $obj = (object) $cita;
        $servicio = $obj->servicio ?? null;
        $precio = isset($obj->precio) && is_numeric($obj->precio) && $obj->precio > 0
            ? (float) $obj->precio
            : self::getPrecioServicio($servicio);

        $motivo = ! empty($obj->motivo) ? $obj->motivo : ($servicio ?? 'Consulta Médica General');

        return [
            'precio' => $precio,
            'precio_formateado' => '$'.number_format($precio, 2).' MXN',
            'motivo' => $motivo,
            'notas' => $obj->notas ?? null,
            'servicio' => $servicio ?? 'Consulta Médica General',
        ];
    }
}
