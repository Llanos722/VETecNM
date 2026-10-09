<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas del proyecto VETecNM
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Registro de usuarios
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Recuperación y cambio de contraseña
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Panel General (Clientes y Admins)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// RUTAS DEL APARTADO DE ADMINISTRACIÓN
// =========================================================================
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Citas Médicas
    Route::get('/citas', [AdminController::class, 'citasIndex'])->name('citas.index');
    Route::post('/citas', [AdminController::class, 'citasStore'])->name('citas.store');
    Route::put('/citas/{id}', [AdminController::class, 'citasUpdate'])->name('citas.update');
    Route::patch('/citas/{id}/estado', [AdminController::class, 'citasUpdateStatus'])->name('citas.status');
    Route::delete('/citas/{id}', [AdminController::class, 'citasDestroy'])->name('citas.destroy');

    // Mascotas
    Route::get('/mascotas', [AdminController::class, 'mascotasIndex'])->name('mascotas.index');
    Route::post('/mascotas', [AdminController::class, 'mascotasStore'])->name('mascotas.store');
    Route::put('/mascotas/{id}', [AdminController::class, 'mascotasUpdate'])->name('mascotas.update');
    Route::delete('/mascotas/{id}', [AdminController::class, 'mascotasDestroy'])->name('mascotas.destroy');

    // Usuarios
    Route::get('/usuarios', [AdminController::class, 'usuariosIndex'])->name('usuarios.index');
    Route::post('/usuarios', [AdminController::class, 'usuariosStore'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [AdminController::class, 'usuariosUpdate'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [AdminController::class, 'usuariosDestroy'])->name('usuarios.destroy');

    // Productos y Categorías
    Route::get('/productos', [AdminController::class, 'productosIndex'])->name('productos.index');
    Route::post('/productos', [AdminController::class, 'productosStore'])->name('productos.store');
    Route::put('/productos/{id}', [AdminController::class, 'productosUpdate'])->name('productos.update');
    Route::delete('/productos/{id}', [AdminController::class, 'productosDestroy'])->name('productos.destroy');

    Route::post('/categorias', [AdminController::class, 'categoriasStore'])->name('categorias.store');
    Route::put('/categorias/{id}', [AdminController::class, 'categoriasUpdate'])->name('categorias.update');
    Route::delete('/categorias/{id}', [AdminController::class, 'categoriasDestroy'])->name('categorias.destroy');
});
