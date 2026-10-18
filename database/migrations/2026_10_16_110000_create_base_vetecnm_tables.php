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
        // 1. Tabla de Usuarios (Maneja clientes, admins y recepcionistas)
        if (! Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->increments('id_usuario');
                $table->string('nombre', 100);
                $table->string('email', 100)->unique();
                $table->string('telefono', 20)->nullable();
                $table->string('password', 255);
                $table->string('rol', 30)->default('cliente');
                $table->timestamp('fecha_registro')->useCurrent();
            });

            // Insertar usuarios base
            DB::table('usuarios')->insert([
                [
                    'nombre' => 'Administrador General',
                    'email' => 'admin@vetecnm.com',
                    'telefono' => '3411234567',
                    'password' => Hash::make('admin123'),
                    'rol' => 'admin',
                    'fecha_registro' => now(),
                ],
                [
                    'nombre' => 'Carlos Mendoza',
                    'email' => 'carlos.m@correo.com',
                    'telefono' => '3419876543',
                    'password' => Hash::make('cliente123'),
                    'rol' => 'cliente',
                    'fecha_registro' => now(),
                ],
            ]);
        }

        // 2. Tabla de Mascotas
        if (! Schema::hasTable('mascotas')) {
            Schema::create('mascotas', function (Blueprint $table) {
                $table->increments('id_mascota');
                $table->unsignedInteger('id_usuario');
                $table->string('nombre', 100);
                $table->string('especie', 50);
                $table->string('raza', 50)->nullable();
                $table->decimal('peso', 5, 2)->nullable();

                $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            });

            $carlos = DB::table('usuarios')->where('email', 'carlos.m@correo.com')->first();
            if ($carlos) {
                DB::table('mascotas')->insert([
                    ['id_usuario' => $carlos->id_usuario, 'nombre' => 'Max', 'especie' => 'Perro', 'raza' => 'Golden Retriever', 'peso' => 25.50],
                    ['id_usuario' => $carlos->id_usuario, 'nombre' => 'Luna', 'especie' => 'Gato', 'raza' => 'Siamés', 'peso' => 4.20],
                ]);
            }
        }

        // 3. Tabla de Categorías
        if (! Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->increments('id_categoria');
                $table->string('nombre', 100);
                $table->text('descripcion')->nullable();
            });

            DB::table('categorias')->insert([
                ['nombre' => 'Alimentos', 'descripcion' => 'Croquetas, alimento húmedo y premios'],
                ['nombre' => 'Accesorios', 'descripcion' => 'Correas, collares, camas y juguetes'],
                ['nombre' => 'Higiene', 'descripcion' => 'Champús, cepillos y productos de limpieza'],
            ]);
        }

        // 4. Tabla de Productos
        if (! Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->increments('id_producto');
                $table->unsignedInteger('id_categoria')->nullable();
                $table->string('nombre', 150);
                $table->text('descripcion')->nullable();
                $table->decimal('precio', 10, 2);
                $table->integer('stock')->default(0);
                $table->string('imagen_url', 255)->nullable();

                $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('set null');
            });

            DB::table('productos')->insert([
                ['id_categoria' => 1, 'nombre' => 'Croquetas Dog Chow 10kg', 'descripcion' => 'Alimento completo para perro adulto', 'precio' => 550.00, 'stock' => 15, 'imagen_url' => null],
                ['id_categoria' => 1, 'nombre' => 'Whiskas Pescado 1.5kg', 'descripcion' => 'Alimento seco para gato adulto', 'precio' => 120.00, 'stock' => 20, 'imagen_url' => null],
                ['id_categoria' => 2, 'nombre' => 'Correa reforzada 2m', 'descripcion' => 'Correa de nylon de alta resistencia', 'precio' => 150.00, 'stock' => 10, 'imagen_url' => null],
                ['id_categoria' => 3, 'nombre' => 'Champú antipulgas', 'descripcion' => 'Champú para perros y gatos 500ml', 'precio' => 90.00, 'stock' => 25, 'imagen_url' => null],
            ]);
        }

        // 5. Tabla de Citas
        if (! Schema::hasTable('citas')) {
            Schema::create('citas', function (Blueprint $table) {
                $table->increments('id_cita');
                $table->unsignedInteger('id_mascota');
                $table->date('fecha');
                $table->time('hora');
                $table->string('telefono_contacto', 20)->nullable();
                $table->string('servicio', 150)->nullable();
                $table->string('profesional', 150)->nullable();
                $table->string('motivo', 255);
                $table->decimal('precio', 10, 2)->nullable()->default(350.00);
                $table->string('estado', 20)->default('Pendiente');
                $table->string('canal', 30)->default('web');
                $table->text('notas')->nullable();
                $table->timestamp('fecha_creacion')->useCurrent();

                $table->foreign('id_mascota')->references('id_mascota')->on('mascotas')->onDelete('cascade');
            });

            $mascota1 = DB::table('mascotas')->first();
            if ($mascota1) {
                DB::table('citas')->insert([
                    [
                        'id_mascota' => $mascota1->id_mascota,
                        'fecha' => date('Y-m-d', strtotime('+1 day')),
                        'hora' => '10:00:00',
                        'servicio' => 'Vacunación y Desparasitación',
                        'profesional' => 'Dra. María González',
                        'motivo' => 'Vacunación y Desparasitación - Vacunación anual',
                        'precio' => 250.00,
                        'estado' => 'Confirmada',
                        'canal' => 'web',
                        'notas' => 'Vacunación anual',
                        'fecha_creacion' => now(),
                    ],
                ]);
            }
        } else {
            Schema::table('citas', function (Blueprint $table) {
                if (! Schema::hasColumn('citas', 'telefono_contacto')) {
                    $table->string('telefono_contacto', 20)->nullable()->after('hora');
                }
                if (! Schema::hasColumn('citas', 'servicio')) {
                    $table->string('servicio', 150)->nullable()->after('telefono_contacto');
                }
                if (! Schema::hasColumn('citas', 'profesional')) {
                    $table->string('profesional', 150)->nullable()->after('servicio');
                }
                if (! Schema::hasColumn('citas', 'precio')) {
                    $table->decimal('precio', 10, 2)->nullable()->default(350.00)->after('motivo');
                }
                if (! Schema::hasColumn('citas', 'canal')) {
                    $table->string('canal', 30)->default('web')->after('estado');
                }
                if (! Schema::hasColumn('citas', 'notas')) {
                    $table->text('notas')->nullable()->after('canal');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('mascotas');
        Schema::dropIfExists('usuarios');
    }
};
