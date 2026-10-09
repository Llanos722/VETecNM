<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Process authentication request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login-user' => 'required|string',
            'login-password' => 'required|string',
        ]);

        $inputUser = trim($request->input('login-user'));
        $inputPassword = $request->input('login-password');

        // Search user in 'usuarios' table by email or nombre
        $usuario = DB::table('usuarios')
            ->where('email', $inputUser)
            ->orWhere('nombre', $inputUser)
            ->first();

        if (! $usuario) {
            return redirect()->route('login')
                ->withInput()
                ->with('error', 'login_fail');
        }

        // Check password (support bcrypt hash or plaintext seed passwords)
        $passwordValid = Hash::check($inputPassword, $usuario->password) || ($inputPassword === $usuario->password);

        if (! $passwordValid) {
            return redirect()->route('login')
                ->withInput()
                ->with('error', 'login_fail');
        }

        // Set session parameters
        session([
            'user_id' => $usuario->id_usuario,
            'user_nombre' => $usuario->nombre,
            'user_email' => $usuario->email,
            'user_rol' => $usuario->rol,
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Display registration form.
     */
    public function showRegisterForm()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /**
     * Process registration request (including optional pet registration).
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
            'nombre_mascota' => 'nullable|string|max:100',
            'especie_mascota' => 'nullable|string|max:50',
            'raza_mascota' => 'nullable|string|max:50',
            'peso_mascota' => 'nullable|numeric|min:0|max:999.99',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Insert new user and get ID
        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => trim($request->input('nombre')),
            'email' => strtolower(trim($request->input('email'))),
            'password' => Hash::make($request->input('password')),
            'rol' => 'cliente',
            'fecha_registro' => now(),
        ]);

        // Register pet if provided
        if ($request->filled('nombre_mascota')) {
            DB::table('mascotas')->insert([
                'id_usuario' => $userId,
                'nombre' => trim($request->input('nombre_mascota')),
                'especie' => $request->input('especie_mascota') ? trim($request->input('especie_mascota')) : 'Perro',
                'raza' => $request->filled('raza_mascota') ? trim($request->input('raza_mascota')) : null,
                'peso' => $request->input('peso_mascota'),
            ]);
        }

        return redirect()->route('login')->with('success', 'register_ok');
    }

    /**
     * Display forgot/reset password form.
     */
    public function showForgotPasswordForm()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.forgot-password');
    }

    /**
     * Process password reset request.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'login-user' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'login-user.required' => 'El usuario o correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $inputUser = trim($request->input('login-user'));

        $usuario = DB::table('usuarios')
            ->where('email', $inputUser)
            ->orWhere('nombre', $inputUser)
            ->first();

        if (! $usuario) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'user_not_found');
        }

        DB::table('usuarios')
            ->where('id_usuario', $usuario->id_usuario)
            ->update([
                'password' => Hash::make($request->input('password')),
            ]);

        return redirect()->route('login')->with('success', 'password_reset_ok');
    }

    /**
     * Show dashboard page with live DB statistics.
     */
    public function dashboard()
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'acceso_denegado');
        }

        $userId = session('user_id');
        $userRol = session('user_rol');

        $totalUsuarios = DB::table('usuarios')->count();
        $totalMascotas = DB::table('mascotas')->count();
        $totalCategorias = DB::table('categorias')->count();
        $totalProductos = DB::table('productos')->count();
        $totalCitas = DB::table('citas')->count();

        // Get user's pets or all pets if admin
        $misMascotas = DB::table('mascotas')
            ->where('id_usuario', $userId)
            ->get();

        $citasQuery = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->select('citas.*', 'mascotas.nombre as mascota_nombre', 'mascotas.especie');

        if ($userRol !== 'admin') {
            $citasQuery->where('mascotas.id_usuario', $userId);
        }

        $citas = $citasQuery->orderBy('citas.fecha', 'asc')->get();

        return view('dashboard', compact(
            'totalUsuarios',
            'totalMascotas',
            'totalCategorias',
            'totalProductos',
            'totalCitas',
            'misMascotas',
            'citas'
        ));
    }

    /**
     * Client pet registration method
     */
    public function registerPet(Request $request)
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'peso' => 'nullable|numeric|min:0|max:999.99',
        ]);

        DB::table('mascotas')->insert([
            'id_usuario' => session('user_id'),
            'nombre' => trim($request->nombre),
            'especie' => trim($request->especie),
            'raza' => $request->raza ? trim($request->raza) : null,
            'peso' => $request->peso,
        ]);

        return redirect()->route('dashboard')->with('success', '¡Tu mascota ha sido registrada correctamente!');
    }

    /**
     * Process logout request.
     */
    public function logout(Request $request)
    {
        session()->flush();

        return redirect()->route('login')->with('success', 'logout_ok');
    }
}
