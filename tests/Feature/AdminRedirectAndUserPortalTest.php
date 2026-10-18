<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminRedirectAndUserPortalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::statement('
            CREATE TABLE IF NOT EXISTS usuarios (
                id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                telefono VARCHAR(20),
                password VARCHAR(255) NOT NULL,
                rol VARCHAR(30) DEFAULT "cliente",
                fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS mascotas (
                id_mascota INTEGER PRIMARY KEY AUTOINCREMENT,
                id_usuario INTEGER NOT NULL,
                nombre VARCHAR(100) NOT NULL,
                especie VARCHAR(50) NOT NULL,
                raza VARCHAR(50),
                peso DECIMAL(5,2)
            )
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS citas (
                id_cita INTEGER PRIMARY KEY AUTOINCREMENT,
                id_mascota INTEGER NOT NULL,
                fecha DATE NOT NULL,
                hora TIME NOT NULL,
                telefono_contacto VARCHAR(20),
                servicio VARCHAR(150),
                precio DECIMAL(10,2),
                profesional VARCHAR(150),
                motivo VARCHAR(255) NOT NULL,
                estado VARCHAR(20) DEFAULT "Pendiente",
                canal VARCHAR(30) DEFAULT "web",
                notas TEXT,
                fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ');
    }

    public function test_admin_login_redirects_directly_to_admin_dashboard(): void
    {
        $adminId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Administrador General',
            'email' => 'admin_test@vetecnm.com',
            'password' => bcrypt('password123'),
            'rol' => 'admin',
        ]);

        $response = $this->post('/login', [
            'login-user' => 'admin_test@vetecnm.com',
            'login-password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_visiting_client_dashboard_is_redirected_to_admin_dashboard(): void
    {
        $response = $this->withSession([
            'user_id' => 1,
            'user_nombre' => 'Administrador General',
            'user_email' => 'admin_test@vetecnm.com',
            'user_rol' => 'admin',
        ])->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_client_login_redirects_to_client_dashboard(): void
    {
        $clientId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Cliente Test',
            'email' => 'cliente_test@correo.com',
            'password' => bcrypt('password123'),
            'rol' => 'cliente',
        ]);

        $response = $this->post('/login', [
            'login-user' => 'cliente_test@correo.com',
            'login-password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_client_can_view_comprobante_of_their_appointment(): void
    {
        $clientId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Ana López',
            'email' => 'ana@correo.com',
            'password' => bcrypt('password123'),
            'rol' => 'cliente',
        ]);

        $mascotaId = DB::table('mascotas')->insertGetId([
            'id_usuario' => $clientId,
            'nombre' => 'Kira',
            'especie' => 'Perro',
            'raza' => 'Pastor Alemán',
            'peso' => 28.00,
        ]);

        $citaId = DB::table('citas')->insertGetId([
            'id_mascota' => $mascotaId,
            'fecha' => '2026-10-25',
            'hora' => '10:00:00',
            'servicio' => 'Consulta Médica General',
            'motivo' => 'Vacunación',
            'estado' => 'Confirmada',
        ]);

        $response = $this->withSession([
            'user_id' => $clientId,
            'user_nombre' => 'Ana López',
            'user_email' => 'ana@correo.com',
            'user_rol' => 'cliente',
        ])->get("/citas/{$citaId}/comprobante");

        $response->assertOk();
        $response->assertSee('Comprobante Oficial de Cita Médica');
        $response->assertSee('Kira');
        $response->assertSee('Ana López');
    }
}
