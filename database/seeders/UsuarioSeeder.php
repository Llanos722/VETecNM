<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed usuarios (Tabla del proyecto VETecNM)
        DB::table('usuarios')->updateOrInsert(
            ['email' => 'admin@vetecnm.com'],
            [
                'nombre' => 'Administrador Vet',
                'password' => Hash::make('admin123'),
                'rol' => 'admin',
                'fecha_registro' => now(),
            ]
        );

        DB::table('usuarios')->updateOrInsert(
            ['email' => 'edgm02061@gmail.com'],
            [
                'nombre' => 'Admin EDGM',
                'password' => Hash::make('123456789'),
                'rol' => 'admin',
                'fecha_registro' => now(),
            ]
        );

        DB::table('usuarios')->updateOrInsert(
            ['email' => 'carlos.m@correo.com'],
            [
                'nombre' => 'Carlos Mendoza',
                'password' => Hash::make('cliente123'),
                'rol' => 'cliente',
                'fecha_registro' => now(),
            ]
        );

        // 2. Seed users (Tabla estándar de Laravel)
        User::updateOrCreate(
            ['email' => 'admin@vetecnm.com'],
            [
                'name' => 'Administrador Vet',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'edgm02061@gmail.com'],
            [
                'name' => 'Admin EDGM',
                'password' => Hash::make('123456789'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'carlos.m@correo.com'],
            [
                'name' => 'Carlos Mendoza',
                'password' => Hash::make('cliente123'),
            ]
        );

        // 3. Seed Mascotas
        $adminUser = DB::table('usuarios')->where('email', 'admin@vetecnm.com')->first();
        $clienteUser = DB::table('usuarios')->where('email', 'carlos.m@correo.com')->first();

        if ($clienteUser) {
            DB::table('mascotas')->updateOrInsert(
                ['id_usuario' => $clienteUser->id_usuario, 'nombre' => 'Max'],
                ['especie' => 'Perro', 'raza' => 'Golden Retriever', 'peso' => 25.50]
            );

            DB::table('mascotas')->updateOrInsert(
                ['id_usuario' => $clienteUser->id_usuario, 'nombre' => 'Luna'],
                ['especie' => 'Gato', 'raza' => 'Siamés', 'peso' => 4.20]
            );
        }

        // 4. Seed Categorías
        $cat1 = DB::table('categorias')->updateOrInsert(
            ['nombre' => 'Alimentos'],
            ['descripcion' => 'Croquetas, alimento húmedo y premios']
        );

        $cat2 = DB::table('categorias')->updateOrInsert(
            ['nombre' => 'Accesorios'],
            ['descripcion' => 'Correas, collares, camas y juguetes']
        );

        $cat3 = DB::table('categorias')->updateOrInsert(
            ['nombre' => 'Higiene'],
            ['descripcion' => 'Champús, cepillos y productos de limpieza']
        );

        // 5. Seed Productos
        $idAlimentos = DB::table('categorias')->where('nombre', 'Alimentos')->value('id_categoria');
        $idAccesorios = DB::table('categorias')->where('nombre', 'Accesorios')->value('id_categoria');
        $idHigiene = DB::table('categorias')->where('nombre', 'Higiene')->value('id_categoria');

        if ($idAlimentos) {
            DB::table('productos')->updateOrInsert(
                ['nombre' => 'Croquetas Dog Chow 10kg'],
                ['id_categoria' => $idAlimentos, 'descripcion' => 'Alimento completo para perro adulto', 'precio' => 550.00, 'stock' => 15]
            );

            DB::table('productos')->updateOrInsert(
                ['nombre' => 'Whiskas Pescado 1.5kg'],
                ['id_categoria' => $idAlimentos, 'descripcion' => 'Alimento seco para gato adulto', 'precio' => 120.00, 'stock' => 20]
            );
        }

        if ($idAccesorios) {
            DB::table('productos')->updateOrInsert(
                ['nombre' => 'Correa reforzada 2m'],
                ['id_categoria' => $idAccesorios, 'descripcion' => 'Correa de nylon de alta resistencia', 'precio' => 150.00, 'stock' => 10]
            );
        }

        if ($idHigiene) {
            DB::table('productos')->updateOrInsert(
                ['nombre' => 'Champú antipulgas'],
                ['id_categoria' => $idHigiene, 'descripcion' => 'Champú para perros y gatos 500ml', 'precio' => 90.00, 'stock' => 25]
            );
        }

        // 6. Seed Citas
        $mascotaMax = DB::table('mascotas')->where('nombre', 'Max')->first();
        $mascotaLuna = DB::table('mascotas')->where('nombre', 'Luna')->first();

        if ($mascotaMax) {
            DB::table('citas')->updateOrInsert(
                ['id_mascota' => $mascotaMax->id_mascota, 'fecha' => '2026-10-15'],
                ['hora' => '10:00:00', 'motivo' => 'Vacunación anual y desparasitación', 'estado' => 'Confirmada']
            );
        }

        if ($mascotaLuna) {
            DB::table('citas')->updateOrInsert(
                ['id_mascota' => $mascotaLuna->id_mascota, 'fecha' => '2026-10-18'],
                ['hora' => '16:30:00', 'motivo' => 'Revisión general por malestar estomacal', 'estado' => 'Pendiente']
            );
        }
    }
}
