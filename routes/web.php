<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// VISTA DE USUARIO / LANDING PAGE PÚBLICA (RF-02, RF-03, RF-04, RF-05)
// =========================================================================
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/landing', [LandingController::class, 'index'])->name('landing');
Route::post('/citas/agendar', [LandingController::class, 'agendarCita'])->name('citas.agendar');
Route::get('/api/citas-semana', [LandingController::class, 'citasSemana'])->name('citas.semana');
Route::get('/api/citas/disponibilidad', [LandingController::class, 'consultarDisponibilidad'])->name('citas.disponibilidad');
Route::get('/api/servicios', [LandingController::class, 'serviciosApi'])->name('servicios.api');
Route::get('/api/profesionales', [LandingController::class, 'profesionalesApi'])->name('profesionales.api');

// =========================================================================
// AUTENTICACIÓN Y ACCESO (Clientes, Recepción y Administradores)
// =========================================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Registro de usuarios
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Recuperación y cambio de contraseña
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Panel General (Clientes) y Agendamiento de Clientes Registrados (R-30)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/dashboard/mascota', [AuthController::class, 'registerPet'])->name('mascota.store');
Route::post('/citas/agendar-cliente', [AuthController::class, 'agendarCitaCliente'])->name('citas.agendar.cliente');
Route::get('/citas/{id}/comprobante', [AuthController::class, 'descargarComprobante'])->name('citas.comprobante');
Route::match(['put', 'post'], '/dashboard/perfil/password', [AuthController::class, 'updatePassword'])->name('perfil.password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// RUTAS DEL APARTADO DE ADMINISTRACIÓN Y RECEPCIÓN (R-33, R-34)
// =========================================================================
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Citas Médicas y Agendamiento Presencial/Telefónico (R-32, R-33)
    Route::get('/citas', [AdminController::class, 'citasIndex'])->name('citas.index');
    Route::get('/citas/reporte-dia', [AdminController::class, 'citasReporteDia'])->name('citas.reporte-dia');
    Route::post('/citas', [AdminController::class, 'citasStore'])->name('citas.store');
    Route::post('/citas/presencial', [AdminController::class, 'citasPresencialStore'])->name('citas.presencial.store');
    Route::put('/citas/{id}', [AdminController::class, 'citasUpdate'])->name('citas.update');
    Route::patch('/citas/{id}/estado', [AdminController::class, 'citasUpdateStatus'])->name('citas.status');
    Route::delete('/citas/{id}', [AdminController::class, 'citasDestroy'])->name('citas.destroy');

    // Configuración de Horarios, Recesos, Días No Laborables y Bloqueos (R-34)
    Route::get('/horarios', [AdminController::class, 'horariosIndex'])->name('horarios.index');
    Route::post('/horarios/atencion', [AdminController::class, 'horariosAtencionUpdate'])->name('horarios.atencion.update');
    Route::post('/horarios/recesos', [AdminController::class, 'recesosStore'])->name('horarios.recesos.store');
    Route::delete('/horarios/recesos/{id}', [AdminController::class, 'recesosDestroy'])->name('horarios.recesos.destroy');
    Route::post('/horarios/dias-no-laborables', [AdminController::class, 'diasNoLaborablesStore'])->name('horarios.dias.store');
    Route::delete('/horarios/dias-no-laborables/{id}', [AdminController::class, 'diasNoLaborablesDestroy'])->name('horarios.dias.destroy');
    Route::post('/horarios/bloqueos-personal', [AdminController::class, 'bloqueosPersonalStore'])->name('horarios.bloqueos.store');
    Route::delete('/horarios/bloqueos-personal/{id}', [AdminController::class, 'bloqueosPersonalDestroy'])->name('horarios.bloqueos.destroy');

    // Catálogo y Precios de Servicios
    Route::get('/servicios', [AdminController::class, 'serviciosIndex'])->name('servicios.index');
    Route::post('/servicios', [AdminController::class, 'serviciosStore'])->name('servicios.store');
    Route::put('/servicios/{id}', [AdminController::class, 'serviciosUpdate'])->name('servicios.update');
    Route::post('/servicios/{id}/toggle', [AdminController::class, 'serviciosToggle'])->name('servicios.toggle');

    // Mascotas
    Route::get('/mascotas', [AdminController::class, 'mascotasIndex'])->name('mascotas.index');
    Route::post('/mascotas', [AdminController::class, 'mascotasStore'])->name('mascotas.store');
    Route::put('/mascotas/{id}', [AdminController::class, 'mascotasUpdate'])->name('mascotas.update');
    Route::delete('/mascotas/{id}', [AdminController::class, 'mascotasDestroy'])->name('mascotas.destroy');
    Route::post('/mascotas/{id}/asignar-dueno', [AdminController::class, 'asignarDueno'])->name('mascotas.asignar-dueno');
    Route::post('/mascotas/{id}/quitar-dueno', [AdminController::class, 'quitarDueno'])->name('mascotas.quitar-dueno');
    Route::get('/mascotas/{id}/historial', [AdminController::class, 'mascotasHistorial'])->name('mascotas.historial');

    // Usuarios
    Route::get('/usuarios', [AdminController::class, 'usuariosIndex'])->name('usuarios.index');
    Route::post('/usuarios', [AdminController::class, 'usuariosStore'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [AdminController::class, 'usuariosUpdate'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [AdminController::class, 'usuariosDestroy'])->name('usuarios.destroy');

    // Productos y Categorías
    Route::get('/productos', [AdminController::class, 'productosIndex'])->name('productos.index');
    Route::get('/productos/reporte-pdf', [AdminController::class, 'productosPdf'])->name('productos.pdf');
    Route::get('/categorias/reporte-pdf', [AdminController::class, 'categoriasPdf'])->name('categorias.pdf');
    Route::post('/productos', [AdminController::class, 'productosStore'])->name('productos.store');
    Route::put('/productos/{id}', [AdminController::class, 'productosUpdate'])->name('productos.update');
    Route::delete('/productos/{id}', [AdminController::class, 'productosDestroy'])->name('productos.destroy');

    Route::post('/categorias', [AdminController::class, 'categoriasStore'])->name('categorias.store');
    Route::put('/categorias/{id}', [AdminController::class, 'categoriasUpdate'])->name('categorias.update');
    Route::delete('/categorias/{id}', [AdminController::class, 'categoriasDestroy'])->name('categorias.destroy');
});
