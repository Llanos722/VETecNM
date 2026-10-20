<?php

namespace Tests\Feature;

use App\Services\MascotaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MascotasDuenosRequerimientosTest extends TestCase
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
                id_usuario INTEGER,
                nombre VARCHAR(100) NOT NULL,
                especie VARCHAR(50) NOT NULL,
                raza VARCHAR(50),
                edad INTEGER,
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
            CREATE TABLE IF NOT EXISTS mascota_duenos (
                id_mascota INTEGER NOT NULL,
                id_usuario INTEGER NOT NULL,
                es_principal BOOLEAN DEFAULT 0,
                fecha_asignacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id_mascota, id_usuario)
            )
        ');
    }

    private function crearUsuario(string $nombre, string $email, string $rol = 'cliente'): int
    {
        return DB::table('usuarios')->insertGetId([
            'nombre' => $nombre,
            'email' => $email,
            'password' => Hash::make('password123'),
            'rol' => $rol,
            'fecha_registro' => now(),
        ]);
    }

    public function test_evita_doble_registro_de_la_misma_mascota_para_el_mismo_usuario_en_dashboard(): void
    {
        $clienteId = $this->crearUsuario('Carlos Pérez', 'carlos@vetecnm.test', 'cliente');

        // Primer registro exitoso
        $response1 = $this->withSession(['user_id' => $clienteId, 'user_rol' => 'cliente'])
            ->post(route('mascota.store'), [
                'nombre' => 'Pelusa',
                'especie' => 'Gato',
                'raza' => 'Siamés',
                'peso' => 4.2,
            ]);

        $response1->assertRedirect(route('dashboard'));
        $this->assertEquals(1, DB::table('mascotas')->where('nombre', 'Pelusa')->count());

        // Segundo intento con el mismo nombre y especie para el mismo usuario
        $response2 = $this->withSession(['user_id' => $clienteId, 'user_rol' => 'cliente'])
            ->post(route('mascota.store'), [
                'nombre' => 'Pelusa',
                'especie' => 'Gato',
                'raza' => 'Angora',
                'peso' => 4.5,
            ]);

        $response2->assertSessionHas('error');
        $this->assertEquals(1, DB::table('mascotas')->where('nombre', 'Pelusa')->count());
    }

    public function test_evita_doble_registro_en_panel_admin_para_el_mismo_usuario(): void
    {
        $adminId = $this->crearUsuario('Admin Vet', 'admin@vetecnm.test', 'admin');
        $clienteId = $this->crearUsuario('Laura Gómez', 'laura@vetecnm.test', 'cliente');

        // Registro 1
        $response1 = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post(route('admin.mascotas.store'), [
                'id_usuario' => $clienteId,
                'nombre' => 'Firulais',
                'especie' => 'Perro',
                'raza' => 'Labrador',
                'peso' => 20.0,
            ]);

        $response1->assertRedirect(route('admin.mascotas.index'));
        $this->assertEquals(1, DB::table('mascotas')->where('nombre', 'Firulais')->count());

        // Registro 2 duplicado para Laura
        $response2 = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post(route('admin.mascotas.store'), [
                'id_usuario' => $clienteId,
                'nombre' => 'firulais', // case-insensitive
                'especie' => 'Perro',
            ]);

        $response2->assertSessionHas('error');
        $this->assertEquals(1, DB::table('mascotas')->where('nombre', 'Firulais')->count());
    }

    public function test_mascota_puede_tener_maximo_dos_duenos(): void
    {
        $adminId = $this->crearUsuario('Admin Vet', 'admin2@vetecnm.test', 'admin');
        $cliente1 = $this->crearUsuario('Dueño Uno', 'd1@vetecnm.test', 'cliente');
        $cliente2 = $this->crearUsuario('Dueño Dos', 'd2@vetecnm.test', 'cliente');
        $cliente3 = $this->crearUsuario('Dueño Tres', 'd3@vetecnm.test', 'cliente');

        $mascotaId = MascotaService::crearMascotaConDuenos([
            'nombre' => 'Rocky',
            'especie' => 'Perro',
        ], $cliente1);

        $this->assertCount(1, MascotaService::getDuenosDeMascota($mascotaId));

        // Asignar 2do dueño exitosamente
        $response2 = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post(route('admin.mascotas.asignar-dueno', $mascotaId), [
                'id_usuario' => $cliente2,
            ]);

        $response2->assertSessionHas('success');
        $this->assertCount(2, MascotaService::getDuenosDeMascota($mascotaId));

        // Intentar asignar un 3er dueño -> debe fallar por límite de 2
        $response3 = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post(route('admin.mascotas.asignar-dueno', $mascotaId), [
                'id_usuario' => $cliente3,
            ]);

        $response3->assertSessionHas('error');
        $this->assertCount(2, MascotaService::getDuenosDeMascota($mascotaId));
    }

    public function test_admin_y_recepcionista_pueden_asignar_y_quitar_mascotas_a_clientes(): void
    {
        $recepcionistaId = $this->crearUsuario('Recepcionista María', 'recep@vetecnm.test', 'recepcionista');
        $cliente1 = $this->crearUsuario('Dueño Inicial', 'inicial@vetecnm.test', 'cliente');
        $cliente2 = $this->crearUsuario('Nuevo CoDueño', 'codueno@vetecnm.test', 'cliente');

        $mascotaId = MascotaService::crearMascotaConDuenos([
            'nombre' => 'Mimi',
            'especie' => 'Gato',
        ], $cliente1);

        // Recepcionista asigna a cliente2
        $respAsignar = $this->withSession(['user_id' => $recepcionistaId, 'user_rol' => 'recepcionista'])
            ->post(route('admin.mascotas.asignar-dueno', $mascotaId), [
                'id_usuario' => $cliente2,
            ]);

        $respAsignar->assertSessionHas('success');
        $this->assertTrue(MascotaService::usuarioEsDuenoDeMascota($cliente2, $mascotaId));

        // Recepcionista quita a cliente1
        $respQuitar = $this->withSession(['user_id' => $recepcionistaId, 'user_rol' => 'recepcionista'])
            ->post(route('admin.mascotas.quitar-dueno', $mascotaId), [
                'id_usuario' => $cliente1,
            ]);

        $respQuitar->assertSessionHas('success');
        $this->assertFalse(MascotaService::usuarioEsDuenoDeMascota($cliente1, $mascotaId));
        $this->assertTrue(MascotaService::usuarioEsDuenoDeMascota($cliente2, $mascotaId));
    }

    public function test_cliente_no_puede_asignar_ni_quitar_dueños(): void
    {
        $cliente = $this->crearUsuario('Cliente Común', 'comun@vetecnm.test', 'cliente');
        $cliente2 = $this->crearUsuario('Otro Cliente', 'otro@vetecnm.test', 'cliente');

        $mascotaId = MascotaService::crearMascotaConDuenos([
            'nombre' => 'Bobby',
            'especie' => 'Perro',
        ], $cliente);

        $response = $this->withSession(['user_id' => $cliente, 'user_rol' => 'cliente'])
            ->post(route('admin.mascotas.asignar-dueno', $mascotaId), [
                'id_usuario' => $cliente2,
            ]);

        // Debe ser redirigido por AdminMiddleware
        $response->assertRedirect(route('dashboard'));
    }

    public function test_no_permite_asignar_la_misma_mascota_al_mismo_cliente_dos_veces(): void
    {
        $adminId = $this->crearUsuario('Admin Vet', 'admin3@vetecnm.test', 'admin');
        $cliente = $this->crearUsuario('Cliente Solitario', 'solitario@vetecnm.test', 'cliente');

        $mascotaId = MascotaService::crearMascotaConDuenos([
            'nombre' => 'Toby',
            'especie' => 'Perro',
        ], $cliente);

        $response = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post(route('admin.mascotas.asignar-dueno', $mascotaId), [
                'id_usuario' => $cliente,
            ]);

        $response->assertSessionHas('error');
        $this->assertCount(1, MascotaService::getDuenosDeMascota($mascotaId));
    }

    public function test_admin_no_puede_crear_usuario_con_telefono_duplicado(): void
    {
        $adminId = $this->crearUsuario('Admin Vet', 'admin_tel@vetecnm.test', 'admin');
        $this->crearUsuario('Cliente Existente', 'existente@vetecnm.test', 'cliente');
        DB::table('usuarios')->where('email', 'existente@vetecnm.test')->update(['telefono' => '3419991122']);

        $response = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post(route('admin.usuarios.store'), [
                'nombre' => 'Nuevo Cliente Duplicado',
                'email' => 'nuevo_dup@vetecnm.test',
                'telefono' => '3419991122',
                'password' => 'secret123',
                'rol' => 'cliente',
            ]);

        $response->assertSessionHasErrors('telefono');
        $this->assertEquals(1, DB::table('usuarios')->where('telefono', '3419991122')->count());
    }

    public function test_landing_bloquea_registro_con_telefono_ya_asignado_a_otro_cliente(): void
    {
        $this->crearUsuario('Cliente Previo', 'previo@vetecnm.test', 'cliente');
        DB::table('usuarios')->where('email', 'previo@vetecnm.test')->update(['telefono' => '3417778899']);

        // Intento de agendar desde la landing con nuevo email pero teléfono ya perteneciente a otro cliente
        $response = $this->post(route('citas.agendar'), [
            'nombre' => 'Nuevo Usuario Intruso',
            'email' => 'intruso@vetecnm.test',
            'telefono' => '3417778899',
            'mascota_nombre' => 'Copito',
            'especie' => 'Perro',
            'servicio' => 'Consulta Médica General y Pediátrica',
            'profesional' => 'Dr. Alejandro Gómez Morales',
            'fecha' => date('Y-m-d', strtotime('+2 days')),
            'hora' => '10:00:00',
            'motivo' => 'Chequeo rutinario',
            'terms' => true,
        ]);

        $response->assertSessionHas('alerta_error_general');
        $this->assertDatabaseMissing('usuarios', [
            'email' => 'intruso@vetecnm.test',
        ]);
    }

    public function test_cliente_y_admin_pueden_registrar_mascota_con_edad_y_se_guarda_en_la_bdd(): void
    {
        $clienteId = $this->crearUsuario('Cliente Mascotero', 'mascotero@vetecnm.test', 'cliente');
        $adminId = $this->crearUsuario('Admin Mascotas', 'admin_masc@vetecnm.test', 'admin');

        // 1. Registro de mascota por el cliente con edad
        $response = $this->withSession(['user_id' => $clienteId, 'user_rol' => 'cliente'])
            ->post(route('mascota.store'), [
                'nombre' => 'Toby',
                'especie' => 'Perro',
                'raza' => 'Beagle',
                'edad' => 4,
                'peso' => 12.50,
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('mascotas', [
            'nombre' => 'Toby',
            'especie' => 'Perro',
            'edad' => 4,
            'peso' => 12.50,
        ]);

        // 2. Registro de mascota por admin con edad
        $responseAdmin = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->post(route('admin.mascotas.store'), [
                'id_usuario' => $clienteId,
                'nombre' => 'Misi',
                'especie' => 'Gato',
                'raza' => 'Persa',
                'edad' => 2,
                'peso' => 4.10,
            ]);

        $responseAdmin->assertRedirect(route('admin.mascotas.index'));
        $responseAdmin->assertSessionHas('success');

        $this->assertDatabaseHas('mascotas', [
            'nombre' => 'Misi',
            'especie' => 'Gato',
            'edad' => 2,
            'peso' => 4.10,
        ]);

        // 3. Edición de mascota por admin actualizando la edad
        $misi = DB::table('mascotas')->where('nombre', 'Misi')->first();
        $responseEdit = $this->withSession(['user_id' => $adminId, 'user_rol' => 'admin'])
            ->put(route('admin.mascotas.update', $misi->id_mascota), [
                'id_usuario' => $clienteId,
                'nombre' => 'Misi',
                'especie' => 'Gato',
                'raza' => 'Persa',
                'edad' => 3,
                'peso' => 4.30,
            ]);

        $responseEdit->assertRedirect(route('admin.mascotas.index'));
        $this->assertDatabaseHas('mascotas', [
            'id_mascota' => $misi->id_mascota,
            'edad' => 3,
            'peso' => 4.30,
        ]);
    }
}
