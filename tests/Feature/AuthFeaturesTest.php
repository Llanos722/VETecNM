<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFeaturesTest extends TestCase
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
    }

    public function test_register_page_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Crea tu cuenta');
        $response->assertSee('Términos, Condiciones y Protocolos de Acceso');
    }

    public function test_forgot_password_page_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Restablecer Contraseña');
    }

    public function test_user_can_register_new_account(): void
    {
        $email = 'testuser_'.time().'@example.com';

        $response = $this->post('/register', [
            'nombre' => 'Test User',
            'email' => $email,
            'telefono' => '3411234567',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'register_ok');

        $this->assertDatabaseHas('usuarios', [
            'email' => $email,
            'nombre' => 'Test User',
            'telefono' => '3411234567',
        ]);
    }

    public function test_user_can_reset_password(): void
    {
        $email = 'resetuser_'.time().'@example.com';

        DB::table('usuarios')->insert([
            'nombre' => 'Reset User',
            'email' => $email,
            'password' => Hash::make('oldpassword'),
            'rol' => 'cliente',
            'fecha_registro' => now(),
        ]);

        $response = $this->post('/forgot-password', [
            'login-user' => $email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'password_reset_ok');

        $user = DB::table('usuarios')->where('email', $email)->first();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_no_permite_registrar_dos_usuarios_con_el_mismo_telefono(): void
    {
        $email1 = 'user1_'.time().'@example.com';
        $email2 = 'user2_'.time().'@example.com';
        $telefono = '3415559988';

        // Registro 1
        $this->post('/register', [
            'nombre' => 'Primer Cliente',
            'email' => $email1,
            'telefono' => $telefono,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('login'));

        // Intento de registro 2 con el mismo número de teléfono
        $response = $this->post('/register', [
            'nombre' => 'Segundo Cliente',
            'email' => $email2,
            'telefono' => $telefono,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('telefono');
        $this->assertEquals(1, DB::table('usuarios')->where('telefono', $telefono)->count());
    }

    public function test_cliente_puede_modificar_su_contrasena_desde_su_perfil(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Cliente Password Test',
            'email' => 'clientpass_'.time().'@example.com',
            'telefono' => '3419998877',
            'password' => Hash::make('ClaveActual123'),
            'rol' => 'cliente',
            'fecha_registro' => now(),
        ]);

        $response = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->post('/dashboard/perfil/password', [
                'current_password' => 'ClaveActual123',
                'password' => 'NuevaClaveSegura2026',
                'password_confirmation' => 'NuevaClaveSegura2026',
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('password_updated_success');

        $user = DB::table('usuarios')->where('id_usuario', $userId)->first();
        $this->assertTrue(Hash::check('NuevaClaveSegura2026', $user->password));
    }

    public function test_cliente_puede_modificar_su_contrasena_via_ajax_y_recibir_respuesta_inmediata(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Cliente Ajax Test',
            'email' => 'clientajax_'.time().'@example.com',
            'telefono' => '3417776655',
            'password' => Hash::make('ClaveVieja456'),
            'rol' => 'cliente',
            'fecha_registro' => now(),
        ]);

        $response = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->postJson('/dashboard/perfil/password', [
                'current_password' => 'ClaveVieja456',
                'password' => 'NuevaClaveAjax789',
                'password_confirmation' => 'NuevaClaveAjax789',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonFragment([
            'message' => '¡Tu contraseña ha sido modificada con éxito!',
        ]);

        $user = DB::table('usuarios')->where('id_usuario', $userId)->first();
        $this->assertTrue(Hash::check('NuevaClaveAjax789', $user->password));
    }

    public function test_no_permite_modificar_contrasena_si_la_actual_es_incorrecta(): void
    {
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => 'Cliente Err Test',
            'email' => 'clienterr_'.time().'@example.com',
            'telefono' => '3413332211',
            'password' => Hash::make('ClaveReal123'),
            'rol' => 'cliente',
            'fecha_registro' => now(),
        ]);

        $response = $this->withSession(['user_id' => $userId, 'user_rol' => 'cliente'])
            ->postJson('/dashboard/perfil/password', [
                'current_password' => 'ClaveEquivocada999',
                'password' => 'NuevaClave789',
                'password_confirmation' => 'NuevaClave789',
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'La contraseña actual ingresada es incorrecta.',
        ]);

        $user = DB::table('usuarios')->where('id_usuario', $userId)->first();
        $this->assertTrue(Hash::check('ClaveReal123', $user->password));
    }

    public function test_no_permite_modificar_contrasena_sin_sesion_activa(): void
    {
        $response = $this->postJson('/dashboard/perfil/password', [
            'current_password' => 'ClaveCualquiera',
            'password' => 'NuevaClave789',
            'password_confirmation' => 'NuevaClave789',
        ]);

        $response->assertStatus(401);
    }
}
