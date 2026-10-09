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
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'register_ok');

        $this->assertDatabaseHas('usuarios', [
            'email' => $email,
            'nombre' => 'Test User',
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

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'password_reset_ok');

        $user = DB::table('usuarios')->where('email', $email)->first();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }
}
