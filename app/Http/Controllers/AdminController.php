<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Admin Dashboard Main View
     */
    public function dashboard()
    {
        $totalUsuarios = DB::table('usuarios')->count();
        $totalClientes = DB::table('usuarios')->where('rol', 'cliente')->count();
        $totalAdmins = DB::table('usuarios')->where('rol', 'admin')->count();
        $totalMascotas = DB::table('mascotas')->count();
        $totalCategorias = DB::table('categorias')->count();
        $totalProductos = DB::table('productos')->count();
        $totalCitas = DB::table('citas')->count();
        $citasPendientes = DB::table('citas')->where('estado', 'Pendiente')->count();
        $citasConfirmadas = DB::table('citas')->where('estado', 'Confirmada')->count();

        // Recent appointments
        $citasRecientes = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select(
                'citas.*',
                'mascotas.nombre as mascota_nombre',
                'mascotas.especie',
                'usuarios.nombre as dueno_nombre'
            )
            ->orderBy('citas.fecha', 'desc')
            ->orderBy('citas.hora', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalClientes',
            'totalAdmins',
            'totalMascotas',
            'totalCategorias',
            'totalProductos',
            'totalCitas',
            'citasPendientes',
            'citasConfirmadas',
            'citasRecientes'
        ));
    }

    /* =========================================================================
     * GESTIÓN DE CITAS MÉDICAS
     * ========================================================================= */

    public function citasIndex(Request $request)
    {
        $estadoFilter = $request->query('estado');

        $query = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select(
                'citas.*',
                'mascotas.nombre as mascota_nombre',
                'mascotas.especie',
                'mascotas.raza',
                'usuarios.nombre as dueno_nombre',
                'usuarios.email as dueno_email'
            );

        if ($estadoFilter && in_array($estadoFilter, ['Pendiente', 'Confirmada', 'Finalizada', 'Cancelada'])) {
            $query->where('citas.estado', $estadoFilter);
        }

        $citas = $query->orderBy('citas.fecha', 'asc')
            ->orderBy('citas.hora', 'asc')
            ->get();

        $mascotas = DB::table('mascotas')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select('mascotas.*', 'usuarios.nombre as dueno_nombre')
            ->orderBy('mascotas.nombre', 'asc')
            ->get();

        return view('admin.citas', compact('citas', 'mascotas', 'estadoFilter'));
    }

    public function citasStore(Request $request)
    {
        $request->validate([
            'id_mascota' => 'required|exists:mascotas,id_mascota',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Confirmada,Finalizada,Cancelada',
        ]);

        DB::table('citas')->insert([
            'id_mascota' => $request->id_mascota,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'motivo' => trim($request->motivo),
            'estado' => $request->estado,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita médica agendada exitosamente.');
    }

    public function citasUpdate(Request $request, $id)
    {
        $request->validate([
            'id_mascota' => 'required|exists:mascotas,id_mascota',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Confirmada,Finalizada,Cancelada',
        ]);

        DB::table('citas')->where('id_cita', $id)->update([
            'id_mascota' => $request->id_mascota,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'motivo' => trim($request->motivo),
            'estado' => $request->estado,
        ]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita médica actualizada correctamente.');
    }

    public function citasUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Confirmada,Finalizada,Cancelada',
        ]);

        DB::table('citas')->where('id_cita', $id)->update([
            'estado' => $request->estado,
        ]);

        return redirect()->back()->with('success', 'Estado de la cita actualizado a '.$request->estado);
    }

    public function citasDestroy($id)
    {
        DB::table('citas')->where('id_cita', $id)->delete();

        return redirect()->route('admin.citas.index')->with('success', 'Cita médica eliminada.');
    }

    /* =========================================================================
     * GESTIÓN DE MASCOTAS
     * ========================================================================= */

    public function mascotasIndex()
    {
        $mascotas = DB::table('mascotas')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select('mascotas.*', 'usuarios.nombre as dueno_nombre', 'usuarios.email as dueno_email')
            ->orderBy('mascotas.id_mascota', 'desc')
            ->get();

        $usuarios = DB::table('usuarios')->orderBy('nombre', 'asc')->get();

        return view('admin.mascotas', compact('mascotas', 'usuarios'));
    }

    public function mascotasStore(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'peso' => 'nullable|numeric|min:0|max:999.99',
        ]);

        DB::table('mascotas')->insert([
            'id_usuario' => $request->id_usuario,
            'nombre' => trim($request->nombre),
            'especie' => trim($request->especie),
            'raza' => $request->raza ? trim($request->raza) : null,
            'peso' => $request->peso,
        ]);

        return redirect()->route('admin.mascotas.index')->with('success', 'Mascota registrada exitosamente.');
    }

    public function mascotasUpdate(Request $request, $id)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'peso' => 'nullable|numeric|min:0|max:999.99',
        ]);

        DB::table('mascotas')->where('id_mascota', $id)->update([
            'id_usuario' => $request->id_usuario,
            'nombre' => trim($request->nombre),
            'especie' => trim($request->especie),
            'raza' => $request->raza ? trim($request->raza) : null,
            'peso' => $request->peso,
        ]);

        return redirect()->route('admin.mascotas.index')->with('success', 'Datos de la mascota actualizados.');
    }

    public function mascotasDestroy($id)
    {
        DB::table('mascotas')->where('id_mascota', $id)->delete();

        return redirect()->route('admin.mascotas.index')->with('success', 'Mascota eliminada.');
    }

    /* =========================================================================
     * GESTIÓN DE USUARIOS
     * ========================================================================= */

    public function usuariosIndex()
    {
        $usuarios = DB::table('usuarios')
            ->select('usuarios.*')
            ->selectRaw('(SELECT COUNT(*) FROM mascotas WHERE mascotas.id_usuario = usuarios.id_usuario) as total_mascotas')
            ->orderBy('usuarios.id_usuario', 'desc')
            ->get();

        return view('admin.usuarios', compact('usuarios'));
    }

    public function usuariosStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:cliente,admin',
        ]);

        DB::table('usuarios')->insert([
            'nombre' => trim($request->nombre),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'fecha_registro' => now(),
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function usuariosUpdate(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email,'.$id.',id_usuario',
            'rol' => 'required|in:cliente,admin',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'nombre' => trim($request->nombre),
            'email' => strtolower(trim($request->email)),
            'rol' => $request->rol,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('usuarios')->where('id_usuario', $id)->update($updateData);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function usuariosDestroy($id)
    {
        if (session('user_id') == $id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario actual.');
        }

        DB::table('usuarios')->where('id_usuario', $id)->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado.');
    }

    /* =========================================================================
     * GESTIÓN DE PRODUCTOS Y CATEGORÍAS
     * ========================================================================= */

    public function productosIndex()
    {
        $productos = DB::table('productos')
            ->leftJoin('categorias', 'productos.id_categoria', '=', 'categorias.id_categoria')
            ->select('productos.*', 'categorias.nombre as categoria_nombre')
            ->orderBy('productos.id_producto', 'desc')
            ->get();

        $categorias = DB::table('categorias')
            ->select('categorias.*')
            ->selectRaw('(SELECT COUNT(*) FROM productos WHERE productos.id_categoria = categorias.id_categoria) as total_productos')
            ->orderBy('nombre', 'asc')
            ->get();

        return view('admin.productos', compact('productos', 'categorias'));
    }

    public function categoriasStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('categorias')->insert([
            'nombre' => trim($request->nombre),
            'descripcion' => $request->descripcion ? trim($request->descripcion) : null,
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function categoriasUpdate(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('categorias')->where('id_categoria', $id)->update([
            'nombre' => trim($request->nombre),
            'descripcion' => $request->descripcion ? trim($request->descripcion) : null,
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Categoría actualizada.');
    }

    public function categoriasDestroy($id)
    {
        DB::table('categorias')->where('id_categoria', $id)->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Categoría eliminada.');
    }

    public function productosStore(Request $request)
    {
        $request->validate([
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen_url' => 'nullable|string|max:255',
        ]);

        DB::table('productos')->insert([
            'id_categoria' => $request->id_categoria,
            'nombre' => trim($request->nombre),
            'descripcion' => $request->descripcion ? trim($request->descripcion) : null,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'imagen_url' => $request->imagen_url ? trim($request->imagen_url) : null,
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function productosUpdate(Request $request, $id)
    {
        $request->validate([
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen_url' => 'nullable|string|max:255',
        ]);

        DB::table('productos')->where('id_producto', $id)->update([
            'id_categoria' => $request->id_categoria,
            'nombre' => trim($request->nombre),
            'descripcion' => $request->descripcion ? trim($request->descripcion) : null,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'imagen_url' => $request->imagen_url ? trim($request->imagen_url) : null,
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function productosDestroy($id)
    {
        DB::table('productos')->where('id_producto', $id)->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado.');
    }
}
