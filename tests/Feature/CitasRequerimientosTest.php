<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CitasRequerimientosTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Crear tablas en memoria SQLite para la suite de pruebas
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
            CREATE TABLE IF NOT EXISTS categorias (
                id_categoria INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre VARCHAR(100) NOT NULL,
                descripcion TEXT
            )
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS productos (
                id_producto INTEGER PRIMARY KEY AUTOINCREMENT,
                id_categoria INTEGER,
                nombre VARCHAR(150) NOT NULL,
                descripcion TEXT,
                precio DECIMAL(10,2) NOT NULL,
                stock INTEGER DEFAULT 0,
                imagen_url VARCHAR(255)
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

        DB::statement('
            CREATE TABLE IF NOT EXISTS configuracion_horarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                dia_semana INTEGER,
                dia_nombre VARCHAR(20),
                hora_apertura TIME DEFAULT "08:00:00",
                hora_cierre TIME DEFAULT "20:00:00",
                intervalo_minutos INTEGER DEFAULT 30,
                activo BOOLEAN DEFAULT 1,
                created_at TIMESTAMP,
                updated_at TIMESTAMP
            )
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS horarios_recesos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre VARCHAR(100),
                hora_inicio TIME DEFAULT "14:00:00",
                hora_fin TIME DEFAULT "15:00:00",
                aplica_a VARCHAR(150) DEFAULT "todos",
                activo BOOLEAN DEFAULT 1,
                created_at TIMESTAMP,
                updated_at TIMESTAMP
            )
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS dias_no_laborables (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                fecha DATE,
                motivo VARCHAR(255),
                activo BOOLEAN DEFAULT 1,
                created_at TIMESTAMP,
                updated_at TIMESTAMP
            )
        ');

        DB::statement('
            CREATE TABLE IF NOT EXISTS bloqueos_personal (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                profesional VARCHAR(150),
                fecha DATE,
                hora_inicio TIME,
                hora_fin TIME,
                motivo VARCHAR(255),
                activo BOOLEAN DEFAULT 1,
                created_at TIMESTAMP,
                updated_at TIMESTAMP
            )
        ');

        DB::table('configuracion_horarios')->truncate();
        for ($d = 1; $d <= 7; $d++) {
            DB::table('configuracion_horarios')->insert([
                'dia_semana' => $d,
                'dia_nombre' => 'Dia '.$d,
                'hora_apertura' => '08:00:00',
                'hora_cierre' => '20:00:00',
                'intervalo_minutos' => 30,
                'activo' => 1,
            ]);
        }
    }

    /**
     * Prueba: No permitir agendar si la hora ya pasó o faltan menos de 30 minutos.
     */
    public function test_no_permite_agendar_cita_si_la_hora_ya_ha_pasado_o_es_menos_de_media_hora(): void
    {
        $horaPasada = Carbon::now()->subMinutes(15)->format('H:i');
        $horaMenosDeMediaHora = Carbon::now()->addMinutes(15)->format('H:i');
        $fechaHoy = Carbon::today()->toDateString();

        // Intentar con hora pasada
        $response1 = $this->post('/citas/agendar', [
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'telefono' => '3411234567',
            'mascota_nombre' => 'Bobby',
            'especie' => 'Perro',
            'servicio' => 'Consulta Médica General y Pediátrica',
            'fecha' => $fechaHoy,
            'hora' => $horaPasada,
            'terms' => '1',
            'motivo' => 'Revisión rápida',
        ]);

        $response1->assertSessionHas('horario_no_disponible_alerta');

        // Intentar con hora menor a 30 minutos de anticipación
        $response2 = $this->post('/citas/agendar', [
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'telefono' => '3411234567',
            'mascota_nombre' => 'Bobby',
            'especie' => 'Perro',
            'servicio' => 'Consulta Médica General y Pediátrica',
            'fecha' => $fechaHoy,
            'hora' => $horaMenosDeMediaHora,
            'terms' => '1',
            'motivo' => 'Revisión rápida',
        ]);

        $response2->assertSessionHas('horario_no_disponible_alerta');
    }

    /**
     * Prueba: No permitir duplicar cita por el mismo motivo, la misma hora y la misma mascota.
     */
    public function test_no_permite_duplicar_cita_misma_mascota_misma_hora_mismo_motivo(): void
    {
        $fechaFutura = Carbon::now()->addDays(2)->toDateString();
        $hora = '11:00';
        $motivo = 'Vacunación y desparasitación';

        // 1. Agendar primera cita
        $response1 = $this->post('/citas/agendar', [
            'nombre' => 'Carlos Mendoza',
            'email' => 'carlos@example.com',
            'telefono' => '3415551234',
            'mascota_nombre' => 'Max',
            'especie' => 'Perro',
            'servicio' => 'Esquema de Vacunación Canina y Felina',
            'fecha' => $fechaFutura,
            'hora' => $hora,
            'terms' => '1',
            'motivo' => $motivo,
        ]);

        $response1->assertRedirect(route('home', ['#calendario']));

        // 2. Intentar agendar exactamente la misma cita (misma mascota, fecha, hora y motivo)
        $response2 = $this->post('/citas/agendar', [
            'nombre' => 'Carlos Mendoza',
            'email' => 'carlos@example.com',
            'telefono' => '3415551234',
            'mascota_nombre' => 'Max',
            'especie' => 'Perro',
            'servicio' => 'Esquema de Vacunación Canina y Felina',
            'fecha' => $fechaFutura,
            'hora' => $hora,
            'terms' => '1',
            'motivo' => $motivo,
        ]);

        $response2->assertSessionHas('alerta_error_general');
        $this->assertEquals(1, DB::table('citas')->where('fecha', $fechaFutura)->where('hora', '11:00:00')->count());
    }

    /**
     * R-30: Agendamiento de citas para clientes registrados.
     */
    public function test_r30_cliente_registrado_puede_agendar_seleccionando_servicio_profesional_mascota_fecha_hora(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Cliente Registrado',
            'email' => 'registrado@example.com',
            'telefono' => '3411230000',
            'password' => bcrypt('password'),
            'rol' => 'cliente',
        ]);

        $mascotaId = DB::table('mascotas')->insertGetId([
            'id_usuario' => $userId,
            'nombre' => 'Rocky',
            'especie' => 'Perro',
        ]);

        $fecha = Carbon::now()->addDays(3)->toDateString();

        $response = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->post('/citas/agendar-cliente', [
                'id_mascota' => $mascotaId,
                'servicio' => 'Consulta Médica General y Pediátrica',
                'profesional' => 'Dra. Sofía Valenzuela Méndez',
                'fecha' => $fecha,
                'hora' => '16:00',
                'motivo' => 'Revisión anual programada',
            ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('citas', [
            'id_mascota' => $mascotaId,
            'servicio' => 'Consulta Médica General y Pediátrica',
            'profesional' => 'Dra. Sofía Valenzuela Méndez',
            'fecha' => $fecha,
            'hora' => '16:00:00',
            'precio' => 350.00,
        ]);
    }

    /**
     * Prueba: Agendar cita asigna el precio oficial por servicio.
     */
    public function test_agendamiento_registra_precio_oficial_por_servicio(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Dueño Test',
            'email' => 'precio_test@example.com',
            'telefono' => '3419991122',
            'password' => bcrypt('password'),
            'rol' => 'cliente',
        ]);

        $mascotaId = DB::table('mascotas')->insertGetId([
            'id_usuario' => $userId,
            'nombre' => 'Canela',
            'especie' => 'Perro',
        ]);

        $fecha = Carbon::now()->addDays(4)->toDateString();

        // 1. Agendar servicio de Esterilización (Precio catálogo: 1200.00)
        $response = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->post('/citas/agendar-cliente', [
                'id_mascota' => $mascotaId,
                'servicio' => 'Esterilización y Castración Segura',
                'profesional' => 'Dra. Sofía Valenzuela Méndez',
                'fecha' => $fecha,
                'hora' => '09:00',
                'motivo' => 'Esterilización programada',
            ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('citas', [
            'id_mascota' => $mascotaId,
            'servicio' => 'Esterilización y Castración Segura',
            'precio' => 1200.00,
        ]);
    }

    /**
     * R-31: Disponibilidad muestra únicamente horarios disponibles respetando recesos y días no laborables.
     */
    public function test_r31_disponibilidad_filtra_recesos_y_dias_no_laborables(): void
    {
        // Configurar un día no laborable
        $fechaFestivo = Carbon::now()->addDays(5)->toDateString();
        DB::table('dias_no_laborables')->insert([
            'fecha' => $fechaFestivo,
            'motivo' => 'Feriado Oficial',
            'activo' => 1,
        ]);

        // Consultar API para ese día
        $respFestivo = $this->getJson("/api/citas/disponibilidad?fecha={$fechaFestivo}");
        $respFestivo->assertStatus(200);
        $respFestivo->assertJson([
            'disponible' => false,
        ]);
        $this->assertEmpty($respFestivo->json('slots'));

        // Consultar día normal: verificar que 14:00 y 14:30 no estén disponibles por receso de comida
        DB::table('horarios_recesos')->insert([
            'nombre' => 'Receso Almuerzo',
            'hora_inicio' => '14:00:00',
            'hora_fin' => '15:00:00',
            'aplica_a' => 'todos',
            'activo' => 1,
        ]);

        $fechaNormal = Carbon::now()->addDays(2)->toDateString();
        $respNormal = $this->getJson("/api/citas/disponibilidad?fecha={$fechaNormal}");
        $respNormal->assertStatus(200);
        $this->assertTrue($respNormal->json('disponible'));
        $this->assertNotContains('14:00', $respNormal->json('slots'));
        $this->assertNotContains('14:30', $respNormal->json('slots'));
    }

    /**
     * R-32: Validación de disponibilidad impide citas simultáneas al mismo trabajador
     * y genera la alerta para la ventana azul.
     */
    public function test_r32_impide_citas_simultaneas_al_mismo_trabajador(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Dueño 1',
            'email' => 'd1@example.com',
            'password' => bcrypt('password'),
            'rol' => 'cliente',
        ]);
        $m1 = DB::table('mascotas')->insertGetId(['id_usuario' => $userId, 'nombre' => 'M1', 'especie' => 'Gato']);
        $m2 = DB::table('mascotas')->insertGetId(['id_usuario' => $userId, 'nombre' => 'M2', 'especie' => 'Perro']);

        $fecha = Carbon::now()->addDays(2)->toDateString();
        $profesional = 'Dr. Alejandro Gómez Morales';

        // 1. Agendar cita con el Dr. Gómez a las 10:00
        DB::table('citas')->insert([
            'id_mascota' => $m1,
            'fecha' => $fecha,
            'hora' => '10:00:00',
            'profesional' => $profesional,
            'servicio' => 'Consulta',
            'motivo' => 'Motivo A',
            'estado' => 'Confirmada',
        ]);

        // 2. Intentar agendar otra mascota con el mismo profesional en la misma fecha y hora
        $response = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->post('/citas/agendar-cliente', [
                'id_mascota' => $m2,
                'servicio' => 'Imagenología',
                'profesional' => $profesional,
                'fecha' => $fecha,
                'hora' => '10:00',
                'motivo' => 'Motivo B',
            ]);

        $response->assertSessionHas('horario_no_disponible_alerta');
    }

    /**
     * R-33: Agendamiento presencial o telefónico por recepcionista.
     */
    public function test_r33_recepcionista_puede_registrar_cita_presencial_o_telefonica(): void
    {
        $recepId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Recepcionista Turno',
            'email' => 'recep@vetecnm.com',
            'password' => bcrypt('password'),
            'rol' => 'recepcionista',
        ]);

        $fecha = Carbon::now()->addDays(2)->toDateString();

        $response = $this->withSession(['user_id' => $recepId, 'user_rol' => 'recepcionista'])
            ->post('/admin/citas/presencial', [
                'canal' => 'telefono',
                'cliente_nombre' => 'Llamada Don Pedro',
                'cliente_telefono' => '3419998877',
                'mascota_nombre' => 'Firulais',
                'mascota_especie' => 'Perro',
                'servicio' => 'Consulta Médica General y Pediátrica',
                'profesional' => 'Dra. Sofía Valenzuela Méndez',
                'fecha' => $fecha,
                'hora' => '11:30',
                'motivo' => 'Cita solicitada vía telefónica por claudicación',
                'notas' => 'El cliente confirmó que llegará 10 minutos antes.',
            ]);

        $response->assertRedirect(route('admin.citas.index'));
        $this->assertDatabaseHas('citas', [
            'canal' => 'telefono',
            'servicio' => 'Consulta Médica General y Pediátrica',
            'profesional' => 'Dra. Sofía Valenzuela Méndez',
            'fecha' => $fecha,
            'hora' => '11:30:00',
            'estado' => 'Confirmada',
        ]);
    }

    /**
     * R-34: Configuración de horarios por el Administrador.
     */
    public function test_r34_administrador_puede_configurar_horarios_recesos_y_bloqueos(): void
    {
        $adminId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Super Admin',
            'email' => 'sadmin@example.com',
            'password' => bcrypt('password'),
            'rol' => 'admin',
        ]);

        // 1. Agregar un día no laborable
        $fechaAsueto = Carbon::now()->addDays(10)->toDateString();
        $respDia = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post('/admin/horarios/dias-no-laborables', [
                'fecha' => $fechaAsueto,
                'motivo' => 'Asueto Especial VETecNM',
            ]);
        $respDia->assertRedirect(route('admin.horarios.index'));
        $this->assertDatabaseHas('dias_no_laborables', ['fecha' => $fechaAsueto, 'motivo' => 'Asueto Especial VETecNM']);

        // 2. Agregar un bloqueo de personal
        $respBloqueo = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post('/admin/horarios/bloqueos-personal', [
                'profesional' => 'Dra. Sofía Valenzuela Méndez',
                'fecha' => Carbon::now()->addDays(7)->toDateString(),
                'tipo_bloqueo' => 'completo',
                'motivo' => 'Congreso Internacional de Cirugía',
            ]);
        $respBloqueo->assertRedirect(route('admin.horarios.index'));
        $this->assertDatabaseHas('bloqueos_personal', ['profesional' => 'Dra. Sofía Valenzuela Méndez', 'motivo' => 'Congreso Internacional de Cirugía']);
    }

    /**
     * Prueba: Permite agendar a la misma hora si es con especialistas distintos.
     */
    public function test_permite_citas_a_la_misma_hora_si_son_con_doctores_distintos(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Cliente Multicita',
            'email' => 'multi@example.com',
            'password' => bcrypt('password'),
            'rol' => 'cliente',
        ]);
        $m1 = DB::table('mascotas')->insertGetId(['id_usuario' => $userId, 'nombre' => 'Pelusa', 'especie' => 'Gato']);
        $m2 = DB::table('mascotas')->insertGetId(['id_usuario' => $userId, 'nombre' => 'Toby', 'especie' => 'Perro']);

        $fecha = Carbon::now()->addDays(2)->toDateString();
        $hora = '12:00';

        // 1. Cita con la Dra. Sofía Valenzuela
        $resp1 = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->post('/citas/agendar-cliente', [
                'id_mascota' => $m1,
                'servicio' => 'Consulta Médica General y Pediátrica',
                'profesional' => 'Dra. Sofía Valenzuela Méndez',
                'fecha' => $fecha,
                'hora' => $hora,
                'motivo' => 'Revisión dental',
            ]);
        $resp1->assertRedirect(route('dashboard'));

        // 2. Cita a la misma hora con el Dr. Alejandro Gómez (distinto doctor)
        $resp2 = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->post('/citas/agendar-cliente', [
                'id_mascota' => $m2,
                'servicio' => 'Consulta Médica General y Pediátrica',
                'profesional' => 'Dr. Alejandro Gómez Morales',
                'fecha' => $fecha,
                'hora' => $hora,
                'motivo' => 'Chequeo de rutina',
            ]);
        $resp2->assertRedirect(route('dashboard'));

        $this->assertEquals(2, DB::table('citas')->where('fecha', $fecha)->where('hora', '12:00:00')->count());
    }

    /**
     * Prueba: Las vistas y registros de citas contienen precio y motivo claramente definidos.
     */
    public function test_dashboard_muestra_precio_y_motivo(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Cliente Vista Test',
            'email' => 'vistatest@example.com',
            'password' => bcrypt('password'),
            'rol' => 'cliente',
        ]);
        $m = DB::table('mascotas')->insertGetId(['id_usuario' => $userId, 'nombre' => 'Balu', 'especie' => 'Perro']);

        $fecha = Carbon::now()->addDays(3)->toDateString();

        $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->post('/citas/agendar-cliente', [
                'id_mascota' => $m,
                'servicio' => 'Consulta Médica General y Pediátrica',
                'profesional' => 'Dra. Sofía Valenzuela Méndez',
                'fecha' => $fecha,
                'hora' => '15:00',
                'motivo' => 'Dolor estomacal y falta de apetito',
            ]);

        $response = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dolor estomacal y falta de apetito');
        $response->assertSee('350.00');
    }
}
