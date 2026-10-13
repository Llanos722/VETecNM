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
     * @return array<int, array<string, string>>
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
            ],
            [
                'id' => 'dr-gomez',
                'nombre' => 'Dr. Alejandro Gómez Morales',
                'puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'especialidad' => 'Medicina Interna & Diagnóstico por Imagen',
                'tipo' => 'salud',
            ],
            [
                'id' => 'dra-rivas',
                'nombre' => 'Dra. Mariana Rivas Torres',
                'puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'especialidad' => 'Medicina Preventiva & Dermatología',
                'tipo' => 'salud',
            ],
            [
                'id' => 'tec-silva',
                'nombre' => 'Téc. Roberto Silva Hernández',
                'puesto' => 'Técnico Veterinario Certificado (T.V.C.)',
                'especialidad' => 'Estilismo Canino Profesional & Manejo Fear Free',
                'tipo' => 'estetica',
            ],
        ];
    }

    /**
     * Valida que la fecha y hora no hayan pasado y que tengan al menos 30 minutos de anticipación.
     *
     * @throws ValidationException
     */
    public static function validarTiempoMinimo(string $fecha, string $hora): void
    {
        $horaNormalizada = strlen($hora) === 5 ? $hora : substr($hora, 0, 5);

        try {
            $citaDateTime = Carbon::createFromFormat('Y-m-d H:i', "{$fecha} {$horaNormalizada}");
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'hora' => ['Formato de fecha u hora no válido.'],
            ]);
        }

        $ahora = Carbon::now();
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
     * Valida que no exista una cita duplicada por el mismo motivo, la misma hora y la misma mascota.
     *
     * @throws ValidationException
     */
    public static function validarDuplicado(int $idMascota, string $fecha, string $hora, string $motivo, ?string $servicio = null, ?int $excludeCitaId = null): void
    {
        $horaNormalizada = strlen($hora) === 5 ? "{$hora}:00" : $hora;
        $motivoLimpio = trim(strtolower($motivo));

        $query = DB::table('citas')
            ->where('id_mascota', $idMascota)
            ->where('fecha', $fecha)
            ->where(function ($q) use ($hora, $horaNormalizada) {
                $q->where('hora', $hora)
                    ->orWhere('hora', $horaNormalizada)
                    ->orWhere('hora', substr($hora, 0, 5));
            })
            ->where('estado', '!=', 'Cancelada');

        if ($excludeCitaId) {
            $query->where('id_cita', '!=', $excludeCitaId);
        }

        $citasExistentes = $query->get();

        foreach ($citasExistentes as $cita) {
            $motivoExistente = trim(strtolower($cita->motivo));
            $servicioExistente = ! empty($cita->servicio) ? trim(strtolower($cita->servicio)) : null;

            // Coincidencia exacta o contenida en el motivo o servicio
            $coincideMotivo = ($motivoExistente === $motivoLimpio)
                || (str_contains($motivoExistente, $motivoLimpio))
                || (str_contains($motivoLimpio, $motivoExistente));

            $coincideServicio = false;
            if ($servicio && $servicioExistente) {
                $coincideServicio = ($servicioExistente === trim(strtolower($servicio)));
            }

            if ($coincideMotivo || $coincideServicio) {
                throw ValidationException::withMessages([
                    'duplicado' => ['Ya existe una cita agendada para esta mascota en la misma fecha y hora con el mismo motivo. No se permiten citas duplicadas.'],
                ]);
            }
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
        if (empty($profesional)) {
            return ['disponible' => true, 'mensaje' => null];
        }

        $horaCorta = substr($hora, 0, 5);
        $horaNormalizada = "{$horaCorta}:00";

        // 1. Impedir citas simultáneas para el mismo trabajador
        $citaSimultaneaQuery = DB::table('citas')
            ->where('profesional', $profesional)
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

        // 2. Verificar bloqueos de disponibilidad del personal (R-34)
        $bloqueo = DB::table('bloqueos_personal')
            ->where('profesional', $profesional)
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

        return ['disponible' => true, 'mensaje' => null];
    }

    /**
     * Calcula los horarios disponibles según el trabajador, horario de la clínica,
     * recesos, días no laborables y la regla de tiempo (R-31).
     *
     * @return array{disponible: bool, motivo_cierre: ?string, slots: array<int, string>}
     */
    public static function obtenerHorariosDisponibles(string $fecha, ?string $profesional = null, ?string $servicio = null): array
    {
        // 1. Verificar si es un día no laborable oficial (R-31, R-34)
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

        $dateObj = Carbon::parse($fecha);
        $diaSemana = $dateObj->dayOfWeekIso; // 1 = Lunes ... 7 = Domingo

        // 2. Horario laboral de la clínica para este día (R-31, R-34)
        $configHorario = DB::table('configuracion_horarios')
            ->where('dia_semana', $diaSemana)
            ->first();

        if (! $configHorario || ! $configHorario->activo) {
            return [
                'disponible' => false,
                'motivo_cierre' => 'La clínica no presta servicio en este día de la semana.',
                'slots' => [],
            ];
        }

        $horaApertura = Carbon::parse("{$fecha} {$configHorario->hora_apertura}");
        $horaCierre = Carbon::parse("{$fecha} {$configHorario->hora_cierre}");
        $intervalo = (int) ($configHorario->intervalo_minutos ?: 30);

        // 3. Recesos activos (R-31, R-34)
        $recesos = DB::table('horarios_recesos')
            ->where('activo', true)
            ->where(function ($q) use ($profesional) {
                $q->where('aplica_a', 'todos');
                if ($profesional) {
                    $q->orWhere('aplica_a', $profesional);
                }
            })
            ->get();

        // 4. Bloqueos de disponibilidad del profesional (R-34)
        $bloqueos = collect();
        if ($profesional) {
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
        $citasOcupadas = collect();
        if ($profesional) {
            $citasOcupadas = DB::table('citas')
                ->where('profesional', $profesional)
                ->where('fecha', $fecha)
                ->where('estado', '!=', 'Cancelada')
                ->pluck('hora')
                ->map(fn ($h) => substr($h, 0, 5))
                ->toArray();
        }

        // 6. Generar todos los intervalos y filtrar
        $slots = [];
        $cursor = clone $horaApertura;
        $ahora = Carbon::now();
        $minimoPermitido = (clone $ahora)->addMinutes(30);

        while ($cursor->copy()->addMinutes($intervalo)->lessThanOrEqualTo($horaCierre)) {
            $horaSlotStr = $cursor->format('H:i');
            $slotDateTime = Carbon::parse("{$fecha} {$horaSlotStr}");

            $valido = true;

            // Regla de tiempo: descartar si ya pasó o si faltan menos de 30 minutos
            if ($slotDateTime->lessThan($minimoPermitido)) {
                $valido = false;
            }

            // Descartar si cae dentro de algún receso
            if ($valido) {
                foreach ($recesos as $rec) {
                    $iniRec = Carbon::parse("{$fecha} {$rec->hora_inicio}");
                    $finRec = Carbon::parse("{$fecha} {$rec->hora_fin}");

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
                        $iniBlq = Carbon::parse("{$fecha} {$blq->hora_inicio}");
                        $finBlq = Carbon::parse("{$fecha} {$blq->hora_fin}");

                        if ($cursor->greaterThanOrEqualTo($iniBlq) && $cursor->lessThan($finBlq)) {
                            $valido = false;
                            break;
                        }
                    }
                }
            }

            // Descartar si el trabajador ya tiene una cita simultánea
            if ($valido && $profesional && in_array($horaSlotStr, $citasOcupadas, true)) {
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
            return 0.0;
        }

        if (Schema::hasTable('servicios')) {
            $srv = DB::table('servicios')->where('nombre', trim($nombreServicio))->first();
            if ($srv) {
                return (float) $srv->precio;
            }
        }

        $defaultMap = [
            'Consulta Médica General y Pediátrica' => 350.00,
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

        return $defaultMap[trim($nombreServicio)] ?? 0.0;
    }
}
