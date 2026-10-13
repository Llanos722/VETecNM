<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Agregar columnas a 'citas' si no existen
        if (Schema::hasTable('citas')) {
            Schema::table('citas', function (Blueprint $table) {
                if (! Schema::hasColumn('citas', 'servicio')) {
                    $table->string('servicio', 150)->nullable()->after('telefono_contacto');
                }
                if (! Schema::hasColumn('citas', 'profesional')) {
                    $table->string('profesional', 150)->nullable()->after('servicio');
                }
                if (! Schema::hasColumn('citas', 'canal')) {
                    $table->string('canal', 30)->default('web')->after('estado'); // web, presencial, telefono
                }
                if (! Schema::hasColumn('citas', 'notas')) {
                    $table->text('notas')->nullable()->after('canal');
                }
            });
        }

        // 2. Modificar rol en usuarios para permitir 'recepcionista'
        if (Schema::hasTable('usuarios')) {
            try {
                DB::statement('ALTER TABLE usuarios DROP CHECK usuarios_chk_1');
            } catch (Throwable $e) {
                // El constraint ya fue eliminado o no existe
            }

            try {
                DB::statement("ALTER TABLE usuarios MODIFY COLUMN rol VARCHAR(30) DEFAULT 'cliente'");
                DB::statement("ALTER TABLE usuarios ADD CONSTRAINT usuarios_chk_1 CHECK (rol IN ('cliente', 'admin', 'recepcionista'))");
            } catch (Throwable $e) {
                // Continuar si la sintaxis no aplica
            }
        }

        // 3. Crear tabla de configuracion_horarios (R-34)
        if (! Schema::hasTable('configuracion_horarios')) {
            Schema::create('configuracion_horarios', function (Blueprint $table) {
                $table->id();
                $table->unsignedTinyInteger('dia_semana'); // 1 = Lunes ... 7 = Domingo
                $table->string('dia_nombre', 20);
                $table->time('hora_apertura')->default('08:00:00');
                $table->time('hora_cierre')->default('20:00:00');
                $table->unsignedSmallInteger('intervalo_minutos')->default(30);
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });

            // Insertar horarios por defecto de la clínica
            $dias = [
                ['dia_semana' => 1, 'dia_nombre' => 'Lunes', 'hora_apertura' => '08:00:00', 'hora_cierre' => '20:00:00', 'activo' => true],
                ['dia_semana' => 2, 'dia_nombre' => 'Martes', 'hora_apertura' => '08:00:00', 'hora_cierre' => '20:00:00', 'activo' => true],
                ['dia_semana' => 3, 'dia_nombre' => 'Miércoles', 'hora_apertura' => '08:00:00', 'hora_cierre' => '20:00:00', 'activo' => true],
                ['dia_semana' => 4, 'dia_nombre' => 'Jueves', 'hora_apertura' => '08:00:00', 'hora_cierre' => '20:00:00', 'activo' => true],
                ['dia_semana' => 5, 'dia_nombre' => 'Viernes', 'hora_apertura' => '08:00:00', 'hora_cierre' => '20:00:00', 'activo' => true],
                ['dia_semana' => 6, 'dia_nombre' => 'Sábado', 'hora_apertura' => '09:00:00', 'hora_cierre' => '17:00:00', 'activo' => true],
                ['dia_semana' => 7, 'dia_nombre' => 'Domingo', 'hora_apertura' => '09:00:00', 'hora_cierre' => '14:00:00', 'activo' => true],
            ];
            foreach ($dias as $d) {
                DB::table('configuracion_horarios')->insert(array_merge($d, [
                    'intervalo_minutos' => 30,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        // 4. Crear tabla de horarios_recesos (R-34)
        if (! Schema::hasTable('horarios_recesos')) {
            Schema::create('horarios_recesos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 100);
                $table->time('hora_inicio')->default('14:00:00');
                $table->time('hora_fin')->default('15:00:00');
                $table->string('aplica_a', 150)->default('todos'); // 'todos' o nombre del profesional
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });

            // Insertar receso predeterminado para comida
            DB::table('horarios_recesos')->insert([
                'nombre' => 'Receso General de Almuerzo / Comida',
                'hora_inicio' => '14:00:00',
                'hora_fin' => '15:00:00',
                'aplica_a' => 'todos',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Crear tabla de dias_no_laborables (R-34)
        if (! Schema::hasTable('dias_no_laborables')) {
            Schema::create('dias_no_laborables', function (Blueprint $table) {
                $table->id();
                $table->date('fecha');
                $table->string('motivo', 255);
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });

            // Insertar algunos días festivos de ejemplo para 2026
            $festivos = [
                ['fecha' => '2026-01-01', 'motivo' => 'Año Nuevo'],
                ['fecha' => '2026-02-05', 'motivo' => 'Día de la Constitución'],
                ['fecha' => '2026-03-21', 'motivo' => 'Natalicio de Benito Juárez'],
                ['fecha' => '2026-05-01', 'motivo' => 'Día del Trabajo'],
                ['fecha' => '2026-09-16', 'motivo' => 'Día de la Independencia'],
                ['fecha' => '2026-11-20', 'motivo' => 'Revolución Mexicana'],
                ['fecha' => '2026-12-25', 'motivo' => 'Navidad'],
            ];
            foreach ($festivos as $f) {
                DB::table('dias_no_laborables')->insert(array_merge($f, [
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        // 6. Crear tabla de bloqueos_personal (R-34)
        if (! Schema::hasTable('bloqueos_personal')) {
            Schema::create('bloqueos_personal', function (Blueprint $table) {
                $table->id();
                $table->string('profesional', 150);
                $table->date('fecha');
                $table->time('hora_inicio')->nullable(); // Si es null, bloquea todo el día
                $table->time('hora_fin')->nullable();
                $table->string('motivo', 255);
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }

        // 7. Crear usuario recepcionista por defecto si no existe (R-33)
        if (Schema::hasTable('usuarios')) {
            $recepcionistaExiste = DB::table('usuarios')
                ->where('email', 'recepcion@vetecnm.com')
                ->exists();

            if (! $recepcionistaExiste) {
                DB::table('usuarios')->insert([
                    'nombre' => 'Recepcionista VETecNM',
                    'email' => 'recepcion@vetecnm.com',
                    'telefono' => '3414120000',
                    'password' => Hash::make('recepcion123'),
                    'rol' => 'recepcionista',
                    'fecha_registro' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('citas')) {
            Schema::table('citas', function (Blueprint $table) {
                if (Schema::hasColumn('citas', 'servicio')) {
                    $table->dropColumn('servicio');
                }
                if (Schema::hasColumn('citas', 'profesional')) {
                    $table->dropColumn('profesional');
                }
                if (Schema::hasColumn('citas', 'canal')) {
                    $table->dropColumn('canal');
                }
                if (Schema::hasColumn('citas', 'notas')) {
                    $table->dropColumn('notas');
                }
            });
        }

        Schema::dropIfExists('bloqueos_personal');
        Schema::dropIfExists('dias_no_laborables');
        Schema::dropIfExists('horarios_recesos');
        Schema::dropIfExists('configuracion_horarios');
    }
};
