<?php

namespace App\Http\Controllers;

use App\Services\CitaService;
use App\Services\MascotaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class LandingController extends Controller
{
    /**
     * Display the Public Landing Page with RF-02, RF-03, RF-04, and RF-05.
     */
    public function index(Request $request)
    {
        // ---------------------------------------------------------------------
        // RF-02: INFORMACIÓN DE LA CLÍNICA, HORARIOS, DÍAS NO LABORABLES, ETC.
        // ---------------------------------------------------------------------
        $clinicaInfo = [
            'nombre' => 'Clínica Veterinaria VETecNM',
            'eslogan' => 'Cuidado compasivo y medicina veterinaria de excelencia para tu mejor amigo.',
            'telefono' => '341-412-0000',
            'whatsapp' => '341-123-4567',
            'email' => 'contacto@vetecnm.com',
            'urgencias' => 'Disponible 24/7 en Sucursal Central',
            'sucursales' => [
                [
                    'nombre' => 'Sucursal Central (Hospital 24/7)',
                    'direccion' => 'Av. Tecnológico #100, Col. Centro, Ciudad Guzmán, Jal.',
                    'telefono' => '341-412-0000',
                    'tipo' => 'Hospital & Urgencias 24/7',
                ],
                [
                    'nombre' => 'Sucursal Norte (Clínica & Estética)',
                    'direccion' => 'Calzada Pedro Ramírez Vázquez #450, Ciudad Guzmán, Jal.',
                    'telefono' => '341-412-8899',
                    'tipo' => 'Consultas, Vacunas & Estética',
                ],
            ],
            'horarios' => [
                'lunes_viernes' => '8:00 AM – 8:00 PM',
                'sabados' => '9:00 AM – 5:00 PM',
                'domingos' => '9:00 AM – 2:00 PM (Urgencias 24 horas)',
            ],
            'dias_no_laborables' => [
                ['fecha' => '1 de Enero', 'motivo' => 'Año Nuevo (Solo guardias médicas de urgencia)'],
                ['fecha' => '5 de Febrero', 'motivo' => 'Día de la Constitución'],
                ['fecha' => '21 de Marzo', 'motivo' => 'Natalicio de Benito Juárez'],
                ['fecha' => '1 de Mayo', 'motivo' => 'Día del Trabajo'],
                ['fecha' => '16 de Septiembre', 'motivo' => 'Día de la Independencia'],
                ['fecha' => '20 de Noviembre', 'motivo' => 'Revolución Mexicana'],
                ['fecha' => '25 de Diciembre', 'motivo' => 'Navidad (Guardias médicas de urgencia)'],
            ],
            'fechas_especiales' => [
                ['fecha' => '24 de Diciembre (Nochebuena)', 'horario' => '8:00 AM – 2:00 PM'],
                ['fecha' => '31 de Diciembre (Fin de Año)', 'horario' => '8:00 AM – 2:00 PM'],
                ['fecha' => 'Jueves y Viernes Santo', 'horario' => '9:00 AM – 3:00 PM (Urgencias activas)'],
            ],
            'protocolos_acceso' => [
                [
                    'icono' => 'fa-dog',
                    'titulo' => 'Perros: Uso Obligatorio de Correa y Collar',
                    'descripcion' => 'Todos los caninos deben ingresar con correa resistente y collar o arnés bien ajustado. Si tu mascota es reactiva, nerviosa o asustadiza, debe portar bozal preventivo.',
                ],
                [
                    'icono' => 'fa-cat',
                    'titulo' => 'Gatos y Pequeñas Especies: Transportadora Rígida',
                    'descripcion' => 'Por su seguridad e instinto de fuga ante sonidos o estrés, los felinos, conejos y aves deben llegar dentro de su transportadora rígida y cerrada con ventilación.',
                ],
                [
                    'icono' => 'fa-book-medical',
                    'titulo' => 'Cartilla de Vacunación al Día',
                    'descripcion' => 'Para servicios de estética canina, cirugías programadas o ingreso a hospitalización, es indispensable presentar su carnet de vacunación vigente.',
                ],
                [
                    'icono' => 'fa-user-clock',
                    'titulo' => 'Acompañamiento y Puntualidad',
                    'descripcion' => 'Se permite máximo 1 persona por paciente dentro del consultorio para no saturar al animal. Te sugerimos llegar con 10 minutos de antelación.',
                ],
            ],
        ];

        // ---------------------------------------------------------------------
        // RF-03: PRESENTACIÓN DE SERVICIOS POR CATEGORÍAS
        // ---------------------------------------------------------------------
        $categoriasServicios = [
            [
                'id' => 'consultas',
                'nombre' => 'Consultas y Diagnóstico',
                'icono' => 'fa-stethoscope',
                'descripcion' => 'Evaluación médica integral, medicina preventiva y estudios clínicos especializados.',
                'servicios' => [
                    [
                        'id_servicio' => 's1',
                        'nombre' => 'Consulta Médica General y Pediátrica',
                        'descripcion_corta' => 'Revisión clínica completa para cachorros y adultos.',
                        'descripcion_larga' => 'Evaluación clínica completa de ojos, oídos, dentadura, sistema cardiovascular, respiratorio y palpación abdominal. Ideal para revisiones rutinarias o diagnósticos primarios.',
                        'duracion' => '30 - 45 min',
                        'incluye' => 'Toma de signos vitales, pesaje, diagnóstico clínico, receta médica y recomendaciones nutricionales.',
                        'precio_aprox' => '$350 MXN',
                        'requisitos' => 'Traer cartilla de vacunación y registro de síntomas recientes.',
                    ],
                    [
                        'id_servicio' => 's2',
                        'nombre' => 'Laboratorio Clínico y Análisis Sanguíneo',
                        'descripcion_corta' => 'Hemogramas, química sanguínea y urianálisis.',
                        'descripcion_larga' => 'Análisis de laboratorio con equipos de alta precisión para perfiles bioquímicos, biometría hemática completa, coproparasitoscópico y pruebas rápidas virales.',
                        'duracion' => '20 min (Resultados en 2 hrs)',
                        'incluye' => 'Toma de muestra estéril, procesamiento laboratorial y entrega digital de resultados con interpretación médica.',
                        'precio_aprox' => '$450 - $950 MXN',
                        'requisitos' => 'Ayuno alimenticio mínimo de 8 horas en caso de análisis sanguíneo.',
                    ],
                    [
                        'id_servicio' => 's3',
                        'nombre' => 'Imagenología (Rayos X y Ultrasonido Digital)',
                        'descripcion_corta' => 'Diagnóstico no invasivo de alta definición.',
                        'descripcion_larga' => 'Estudios de imagen digital para evaluación traumatológica, torácica y ecografía abdominal con doppler para evaluar órganos internos y gestación.',
                        'duracion' => '40 min',
                        'incluye' => 'Placas radiográficas o rastreo ecográfico con informe radiológico emitido por especialista.',
                        'precio_aprox' => '$600 - $1,100 MXN',
                        'requisitos' => 'Vejiga moderadamente llena para ecografía abdominal.',
                    ],
                ],
            ],
            [
                'id' => 'cirugia',
                'nombre' => 'Cirugía y Hospitalización',
                'icono' => 'fa-syringe',
                'descripcion' => 'Procedimientos quirúrgicos seguros con anestesia inhalatoria y monitoreo continuo.',
                'servicios' => [
                    [
                        'id_servicio' => 's4',
                        'nombre' => 'Esterilización y Castración Segura',
                        'descripcion_corta' => 'Control reproductivo y prevención de patologías.',
                        'descripcion_larga' => 'Procedimiento quirúrgico mínimamente invasivo bajo anestesia inhalatoria y analgesia multimodal preventiva tanto en caninos como en felinos.',
                        'duracion' => '1 - 2 hrs (Recuperación ambulatoria)',
                        'incluye' => 'Monitoreo multiparamétrico, medicación postoperatoria inicial y retiro de puntos.',
                        'precio_aprox' => '$1,200 - $2,500 MXN',
                        'requisitos' => 'Ayuno de 10 horas, perfil prequirúrgico previo y paciente clínicamente sano.',
                    ],
                    [
                        'id_servicio' => 's5',
                        'nombre' => 'Cirugía de Tejidos Blandos y Traumatología',
                        'descripcion_corta' => 'Resolución de fracturas, hernias y remoción de masas.',
                        'descripcion_larga' => 'Intervenciones especializadas para corrección ortopédica, enterectomías, cistotomías y resolución de heridas complejas en quirófano estéril.',
                        'duracion' => '2 - 4 hrs',
                        'incluye' => 'Quirófano estéril completo, terapia de fluidos, cuidados intensivos postquirúrgicos.',
                        'precio_aprox' => 'Valoración médica previa',
                        'requisitos' => 'Estudios preoperatorios de sangre y radiografías.',
                    ],
                    [
                        'id_servicio' => 's6',
                        'nombre' => 'Hospitalización y Cuidados Intensivos (UCI)',
                        'descripcion_corta' => 'Atención médica y terapia de fluidos 24 horas.',
                        'descripcion_larga' => 'Área de hospitalización dividida para perros y gatos para reducir estrés, con bombas de infusión continua y oxigenoterapia.',
                        'duracion' => 'Por día / estancia médica',
                        'incluye' => 'Jaulas climatizadas, monitoreo médico 24 horas, administración de medicamentos.',
                        'precio_aprox' => '$800 MXN / noche',
                        'requisitos' => 'Prescripción médica del veterinario tratante.',
                    ],
                ],
            ],
            [
                'id' => 'preventiva',
                'nombre' => 'Medicina Preventiva',
                'icono' => 'fa-shield-dog',
                'descripcion' => 'Programas de inmunización, desparasitación y control periódico de la salud.',
                'servicios' => [
                    [
                        'id_servicio' => 's7',
                        'nombre' => 'Esquema de Vacunación Canina y Felina',
                        'descripcion_corta' => 'Vacunas quíntuple, séxtuple, rabia, triple felina y leucemia.',
                        'descripcion_larga' => 'Aplicación de biológicos de las mejores farmacéuticas internacionales para proteger contra parvovirus, moquillo, rabia, leucemia y calicivirus.',
                        'duracion' => '20 min',
                        'incluye' => 'Revisión física previa de salud, aplicación del biológico, sellado de cartilla oficial.',
                        'precio_aprox' => '$280 - $450 MXN',
                        'requisitos' => 'Mascota sana y sin fiebre ni vómito al momento de la aplicación.',
                    ],
                    [
                        'id_servicio' => 's8',
                        'nombre' => 'Desparasitación Interna y Externa',
                        'descripcion_corta' => 'Erradicación de parásitos gastrointestinales, pulgas y garrapatas.',
                        'descripcion_larga' => 'Dosis ajustada por peso exacto con antiparasitarios orales o pipetas de última generación con efecto residual prolongado.',
                        'duracion' => '15 min',
                        'incluye' => 'Pesaje de precisión, dosificación adecuada y calendario recordatorio.',
                        'precio_aprox' => '$150 - $350 MXN',
                        'requisitos' => 'Ninguno.',
                    ],
                    [
                        'id_servicio' => 's9',
                        'nombre' => 'Implantación de Microchip y Certificados',
                        'descripcion_corta' => 'Identificación permanente y certificados para viajes.',
                        'descripcion_larga' => 'Colocación subdérmica indolora de microchip homologado ISO y emisión de certificado médico internacional para viajes aéreos o terrestres.',
                        'duracion' => '20 min',
                        'incluye' => 'Microchip ISO, registro en base de datos nacional, lector de verificación.',
                        'precio_aprox' => '$650 MXN',
                        'requisitos' => 'Cartilla con vacuna de rabia vigente.',
                    ],
                ],
            ],
            [
                'id' => 'estetica',
                'nombre' => 'Estética Mascotas',
                'icono' => 'fa-shower',
                'descripcion' => 'Higiene, estilismo canino y felino con manejo respetuoso y libre de estrés.',
                'servicios' => [
                    [
                        'id_servicio' => 's10',
                        'nombre' => 'Baño Médico / Antipulgas y Spa Canino',
                        'descripcion_corta' => 'Higiene profunda con dermocosmética y secado tibio.',
                        'descripcion_larga' => 'Baño con champú de avena, hipoalergénico o medicado según la piel, masaje relajante, secado térmico silencioso y perfume hipoalergénico.',
                        'duracion' => '1 - 1.5 hrs',
                        'incluye' => 'Corte de uñas, limpieza de oídos, vaciado de glándulas anales y cepillado profundo.',
                        'precio_aprox' => '$250 - $550 MXN',
                        'requisitos' => 'Mascota con vacunas al día.',
                    ],
                    [
                        'id_servicio' => 's11',
                        'nombre' => 'Corte de Raza y Estilismo Profesional',
                        'descripcion_corta' => 'Corte higiénico o de raza a máquina y tijera.',
                        'descripcion_larga' => 'Diseño y arreglo estético conforme al estándar de la raza (Schnauzer, Poodle, Shih Tzu, etc.) o corte personalizado por estilista certificado.',
                        'duracion' => '1.5 - 2 hrs',
                        'incluye' => 'Baño completo previo, corte de pelaje, pulido de uñas, limpieza de cojinetes.',
                        'precio_aprox' => '$350 - $700 MXN',
                        'requisitos' => 'Sin nudos extremos (o deslanado con cargo adicional).',
                    ],
                    [
                        'id_servicio' => 's12',
                        'nombre' => 'Profilaxis y Limpieza Dental Ultrasónica',
                        'descripcion_corta' => 'Eliminación de sarro, placa bacteriana y mal aliento.',
                        'descripcion_larga' => 'Limpieza dental con cavitador ultrasónico para remover sarro subgingival y pulido con pasta fluorada para prevenir pérdida dental.',
                        'duracion' => '1 hr',
                        'incluye' => 'Revisión odontológica completa, limpieza ultrasónica y pulido dental.',
                        'precio_aprox' => '$900 - $1,800 MXN',
                        'requisitos' => 'Valoración médica previa.',
                    ],
                ],
            ],
        ];

        // ---------------------------------------------------------------------
        // RF-04: PERSONAL MÉDICO Y TÉCNICO
        // ---------------------------------------------------------------------
        $personalMedico = [
            [
                'id' => 'dra-valenzuela',
                'nombre' => 'Dra. Sofía Valenzuela Méndez',
                'rol_puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'cedula' => 'Ced. Prof. 8492014',
                'especialidad' => 'Cirugía Veterinaria & Traumatología',
                'experiencia' => '12 años de trayectoria quirúrgica',
                'avatar_icono' => 'fa-user-doctor',
                'color' => '#2563eb',
                'descripcion' => 'Especialista en intervenciones de tejidos blandos, ortopedia y manejo de pacientes críticos. Miembro activo de la Asociación Mexicana de Médicos Veterinarios.',
                'servicios_ofrecidos' => [
                    'Esterilizaciones y castraciones complejas',
                    'Cirugía ortopédica y reducción de fracturas',
                    'Cirugías exploratorias y oncológicas',
                    'Manejo del dolor postoperatorio',
                ],
            ],
            [
                'id' => 'dr-gomez',
                'nombre' => 'Dr. Alejandro Gómez Morales',
                'rol_puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'cedula' => 'Ced. Prof. 9182305',
                'especialidad' => 'Medicina Interna & Diagnóstico por Imagen',
                'experiencia' => '9 años de experiencia clínica',
                'avatar_icono' => 'fa-stethoscope',
                'color' => '#0d9488',
                'descripcion' => 'Diplomado en Ultrasonografía Abdominal y Cardiología Veterinaria. Apasionado por el diagnóstico certero y el tratamiento de enfermedades crónicas.',
                'servicios_ofrecidos' => [
                    'Consultas diagnósticas especializadas',
                    'Ecografías abdominales y cardíacas',
                    'Interpretación de estudios laboratoriales',
                    'Planes de salud geriátricos',
                ],
            ],
            [
                'id' => 'dra-rivas',
                'nombre' => 'Dra. Mariana Rivas Torres',
                'rol_puesto' => 'Médico Veterinario Zootecnista (M.V.Z.)',
                'cedula' => 'Ced. Prof. 10293847',
                'especialidad' => 'Medicina Preventiva & Dermatología',
                'experiencia' => '7 años de práctica clínica',
                'avatar_icono' => 'fa-shield-virus',
                'color' => '#7c3aed',
                'descripcion' => 'Especializada en alergias caninas, enfermedades de la piel, nutrición terapéutica y esquemas preventivos de vacunación para cachorros y adultos.',
                'servicios_ofrecidos' => [
                    'Control y tratamiento de dermatitis y alergias',
                    'Inmunizaciones y calendarios de vacunas',
                    'Nutrición clínica y dietas especializadas',
                    'Certificados médicos de viaje internacional',
                ],
            ],
            [
                'id' => 'tec-silva',
                'nombre' => 'Téc. Roberto Silva Hernández',
                'rol_puesto' => 'Técnico Veterinario Certificado (T.V.C.)',
                'cedula' => 'Reg. Técnico 48210',
                'especialidad' => 'Estilismo Canino Profesional & Manejo Fear Free',
                'experiencia' => '6 años en bienestar estético animal',
                'avatar_icono' => 'fa-scissors',
                'color' => '#d97706',
                'descripcion' => 'Certificado en técnicas de manejo libre de miedo y estrés ("Fear Free"). Experto en estética de exposición, baños dermatológicos y cuidados de higiene.',
                'servicios_ofrecidos' => [
                    'Cortes de raza a tijera y máquina',
                    'Baños medicados y tratamientos dérmicos',
                    'Limpieza dental profiláctica preventiva',
                    'Manejo positivo para mascotas nerviosas',
                ],
            ],
        ];

        // ---------------------------------------------------------------------
        // RF-05: INICIO DE AGENDAMIENTO & CALENDARIO SEMANAL
        // ---------------------------------------------------------------------
        $offsetSemana = (int) $request->query('offset', 0);
        $inicioSemana = Carbon::now()->startOfWeek()->addWeeks($offsetSemana);
        $finSemana = (clone $inicioSemana)->endOfWeek();

        // Generar los días de la semana (Lunes a Domingo)
        $diasSemana = [];
        for ($i = 0; $i < 7; $i++) {
            $diaFecha = (clone $inicioSemana)->addDays($i);
            $diasSemana[] = [
                'fecha_iso' => $diaFecha->toDateString(),
                'dia_nombre' => ucfirst($diaFecha->locale('es')->isoFormat('dddd')),
                'dia_numero' => $diaFecha->format('d'),
                'mes_nombre' => ucfirst($diaFecha->locale('es')->isoFormat('MMM')),
                'es_hoy' => $diaFecha->isToday(),
                'es_pasado' => $diaFecha->isPast() && ! $diaFecha->isToday(),
            ];
        }

        // Obtener citas existentes en la base de datos para esta semana
        $citasDb = collect();
        if (Schema::hasTable('citas') && Schema::hasTable('mascotas') && Schema::hasTable('usuarios')) {
            $selectCols = [
                'citas.id_cita',
                'citas.fecha',
                'citas.hora',
                'citas.motivo',
                'citas.estado',
                'mascotas.nombre as mascota_nombre',
                'mascotas.especie as mascota_especie',
                'usuarios.nombre as dueno_nombre',
            ];
            if (Schema::hasColumn('citas', 'servicio')) {
                $selectCols[] = 'citas.servicio';
            }
            if (Schema::hasColumn('citas', 'precio')) {
                $selectCols[] = 'citas.precio';
            }
            if (Schema::hasColumn('citas', 'profesional')) {
                $selectCols[] = 'citas.profesional';
            }

            $citasDb = DB::table('citas')
                ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
                ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
                ->whereBetween('citas.fecha', [$inicioSemana->toDateString(), $finSemana->toDateString()])
                ->where('citas.estado', '!=', 'Cancelada')
                ->select($selectCols)
                ->orderBy('citas.fecha')
                ->orderBy('citas.hora')
                ->get();
        }

        // Agrupar citas por fecha (YYYY-MM-DD)
        $citasPorDia = [];
        foreach ($citasDb as $c) {
            $citasPorDia[$c->fecha][] = $c;
        }

        // Información de usuario logueado para autocompletar formulario si aplica
        $usuarioLogueado = null;
        $mascotasUsuario = collect();
        if (session()->has('user_id') && Schema::hasTable('usuarios')) {
            $usuarioLogueado = DB::table('usuarios')->where('id_usuario', session('user_id'))->first();
            if (Schema::hasTable('mascotas')) {
                $mascotasUsuario = MascotaService::getMascotasDeUsuario((int) session('user_id'));
            }
        }

        $profesionalesList = CitaService::getProfesionales();
        $mapaServiciosProfesionales = CitaService::getMapaServiciosProfesionales();

        // Días no laborables oficiales para el datepicker y validación del frontend (Punto 8)
        $diasNoLaborables = [];
        if (Schema::hasTable('dias_no_laborables')) {
            $diasNoLaborables = DB::table('dias_no_laborables')
                ->where('activo', true)
                ->get(['fecha', 'motivo'])
                ->toArray();
        }

        if (empty($diasNoLaborables)) {
            $festivos = [
                ['fecha' => '2026-01-01', 'motivo' => 'Año Nuevo'],
                ['fecha' => '2026-02-05', 'motivo' => 'Día de la Constitución'],
                ['fecha' => '2026-03-21', 'motivo' => 'Natalicio de Benito Juárez'],
                ['fecha' => '2026-05-01', 'motivo' => 'Día del Trabajo'],
                ['fecha' => '2026-09-16', 'motivo' => 'Día de la Independencia'],
                ['fecha' => '2026-11-20', 'motivo' => 'Revolución Mexicana'],
                ['fecha' => '2026-12-25', 'motivo' => 'Navidad'],
            ];
            $diasNoLaborables = array_map(fn ($f) => (object) $f, $festivos);
        }

        $diasCerradosSemana = [];
        if (Schema::hasTable('configuracion_horarios')) {
            $diasCerradosSemana = DB::table('configuracion_horarios')
                ->where('activo', false)
                ->pluck('dia_semana')
                ->toArray();
        }

        // ---------------------------------------------------------------------
        // CATÁLOGO DE PRODUCTOS & FARMACIA PARA LA LANDING PAGE
        // ---------------------------------------------------------------------
        $categoriasProductos = collect();
        $productosLanding = collect();
        if (Schema::hasTable('productos') && Schema::hasTable('categorias')) {
            $categoriasProductos = DB::table('categorias')
                ->select('categorias.*')
                ->selectRaw('(SELECT COUNT(*) FROM productos WHERE productos.id_categoria = categorias.id_categoria) as total_productos')
                ->orderBy('nombre', 'asc')
                ->get();

            $productosLanding = DB::table('productos')
                ->leftJoin('categorias', 'productos.id_categoria', '=', 'categorias.id_categoria')
                ->select('productos.*', 'categorias.nombre as categoria_nombre')
                ->orderBy('productos.id_producto', 'desc')
                ->get();
        }

        return view('landing', compact(
            'clinicaInfo',
            'categoriasServicios',
            'personalMedico',
            'profesionalesList',
            'mapaServiciosProfesionales',
            'diasSemana',
            'citasPorDia',
            'inicioSemana',
            'finSemana',
            'offsetSemana',
            'usuarioLogueado',
            'mascotasUsuario',
            'diasNoLaborables',
            'diasCerradosSemana',
            'categoriasProductos',
            'productosLanding'
        ));
    }

    /**
     * Endpoint API para consultar horarios disponibles según fecha, profesional y servicio (R-31).
     */
    public function consultarDisponibilidad(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'profesional' => 'nullable|string',
            'servicio' => 'nullable|string',
            'id_mascota' => 'nullable|integer',
        ]);

        $resultado = CitaService::obtenerHorariosDisponibles(
            $request->query('fecha'),
            $request->query('profesional'),
            $request->query('servicio'),
            $request->filled('id_mascota') ? (int) $request->query('id_mascota') : null
        );

        return response()->json($resultado);
    }

    /**
     * Store appointment booked through the Landing Page (RF-05, R-30, R-31, R-32).
     */
    public function agendarCita(Request $request)
    {
        // Puntos de Calidad: 1 (Nombre), 2 (Teléfono), 3 (Email), 4 (Mascota), 5 (Especie), 8 (Fecha), 10 (Motivo), 11 (Términos)
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'string', 'email:rfc,filter', 'max:100'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'mascota_nombre' => ['required', 'string', 'max:100'],
            'especie' => ['required', 'string', 'in:Perro,Gato,Ave,Conejo,Reptil,Otro'],
            'servicio' => ['required', 'string', 'max:150'],
            'profesional' => ['nullable', 'string', 'max:150'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required', 'string'],
            'terms' => ['accepted'],
            'motivo' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'Ingresa tu nombre completo.',
            'nombre.regex' => 'El nombre completo permite únicamente letras y espacios.',
            'email.required' => 'Ingresa tu correo electrónico.',
            'email.email' => 'El correo electrónico debe tener una estructura válida (usuario@dominio.com).',
            'telefono.required' => 'El teléfono de contacto es obligatorio.',
            'telefono.regex' => 'El teléfono debe contener estrictamente 10 dígitos numéricos.',
            'mascota_nombre.required' => 'El nombre de la mascota es un campo obligatorio.',
            'especie.required' => 'Selecciona la especie de tu mascota.',
            'especie.in' => 'Selecciona una especie válida de las opciones predeterminadas (Perro, Gato, Ave, Conejo, Reptil, Otro).',
            'servicio.required' => 'Selecciona el servicio requerido.',
            'fecha.required' => 'Selecciona la fecha de la cita.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al día de hoy.',
            'hora.required' => 'Selecciona el horario deseado.',
            'terms.accepted' => 'Debes aceptar los Términos, Condiciones y Protocolos de Acceso (RF-02) antes de proceder.',
        ]);

        // Punto 8: Validación de días no laborables y días de descanso de la clínica
        $festivosPorDefecto = [
            '2026-01-01' => 'Año Nuevo',
            '2026-02-05' => 'Día de la Constitución',
            '2026-03-21' => 'Natalicio de Benito Juárez',
            '2026-05-01' => 'Día del Trabajo',
            '2026-09-16' => 'Día de la Independencia',
            '2026-11-20' => 'Revolución Mexicana',
            '2026-12-25' => 'Navidad',
        ];

        if (isset($festivosPorDefecto[$request->fecha])) {
            return redirect()->back()
                ->withInput()
                ->with('horario_no_disponible_alerta', [
                    'mensaje' => 'Fecha No Laborable.',
                    'detalle' => "La clínica no labora el {$request->fecha} por motivo de: {$festivosPorDefecto[$request->fecha]}. Por favor selecciona una fecha laborable.",
                ]);
        }

        if (Schema::hasTable('dias_no_laborables')) {
            $diaNoLaborable = DB::table('dias_no_laborables')
                ->where('fecha', $request->fecha)
                ->where('activo', true)
                ->first();

            if ($diaNoLaborable) {
                return redirect()->back()
                    ->withInput()
                    ->with('horario_no_disponible_alerta', [
                        'mensaje' => 'Fecha No Laborable.',
                        'detalle' => "La clínica no labora el {$request->fecha} por motivo de: {$diaNoLaborable->motivo}. Por favor selecciona una fecha laborable.",
                    ]);
            }
        }

        if (Schema::hasTable('configuracion_horarios')) {
            $diaSemana = Carbon::parse($request->fecha)->dayOfWeekIso;
            $confHorario = DB::table('configuracion_horarios')->where('dia_semana', $diaSemana)->first();
            if ($confHorario && ! $confHorario->activo) {
                return redirect()->back()
                    ->withInput()
                    ->with('horario_no_disponible_alerta', [
                        'mensaje' => 'Fecha No Laborable.',
                        'detalle' => 'La clínica permanece cerrada en este día de la semana. Por favor selecciona otra fecha.',
                    ]);
            }
        }

        // 1. RESTRICCIÓN DE TIEMPO: La hora no debe haber pasado ni ser con menos de 30 minutos de anticipación
        try {
            CitaService::validarTiempoMinimo($request->fecha, $request->hora);
        } catch (ValidationException $e) {
            $msg = $e->validator->errors()->first('hora');

            return redirect()->back()
                ->withInput()
                ->with('horario_no_disponible_alerta', [
                    'mensaje' => 'El horario seleccionado ya no se encuentra disponible.',
                    'detalle' => $msg,
                ]);
        }

        // 2. VALIDACIÓN DE DISPONIBILIDAD DEL TRABAJADOR (R-32): Evitar citas simultáneas y bloqueos
        $profesional = $request->filled('profesional') ? trim($request->profesional) : null;
        if ($profesional && ! CitaService::esProfesionalAptoParaServicio($profesional, $request->servicio)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['profesional' => 'El profesional seleccionado no realiza el servicio solicitado. Por favor selecciona un especialista calificado.']);
        }

        $dispTrabajador = CitaService::verificarDisponibilidadTrabajador($profesional, $request->fecha, $request->hora);
        if (! $dispTrabajador['disponible']) {
            // R-32: Notificación ventana azul con icono blanco de alerta
            return redirect()->back()
                ->withInput()
                ->with('horario_no_disponible_alerta', [
                    'mensaje' => 'El horario ya no se encuentra disponible.',
                    'detalle' => $dispTrabajador['mensaje'] ?? 'El profesional ya tiene una cita asignada en ese horario.',
                ]);
        }

        $inputEmail = strtolower(trim($request->email));
        $inputNombre = trim($request->nombre);
        $inputTelefono = trim($request->telefono);

        // 3. Identificar o registrar al usuario
        $usuario = DB::table('usuarios')->where('email', $inputEmail)->first();

        if (! $usuario) {
            // Validar que el teléfono no pertenezca ya a otro usuario
            $usuarioConTelefono = DB::table('usuarios')->where('telefono', $inputTelefono)->first();
            if ($usuarioConTelefono) {
                return redirect()->back()
                    ->withInput()
                    ->with('alerta_error_general', 'El número de teléfono ingresado ya está registrado por otro cliente. Solo se permite un número de teléfono por cliente.');
            }

            $nuevoUserData = [
                'nombre' => $inputNombre,
                'email' => $inputEmail,
                'password' => Hash::make('cliente_'.time()),
                'rol' => 'cliente',
                'fecha_registro' => now(),
            ];

            if (Schema::hasColumn('usuarios', 'telefono')) {
                $nuevoUserData['telefono'] = $inputTelefono;
            }

            $userId = DB::table('usuarios')->insertGetId($nuevoUserData);
        } else {
            $userId = $usuario->id_usuario;

            // Si el teléfono ingresado ya pertenece a OTRO usuario, bloquear
            $otroUsuarioConTelefono = DB::table('usuarios')
                ->where('telefono', $inputTelefono)
                ->where('id_usuario', '!=', $userId)
                ->first();

            if ($otroUsuarioConTelefono) {
                return redirect()->back()
                    ->withInput()
                    ->with('alerta_error_general', 'El número de teléfono ingresado ya pertenece a otro cliente registrado. Solo se permite un número de teléfono por cliente.');
            }

            if (Schema::hasColumn('usuarios', 'telefono') && empty($usuario->telefono)) {
                DB::table('usuarios')->where('id_usuario', $userId)->update([
                    'telefono' => $inputTelefono,
                ]);
            }
        }

        // 4. Identificar o registrar la mascota del usuario
        $mascotaNombre = trim($request->mascota_nombre);
        $especie = trim($request->especie);

        $mascota = MascotaService::buscarMascotaDeUsuarioPorNombre($userId, $mascotaNombre, $especie);

        if (! $mascota) {
            $mascotaId = MascotaService::crearMascotaConDuenos([
                'nombre' => $mascotaNombre,
                'especie' => $especie,
                'raza' => $request->raza ? trim($request->raza) : null,
                'peso' => null,
            ], $userId);
        } else {
            $mascotaId = $mascota->id_mascota;
        }

        // 5. RESTRICCIÓN DE DUPLICADOS: Impedir cita duplicada por mismo motivo, hora y mascota
        $motivoCompleto = trim($request->servicio);
        if ($request->filled('motivo')) {
            $motivoCompleto .= ' - '.trim($request->motivo);
        }

        try {
            CitaService::validarDuplicado($mascotaId, $request->fecha, $request->hora, $motivoCompleto, $request->servicio);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('alerta_error_general', $e->validator->errors()->first('duplicado'));
        }

        // 6. Crear la Cita Médica
        $horaFormateada = strlen($request->hora) === 5 ? $request->hora.':00' : $request->hora;
        $precio = CitaService::getPrecioServicio($request->servicio);

        $citaData = [
            'id_mascota' => $mascotaId,
            'fecha' => $request->fecha,
            'hora' => $horaFormateada,
            'motivo' => $motivoCompleto,
            'estado' => 'Pendiente',
            'servicio' => trim($request->servicio),
            'profesional' => $profesional,
            'canal' => 'web',
            'notas' => $request->motivo ? trim($request->motivo) : null,
            'fecha_creacion' => now(),
        ];

        if (Schema::hasColumn('citas', 'precio')) {
            $citaData['precio'] = $precio;
        }

        if (Schema::hasColumn('citas', 'telefono_contacto')) {
            $citaData['telefono_contacto'] = $inputTelefono;
        }

        DB::table('citas')->insert($citaData);

        return redirect()->route('home', ['#calendario'])->with('cita_agendada_ok', [
            'paciente' => $mascotaNombre,
            'dueno' => $inputNombre,
            'telefono' => $inputTelefono,
            'servicio' => $request->servicio,
            'precio' => $precio,
            'motivo' => $motivoCompleto,
            'profesional' => $profesional ?? 'Profesional asignado por clínica',
            'fecha' => Carbon::parse($request->fecha)->format('d/m/Y'),
            'hora' => substr($request->hora, 0, 5),
        ]);
    }

    /**
     * API to fetch all active services with their pricing and descriptions.
     */
    public function serviciosApi()
    {
        return response()->json(CitaService::getServicios());
    }

    /**
     * API to fetch professionals filtered by service or all.
     */
    public function profesionalesApi(Request $request)
    {
        $servicio = $request->query('servicio');
        $profesionales = CitaService::getProfesionalesPorServicio($servicio);

        return response()->json($profesionales);
    }

    /**
     * API to fetch appointments for a specific week offset (AJAX helper).
     */
    public function citasSemana(Request $request)
    {
        $offset = (int) $request->query('offset', 0);
        $inicioSemana = Carbon::now()->startOfWeek()->addWeeks($offset);
        $finSemana = (clone $inicioSemana)->endOfWeek();

        $citas = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->whereBetween('citas.fecha', [$inicioSemana->toDateString(), $finSemana->toDateString()])
            ->where('citas.estado', '!=', 'Cancelada')
            ->select(
                'citas.id_cita',
                'citas.fecha',
                'citas.hora',
                'citas.motivo',
                'citas.servicio',
                'citas.precio',
                'citas.profesional',
                'citas.estado',
                'mascotas.nombre as mascota_nombre',
                'mascotas.especie'
            )
            ->get();

        return response()->json([
            'inicio_iso' => $inicioSemana->toDateString(),
            'fin_iso' => $finSemana->toDateString(),
            'semana_label' => $inicioSemana->format('d/m').' al '.$finSemana->format('d/m/Y'),
            'citas' => $citas,
        ]);
    }
}
