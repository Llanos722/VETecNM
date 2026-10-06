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
     * Show dashboard page with live DB statistics.
     */
    public function dashboard()
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'acceso_denegado');
        }

        $totalUsuarios = DB::table('usuarios')->count();
        $totalMascotas = DB::table('mascotas')->count();
        $totalCategorias = DB::table('categorias')->count();
        $totalProductos = DB::table('productos')->count();
        $totalCitas = DB::table('citas')->count();

        $citas = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->select('citas.*', 'mascotas.nombre as mascota_nombre', 'mascotas.especie')
            ->orderBy('citas.fecha', 'asc')
            ->get();

        return view('dashboard', compact(
            'totalUsuarios',
            'totalMascotas',
            'totalCategorias',
            'totalProductos',
            'totalCitas',
            'citas'
        ));
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
