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
        // 1. Crear tabla de servicios
        if (! Schema::hasTable('servicios')) {
            Schema::create('servicios', function (Blueprint $table) {
                $table->id('id_servicio');
                $table->string('categoria', 100);
                $table->string('nombre', 150)->unique();
                $table->text('descripcion')->nullable();
                $table->decimal('precio', 10, 2)->default(0);
                $table->string('precio_texto', 100)->nullable();
                $table->string('duracion', 50)->nullable();
                $table->text('incluye')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }

        // 2. Agregar columna precio a citas si no existe
        if (Schema::hasTable('citas') && ! Schema::hasColumn('citas', 'precio')) {
            Schema::table('citas', function (Blueprint $table) {
                $table->decimal('precio', 10, 2)->nullable()->after('servicio');
            });
        }

        // 3. Poblar catálogo inicial de servicios con sus precios oficiales
        $serviciosIniciales = [
            // Consultas y Diagnóstico
            [
                'categoria' => 'Consultas y Diagnóstico',
                'nombre' => 'Consulta Médica General y Pediátrica',
                'descripcion' => 'Evaluación clínica completa para cachorros y adultos.',
                'precio' => 350.00,
                'precio_texto' => '$350 MXN',
                'duracion' => '30 - 45 min',
                'incluye' => 'Toma de signos vitales, pesaje, diagnóstico clínico, receta médica y recomendaciones nutricionales.',
            ],
            [
                'categoria' => 'Consultas y Diagnóstico',
                'nombre' => 'Laboratorio Clínico y Análisis Sanguíneo',
                'descripcion' => 'Hemogramas, química sanguínea y urianálisis.',
                'precio' => 450.00,
                'precio_texto' => '$450 - $950 MXN',
                'duracion' => '20 min (Resultados en 2 hrs)',
                'incluye' => 'Toma de muestra estéril, procesamiento laboratorial y entrega digital de resultados.',
            ],
            [
                'categoria' => 'Consultas y Diagnóstico',
                'nombre' => 'Imagenología (Rayos X y Ultrasonido Digital)',
                'descripcion' => 'Diagnóstico no invasivo de alta definición.',
                'precio' => 600.00,
                'precio_texto' => '$600 - $1,100 MXN',
                'duracion' => '40 min',
                'incluye' => 'Placas radiográficas o rastreo ecográfico con informe radiológico emitido por especialista.',
            ],
            // Cirugía y Hospitalización
            [
                'categoria' => 'Cirugía y Hospitalización',
                'nombre' => 'Esterilización y Castración Segura',
                'descripcion' => 'Control reproductivo y prevención de patologías.',
                'precio' => 1200.00,
                'precio_texto' => '$1,200 - $2,500 MXN',
                'duracion' => '1 - 2 hrs (Recuperación ambulatoria)',
                'incluye' => 'Monitoreo multiparamétrico, medicación postoperatoria inicial y retiro de puntos.',
            ],
            [
                'categoria' => 'Cirugía y Hospitalización',
                'nombre' => 'Cirugía de Tejidos Blandos y Traumatología',
                'descripcion' => 'Resolución de fracturas, hernias y remoción de masas.',
                'precio' => 1500.00,
                'precio_texto' => 'Desde $1,500 MXN (Valoración médica previa)',
                'duracion' => '2 - 4 hrs',
                'incluye' => 'Quirófano estéril completo, terapia de fluidos, cuidados intensivos postquirúrgicos.',
            ],
            [
                'categoria' => 'Cirugía y Hospitalización',
                'nombre' => 'Hospitalización y Cuidados Intensivos (UCI)',
                'descripcion' => 'Atención médica y terapia de fluidos 24 horas.',
                'precio' => 800.00,
                'precio_texto' => '$800 MXN / noche',
                'duracion' => 'Por día / estancia médica',
                'incluye' => 'Jaulas climatizadas, monitoreo médico 24 horas, administración de medicamentos.',
            ],
            // Medicina Preventiva
            [
                'categoria' => 'Medicina Preventiva',
                'nombre' => 'Esquema de Vacunación Canina y Felina',
                'descripcion' => 'Vacunas quíntuple, séxtuple, rabia, triple felina y leucemia.',
                'precio' => 280.00,
                'precio_texto' => '$280 - $450 MXN',
                'duracion' => '20 min',
                'incluye' => 'Revisión física previa de salud, aplicación del biológico, sellado de cartilla oficial.',
            ],
            [
                'categoria' => 'Medicina Preventiva',
                'nombre' => 'Desparasitación Interna y Externa',
                'descripcion' => 'Erradicación de parásitos gastrointestinales, pulgas y garrapatas.',
                'precio' => 150.00,
                'precio_texto' => '$150 - $350 MXN',
                'duracion' => '15 min',
                'incluye' => 'Pesaje de precisión, dosificación adecuada y calendario recordatorio.',
            ],
            [
                'categoria' => 'Medicina Preventiva',
                'nombre' => 'Implantación de Microchip y Certificados',
                'descripcion' => 'Identificación permanente y certificados para viajes.',
                'precio' => 650.00,
                'precio_texto' => '$650 MXN',
                'duracion' => '20 min',
                'incluye' => 'Microchip ISO, registro en base de datos nacional, lector de verificación.',
            ],
            // Estética Mascotas
            [
                'categoria' => 'Estética Mascotas',
                'nombre' => 'Baño Médico / Antipulgas y Spa Canino',
                'descripcion' => 'Higiene profunda con dermocosmética y secado tibio.',
                'precio' => 250.00,
                'precio_texto' => '$250 - $550 MXN',
                'duracion' => '1 - 1.5 hrs',
                'incluye' => 'Corte de uñas, limpieza de oídos, vaciado de glándulas anales y cepillado profundo.',
            ],
            [
                'categoria' => 'Estética Mascotas',
                'nombre' => 'Corte de Raza y Estilismo Profesional',
                'descripcion' => 'Corte higiénico o de raza a máquina y tijera.',
                'precio' => 350.00,
                'precio_texto' => '$350 - $700 MXN',
                'duracion' => '1.5 - 2 hrs',
                'incluye' => 'Baño completo previo, corte de pelaje, pulido de uñas, limpieza de cojinetes.',
            ],
            [
                'categoria' => 'Estética Mascotas',
                'nombre' => 'Profilaxis y Limpieza Dental Ultrasónica',
                'descripcion' => 'Eliminación de sarro, placa bacteriana y mal aliento.',
                'precio' => 900.00,
                'precio_texto' => '$900 - $1,800 MXN',
                'duracion' => '1 hr',
                'incluye' => 'Revisión odontológica completa, limpieza ultrasónica y pulido dental.',
            ],
        ];

        foreach ($serviciosIniciales as $s) {
            DB::table('servicios')->updateOrInsert(
                ['nombre' => $s['nombre']],
                array_merge($s, [
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // Actualizar citas existentes con el precio correspondiente a su servicio si no lo tienen
        if (Schema::hasTable('citas') && Schema::hasColumn('citas', 'servicio') && Schema::hasColumn('citas', 'precio')) {
            $serviciosMap = DB::table('servicios')->pluck('precio', 'nombre');
            foreach ($serviciosMap as $nombreSrv => $precioSrv) {
                DB::table('citas')
                    ->where('servicio', $nombreSrv)
                    ->whereNull('precio')
                    ->update(['precio' => $precioSrv]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('citas') && Schema::hasColumn('citas', 'precio')) {
            Schema::table('citas', function (Blueprint $table) {
                $table->dropColumn('precio');
            });
        }

        Schema::dropIfExists('servicios');
    }
};
