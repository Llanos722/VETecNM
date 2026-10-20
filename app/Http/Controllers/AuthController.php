<?php

namespace App\Http\Controllers;

use App\Services\CitaService;
use App\Services\MascotaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        if (session()->has('user_id')) {
            if (in_array(session('user_rol'), ['admin', 'recepcionista'], true)) {
                return redirect()->route('admin.dashboard');
            }

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

        // Redirección directa por perfil:
        // Administrador se dirige directo y sin escalas al Dashboard de administración
        if (in_array($usuario->rol, ['admin', 'recepcionista'], true)) {
            return redirect()->route('admin.dashboard');
        }

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
            'telefono' => 'required|string|max:20|unique:usuarios,telefono',
            'password' => 'required|string|min:6|confirmed',
            'nombre_mascota' => 'nullable|string|max:100',
            'especie_mascota' => 'nullable|string|max:50',
            'raza_mascota' => 'nullable|string|max:50',
            'edad_mascota' => 'nullable|integer|min:0|max:100',
            'peso_mascota' => 'nullable|numeric|min:0|max:999.99',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'telefono.unique' => 'Este número de teléfono ya está registrado por otro cliente. Solo se permite un número de teléfono por cliente.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'edad_mascota.integer' => 'La edad de la mascota debe ser un número entero.',
            'edad_mascota.min' => 'La edad no puede ser menor a 0.',
            'edad_mascota.max' => 'La edad no puede exceder 100 años.',
        ]);

        // Insert new user and get ID
        $userData = [
            'nombre' => trim($request->input('nombre')),
            'email' => strtolower(trim($request->input('email'))),
            'password' => Hash::make($request->input('password')),
            'rol' => 'cliente',
            'fecha_registro' => now(),
        ];

        if ($request->filled('telefono') && Schema::hasColumn('usuarios', 'telefono')) {
            $userData['telefono'] = trim($request->input('telefono'));
        }

        $userId = DB::table('usuarios')->insertGetId($userData);

        // Register pet if provided
        if ($request->filled('nombre_mascota')) {
            MascotaService::crearMascotaConDuenos([
                'nombre' => trim($request->input('nombre_mascota')),
                'especie' => $request->input('especie_mascota') ? trim($request->input('especie_mascota')) : 'Perro',
                'raza' => $request->filled('raza_mascota') ? trim($request->input('raza_mascota')) : null,
                'edad' => $request->input('edad_mascota'),
                'peso' => $request->input('peso_mascota'),
            ], $userId);
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

        // Si es administrador o recepcionista, dirigir directamente a su panel de administración
        if (in_array(session('user_rol'), ['admin', 'recepcionista'], true)) {
            return redirect()->route('admin.dashboard');
        }

        $userId = session('user_id');
        $usuario = DB::table('usuarios')->where('id_usuario', $userId)->first();

        // Mascotas del cliente con estadísticas de consultas y citas
        $misMascotas = MascotaService::getMascotasDeUsuario($userId);

        foreach ($misMascotas as $m) {
            $m->total_citas = DB::table('citas')->where('id_mascota', $m->id_mascota)->count();
            $m->proxima_cita = DB::table('citas')
                ->where('id_mascota', $m->id_mascota)
                ->where('fecha', '>=', now()->toDateString())
                ->whereIn('estado', ['Pendiente', 'Confirmada'])
                ->orderBy('fecha', 'asc')
                ->orderBy('hora', 'asc')
                ->first();
            $m->duenos = MascotaService::getDuenosDeMascota($m->id_mascota);
        }

        // Citas agendadas del cliente
        $mascotaIds = $misMascotas->pluck('id_mascota')->toArray();
        $citas = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->whereIn('citas.id_mascota', $mascotaIds)
            ->select('citas.*', 'mascotas.nombre as mascota_nombre', 'mascotas.especie', 'mascotas.raza', 'mascotas.peso as mascota_peso')
            ->orderBy('citas.fecha', 'desc')
            ->orderBy('citas.hora', 'desc')
            ->get();

        $profesionales = CitaService::getProfesionales();

        $serviciosPorCategoria = CitaService::getServiciosPorCategoria();
        $serviciosLista = CitaService::getServicios();
        $mapaServiciosProfesionales = CitaService::getMapaServiciosProfesionales();
        $serviciosDisponibles = [];
        foreach ($serviciosPorCategoria as $catName => $items) {
            $serviciosDisponibles[$catName] = array_column($items, 'nombre');
        }

        return view('dashboard', compact(
            'usuario',
            'misMascotas',
            'citas',
            'profesionales',
            'serviciosDisponibles',
            'serviciosPorCategoria',
            'serviciosLista',
            'mapaServiciosProfesionales'
        ));
    }

    /**
     * Agendamiento de citas para clientes registrados (R-30, R-31, R-32).
     */
    public function agendarCitaCliente(Request $request)
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login');
        }

        $userId = session('user_id');

        $request->validate([
            'id_mascota' => 'required|exists:mascotas,id_mascota',
            'servicio' => 'required|string|max:150',
            'profesional' => 'required|string|max:150',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|string',
            'motivo' => 'nullable|string|max:255',
        ], [
            'id_mascota.required' => 'Selecciona la mascota que asistirá a la cita.',
            'servicio.required' => 'Selecciona el servicio médico o estético deseado.',
            'profesional.required' => 'Selecciona el profesional de salud/estética.',
            'fecha.required' => 'Selecciona la fecha de la cita.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al día de hoy.',
            'hora.required' => 'Selecciona el horario deseado.',
        ]);

        // Verificar que la mascota pertenezca al usuario logueado (o si es admin)
        if (! MascotaService::usuarioEsDuenoDeMascota($userId, (int) $request->id_mascota) && session('user_rol') !== 'admin') {
            return redirect()->back()->with('error', 'La mascota seleccionada no corresponde a tu cuenta.');
        }

        // 1. RESTRICCIÓN DE TIEMPO: No permitir hora pasada ni con menos de 30 minutos de anticipación
        try {
            CitaService::validarTiempoMinimo($request->fecha, $request->hora);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('horario_no_disponible_alerta', [
                    'mensaje' => 'El horario seleccionado ya no se encuentra disponible.',
                    'detalle' => $e->validator->errors()->first('hora'),
                ]);
        }

        // 2. VALIDACIÓN DE DISPONIBILIDAD DEL TRABAJADOR (R-32): Evitar citas simultáneas y bloqueos
        $profesional = trim($request->profesional);
        if (! CitaService::esProfesionalAptoParaServicio($profesional, $request->servicio)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['profesional' => 'El profesional seleccionado no realiza el servicio solicitado. Por favor selecciona un especialista calificado.']);
        }

        $dispTrabajador = CitaService::verificarDisponibilidadTrabajador($profesional, $request->fecha, $request->hora);
        if (! $dispTrabajador['disponible']) {
            return redirect()->back()
                ->withInput()
                ->with('horario_no_disponible_alerta', [
                    'mensaje' => 'El horario ya no se encuentra disponible.',
                    'detalle' => $dispTrabajador['mensaje'] ?? 'El profesional ya tiene una cita asignada en ese horario.',
                ]);
        }

        // 3. RESTRICCIÓN DE DUPLICADOS: No duplicar cita por mismo motivo, hora y mascota
        $motivoCompleto = trim($request->servicio);
        if ($request->filled('motivo')) {
            $motivoCompleto .= ' - '.trim($request->motivo);
        }

        try {
            CitaService::validarDuplicado((int) $request->id_mascota, $request->fecha, $request->hora, $motivoCompleto, $request->servicio);
        } catch (ValidationException $e) {
            $msg = $e->validator->errors()->first('duplicado');

            return redirect()->back()
                ->withInput()
                ->with('error', $msg)
                ->with('alerta_error_general', $msg)
                ->withErrors(['duplicado' => $msg]);
        }

        // Obtener teléfono del usuario para la cita
        $userObj = DB::table('usuarios')->where('id_usuario', $userId)->first();
        $horaFormateada = strlen($request->hora) === 5 ? $request->hora.':00' : $request->hora;
        $precio = $request->filled('precio') ? (float) $request->precio : CitaService::getPrecioServicio($request->servicio);

        $citaData = [
            'id_mascota' => $request->id_mascota,
            'fecha' => $request->fecha,
            'hora' => $horaFormateada,
            'servicio' => trim($request->servicio),
            'profesional' => $profesional,
            'telefono_contacto' => $userObj->telefono ?? null,
            'motivo' => $motivoCompleto,
            'estado' => 'Pendiente',
            'canal' => 'web',
            'notas' => $request->motivo ? trim($request->motivo) : null,
            'fecha_creacion' => now(),
        ];

        if (Schema::hasColumn('citas', 'precio')) {
            $citaData['precio'] = $precio;
        }

        $citaId = DB::table('citas')->insertGetId($citaData);

        return redirect()->route('dashboard')
            ->with('success', '¡Cita médica agendada exitosamente!')
            ->with('nueva_cita_id', $citaId);
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
            'edad' => 'nullable|integer|min:0|max:100',
            'peso' => 'nullable|numeric|min:0|max:999.99',
        ], [
            'edad.integer' => 'La edad debe ser un número entero.',
            'edad.min' => 'La edad no puede ser menor a 0.',
            'edad.max' => 'La edad no puede exceder 100 años.',
        ]);

        try {
            MascotaService::crearMascotaConDuenos([
                'nombre' => $request->nombre,
                'especie' => $request->especie,
                'raza' => $request->raza,
                'edad' => $request->edad,
                'peso' => $request->peso,
            ], session('user_id'));
        } catch (ValidationException $e) {
            $errorMsg = $e->validator->errors()->first('duplicado') ?? $e->getMessage();

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMsg);
        }

        return redirect()->route('dashboard')->with('success', '¡Tu mascota ha sido registrada correctamente!');
    }

    /**
     * Descarga / Visualización formal del comprobante de cita médica (Voucher/Ticket de Cita).
     */
    public function descargarComprobante($id)
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'acceso_denegado');
        }

        $userId = session('user_id');
        $userRol = session('user_rol');

        $citaQuery = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->where('citas.id_cita', $id)
            ->select(
                'citas.*',
                'mascotas.id_mascota',
                'mascotas.nombre as mascota_nombre',
                'mascotas.especie',
                'mascotas.raza',
                'mascotas.peso as mascota_peso',
                'mascotas.id_usuario',
                'usuarios.nombre as dueno_nombre',
                'usuarios.email as dueno_email',
                'usuarios.telefono as dueno_telefono'
            );

        $cita = $citaQuery->first();

        if (! $cita) {
            return redirect()->route('dashboard')->with('error', 'La cita solicitada no existe.');
        }

        // Si no es admin/recepcionista, solo puede consultar el comprobante si es dueño de la mascota
        if (! in_array($userRol, ['admin', 'recepcionista'], true)) {
            if (! MascotaService::usuarioEsDuenoDeMascota($userId, (int) $cita->id_mascota)) {
                return redirect()->route('dashboard')->with('error', 'No tienes autorización para visualizar este comprobante.');
            }
        }

        return view('citas.comprobante', compact('cita'));
    }

    /**
     * Update client password from user profile with immediate feedback.
     */
    public function updatePassword(Request $request)
    {
        if (! session()->has('user_id')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.',
                ], 401);
            }

            return redirect()->route('login')->with('error', 'acceso_denegado');
        }

        $userId = session('user_id');

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed|different:current_password',
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'password.required' => 'Debes ingresar una nueva contraseña.',
            'password.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
            'password.different' => 'La nueva contraseña debe ser diferente a la contraseña actual.',
        ]);

        $usuario = DB::table('usuarios')->where('id_usuario', $userId)->first();

        if (! $usuario) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado en el sistema.',
                ], 404);
            }

            return redirect()->route('login');
        }

        $isPasswordValid = Hash::check($request->current_password, $usuario->password) || ($request->current_password === $usuario->password);

        if (! $isPasswordValid) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual ingresada es incorrecta.',
                    'errors' => [
                        'current_password' => ['La contraseña actual ingresada es incorrecta.'],
                    ],
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['current_password' => 'La contraseña actual ingresada es incorrecta.'])
                ->with('error_password', 'La contraseña actual ingresada es incorrecta.');
        }

        DB::table('usuarios')
            ->where('id_usuario', $userId)
            ->update([
                'password' => Hash::make($request->password),
            ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '¡Tu contraseña ha sido modificada con éxito!',
                'detail' => 'Tu clave de acceso ha sido actualizada correctamente en el sistema. Tu cuenta ahora se encuentra protegida con tu nueva clave de acceso.',
            ]);
        }

        return redirect()->route('dashboard')
            ->with('password_updated_success', '¡Tu contraseña ha sido modificada con éxito! Tu cuenta ahora está protegida con tu nueva clave de acceso.');
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
