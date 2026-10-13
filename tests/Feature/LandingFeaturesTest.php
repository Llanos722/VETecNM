<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LandingFeaturesTest extends TestCase
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
                rol VARCHAR(20) DEFAULT "cliente",
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
                motivo VARCHAR(255) NOT NULL,
                estado VARCHAR(20) DEFAULT "Pendiente",
                fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ');
    }

    public function test_landing_page_renders_with_rf02_rf03_rf04_rf05(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // RF-02 Verificaciones
        $response->assertSee('Clínica VETecNM');
        $response->assertSee('Horarios de Atención');
        $response->assertSee('Días No Laborables');
        $response->assertSee('Modificaciones de Horario');
        $response->assertSee('Protocolos y Condiciones de Acceso al Establecimiento');
        $response->assertSee('Uso Obligatorio de Correa y Collar');
        $response->assertSee('Transportadora Rígida');

        // RF-03 Verificaciones
        $response->assertSee('Consultas y Diagnóstico');
        $response->assertSee('Cirugía y Hospitalización');
        $response->assertSee('Medicina Preventiva');
        $response->assertSee('Estética Mascotas');
        $response->assertSee('Consultar');

        // RF-04 Verificaciones
        $response->assertSee('Dra. Sofía Valenzuela Méndez');
        $response->assertSee('Dr. Alejandro Gómez Morales');
        $response->assertSee('Dra. Mariana Rivas Torres');
        $response->assertSee('Téc. Roberto Silva Hernández');
        $response->assertSee('Servicios que ofrece');

        // RF-05 Verificaciones
        $response->assertSee('Calendario Semanal');
        $response->assertSee('Agendar Cita');
    }

    public function test_user_can_schedule_appointment_with_phone_and_terms(): void
    {
        $email = 'dueno_'.time().'@example.com';
        $fecha = Carbon::tomorrow()->toDateString();

        $response = $this->post('/citas/agendar', [
            'nombre' => 'María Fernández',
            'email' => $email,
            'telefono' => '3415559876',
            'mascota_nombre' => 'Toby',
            'especie' => 'Perro',
            'servicio' => 'Consulta Médica General y Pediátrica',
            'fecha' => $fecha,
            'hora' => '10:00',
            'terms' => '1',
            'motivo' => 'Revisión por vacuna anual',
        ]);

        $response->assertRedirect(route('home', ['#calendario']));
        $response->assertSessionHas('cita_agendada_ok');

        // Verificar inserción de usuario con teléfono
        $this->assertDatabaseHas('usuarios', [
            'email' => $email,
            'nombre' => 'María Fernández',
            'telefono' => '3415559876',
        ]);

        // Verificar inserción de mascota
        $this->assertDatabaseHas('mascotas', [
            'nombre' => 'Toby',
            'especie' => 'Perro',
        ]);

        // Verificar cita médica
        $this->assertDatabaseHas('citas', [
            'fecha' => $fecha,
            'telefono_contacto' => '3415559876',
            'estado' => 'Pendiente',
        ]);
    }

    public function test_scheduling_requires_terms_acceptance(): void
    {
        $response = $this->post('/citas/agendar', [
            'nombre' => 'Cliente Sin Terminos',
            'email' => 'sinterminos@example.com',
            'telefono' => '3411112233',
            'mascota_nombre' => 'Mishi',
            'especie' => 'Gato',
            'servicio' => 'Vacunación',
            'fecha' => Carbon::tomorrow()->toDateString(),
            'hora' => '11:00',
            // 'terms' omitido intencionalmente
        ]);

        $response->assertSessionHasErrors('terms');
    }

    public function test_scheduling_requires_phone_number(): void
    {
        $response = $this->post('/citas/agendar', [
            'nombre' => 'Cliente Sin Teléfono',
            'email' => 'sintelefono@example.com',
            // 'telefono' omitido
            'mascota_nombre' => 'Pelusa',
            'especie' => 'Conejo',
            'servicio' => 'Revisión General',
            'fecha' => Carbon::tomorrow()->toDateString(),
            'hora' => '12:00',
            'terms' => '1',
        ]);

        $response->assertSessionHasErrors('telefono');
    }
}
