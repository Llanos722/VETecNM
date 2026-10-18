<?php

namespace App\Http\Controllers;

use App\Services\CitaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

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
     * GESTIÓN DE CITAS MÉDICAS & AGENDAMIENTO PRESENCIAL (R-30, R-31, R-32, R-33)
     * ========================================================================= */

    public function citasIndex(Request $request)
    {
        $estadoFilter = $request->query('estado');
        $fechaFilter = $request->query('fecha');

        $query = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select(
                'citas.*',
                'mascotas.nombre as mascota_nombre',
                'mascotas.especie',
                'mascotas.raza',
                'usuarios.nombre as dueno_nombre',
                'usuarios.email as dueno_email',
                'usuarios.telefono as dueno_telefono'
            );

        if ($estadoFilter && in_array($estadoFilter, ['Pendiente', 'Confirmada', 'Finalizada', 'Cancelada'])) {
            $query->where('citas.estado', $estadoFilter);
        }

        if ($fechaFilter) {
            $query->where('citas.fecha', $fechaFilter);
        }

        $citas = $query->orderBy('citas.fecha', 'asc')
            ->orderBy('citas.hora', 'asc')
            ->get();

        $mascotas = DB::table('mascotas')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select('mascotas.*', 'usuarios.nombre as dueno_nombre', 'usuarios.email as dueno_email', 'usuarios.telefono as dueno_telefono')
            ->orderBy('mascotas.nombre', 'asc')
            ->get();

        $clientes = DB::table('usuarios')
            ->whereIn('rol', ['cliente'])
            ->orderBy('nombre', 'asc')
            ->get();

        $profesionales = CitaService::getProfesionales();

        $serviciosPorCategoria = CitaService::getServiciosPorCategoria();
        $serviciosLista = CitaService::getServicios();
        $serviciosDisponibles = [];
        foreach ($serviciosPorCategoria as $catName => $items) {
            $serviciosDisponibles[$catName] = array_column($items, 'nombre');
        }

        return view('admin.citas', compact(
            'citas',
            'mascotas',
            'clientes',
            'profesionales',
            'serviciosDisponibles',
            'serviciosPorCategoria',
            'serviciosLista',
            'estadoFilter',
            'fechaFilter'
        ));
    }

    public function citasStore(Request $request)
    {
        $request->validate([
            'id_mascota' => 'required|exists:mascotas,id_mascota',
            'fecha' => 'required|date',
            'hora' => 'required',
            'servicio' => 'nullable|string|max:150',
            'precio' => 'nullable|numeric|min:0',
            'profesional' => 'nullable|string|max:150',
            'canal' => 'nullable|in:web,presencial,telefono',
            'motivo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Confirmada,Finalizada,Cancelada',
        ]);

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

        // 2. VALIDACIÓN DE DISPONIBILIDAD DEL TRABAJADOR (R-32): Evitar citas simultáneas
        $profesional = $request->filled('profesional') ? trim($request->profesional) : null;
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
        try {
            CitaService::validarDuplicado((int) $request->id_mascota, $request->fecha, $request->hora, trim($request->motivo), $request->servicio);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('alerta_error_general', $e->validator->errors()->first('duplicado'));
        }

        $horaFormateada = strlen($request->hora) === 5 ? $request->hora.':00' : $request->hora;
        $precio = $request->filled('precio') ? (float) $request->precio : CitaService::getPrecioServicio($request->servicio);

        DB::table('citas')->insert([
            'id_mascota' => $request->id_mascota,
            'fecha' => $request->fecha,
            'hora' => $horaFormateada,
            'servicio' => $request->servicio ? trim($request->servicio) : null,
            'precio' => $precio,
            'profesional' => $profesional,
            'canal' => $request->canal ?? 'presencial',
            'motivo' => trim($request->motivo),
            'estado' => $request->estado,
            'notas' => $request->notas ? trim($request->notas) : null,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita médica agendada exitosamente.');
    }

    /**
     * Agendamiento presencial o telefónico por Recepcionista (R-33, R-31, R-32).
     */
    public function citasPresencialStore(Request $request)
    {
        $request->validate([
            'canal' => 'required|in:presencial,telefono',
            'servicio' => 'required|string|max:150',
            'precio' => 'nullable|numeric|min:0',
            'profesional' => 'required|string|max:150',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
            'notas' => 'nullable|string|max:500',
        ]);

        // Determinar o registrar cliente
        $userId = null;
        if ($request->filled('id_usuario')) {
            $userId = (int) $request->id_usuario;
        } else {
            // Registro rápido de cliente en ventanilla o llamada
            $request->validate([
                'cliente_nombre' => 'required|string|max:100',
                'cliente_telefono' => 'required|string|max:20',
            ]);

            $clienteEmail = $request->filled('cliente_email')
                ? strtolower(trim($request->cliente_email))
                : 'cliente_'.time().'@vetecnm.local';

            $userExistente = DB::table('usuarios')->where('telefono', trim($request->cliente_telefono))->first();

            if ($userExistente) {
                $userId = $userExistente->id_usuario;
            } else {
                $userId = DB::table('usuarios')->insertGetId([
                    'nombre' => trim($request->cliente_nombre),
                    'email' => $clienteEmail,
                    'telefono' => trim($request->cliente_telefono),
                    'password' => Hash::make('cliente_'.time()),
                    'rol' => 'cliente',
                    'fecha_registro' => now(),
                ]);
            }
        }

        // Determinar o registrar mascota
        $mascotaId = null;
        if ($request->filled('id_mascota')) {
            $mascotaId = (int) $request->id_mascota;
        } else {
            $request->validate([
                'mascota_nombre' => 'required|string|max:100',
                'mascota_especie' => 'required|string|max:50',
            ]);

            $mascotaId = DB::table('mascotas')->insertGetId([
                'id_usuario' => $userId,
                'nombre' => trim($request->mascota_nombre),
                'especie' => trim($request->mascota_especie),
                'raza' => $request->filled('mascota_raza') ? trim($request->mascota_raza) : null,
            ]);
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

        // 2. VALIDACIÓN DE DISPONIBILIDAD DEL TRABAJADOR (R-32): Evitar citas simultáneas
        $profesional = trim($request->profesional);
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
        try {
            CitaService::validarDuplicado($mascotaId, $request->fecha, $request->hora, trim($request->motivo), $request->servicio);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('alerta_error_general', $e->validator->errors()->first('duplicado'));
        }

        $userObj = DB::table('usuarios')->where('id_usuario', $userId)->first();
        $horaFormateada = strlen($request->hora) === 5 ? $request->hora.':00' : $request->hora;
        $precio = $request->filled('precio') ? (float) $request->precio : CitaService::getPrecioServicio($request->servicio);

        DB::table('citas')->insert([
            'id_mascota' => $mascotaId,
            'fecha' => $request->fecha,
            'hora' => $horaFormateada,
            'servicio' => trim($request->servicio),
            'precio' => $precio,
            'profesional' => $profesional,
            'canal' => $request->canal,
            'telefono_contacto' => $userObj->telefono ?? null,
            'motivo' => trim($request->motivo),
            'estado' => 'Confirmada', // En recepción se marca directamente como confirmada
            'notas' => $request->notas ? trim($request->notas) : null,
            'fecha_creacion' => now(),
        ]);

        $canalTexto = $request->canal === 'presencial' ? 'en ventanilla' : 'por teléfono';

        return redirect()->route('admin.citas.index')->with('success', "Cita solicitada {$canalTexto} registrada exitosamente.");
    }

    public function citasUpdate(Request $request, $id)
    {
        // Protect finalized/cancelled appointments from being modified
        $citaActual = DB::table('citas')->where('id_cita', $id)->first();
        if ($citaActual && in_array($citaActual->estado, ['Finalizada', 'Cancelada'])) {
            return redirect()->back()->with('alerta_error_general', 'Las citas Finalizadas o Canceladas no pueden ser modificadas.');
        }

        $request->validate([
            'id_mascota' => 'required|exists:mascotas,id_mascota',
            'fecha' => 'required|date',
            'hora' => 'required',
            'servicio' => 'nullable|string|max:150',
            'precio' => 'nullable|numeric|min:0',
            'profesional' => 'nullable|string|max:150',
            'canal' => 'nullable|in:web,presencial,telefono',
            'motivo' => 'required|string|max:255',
            'estado' => 'required|in:Pendiente,Confirmada,Finalizada,Cancelada',
        ]);

        // 1. RESTRICCIÓN DE TIEMPO
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

        // 2. VALIDACIÓN DE DISPONIBILIDAD DEL TRABAJADOR (excluyendo la cita actual)
        $profesional = $request->filled('profesional') ? trim($request->profesional) : null;
        $dispTrabajador = CitaService::verificarDisponibilidadTrabajador($profesional, $request->fecha, $request->hora, (int) $id);
        if (! $dispTrabajador['disponible']) {
            return redirect()->back()
                ->withInput()
                ->with('horario_no_disponible_alerta', [
                    'mensaje' => 'El horario ya no se encuentra disponible.',
                    'detalle' => $dispTrabajador['mensaje'] ?? 'El profesional ya tiene una cita asignada en ese horario.',
                ]);
        }

        // 3. RESTRICCIÓN DE DUPLICADOS (excluyendo la cita actual)
        try {
            CitaService::validarDuplicado((int) $request->id_mascota, $request->fecha, $request->hora, trim($request->motivo), $request->servicio, (int) $id);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('alerta_error_general', $e->validator->errors()->first('duplicado'));
        }

        $horaFormateada = strlen($request->hora) === 5 ? $request->hora.':00' : $request->hora;
        $precio = $request->filled('precio') ? (float) $request->precio : CitaService::getPrecioServicio($request->servicio);

        DB::table('citas')->where('id_cita', $id)->update([
            'id_mascota' => $request->id_mascota,
            'fecha' => $request->fecha,
            'hora' => $horaFormateada,
            'servicio' => $request->servicio ? trim($request->servicio) : null,
            'precio' => $precio,
            'profesional' => $profesional,
            'canal' => $request->canal ?? 'presencial',
            'motivo' => trim($request->motivo),
            'estado' => $request->estado,
            'notas' => $request->notas ? trim($request->notas) : null,
        ]);

        return redirect()->route('admin.citas.index')->with('success', 'Cita médica actualizada correctamente.');
    }

    public function citasUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Confirmada,Finalizada,Cancelada',
        ]);

        // Protect finalized/cancelled appointments from status changes
        $citaActual = DB::table('citas')->where('id_cita', $id)->first();
        if ($citaActual && in_array($citaActual->estado, ['Finalizada', 'Cancelada'])) {
            return redirect()->back()->with('alerta_error_general', 'Las citas Finalizadas o Canceladas no pueden modificar su estado.');
        }

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

    /**
     * Reporte de citas por día — abre en pestaña nueva para imprimir/PDF.
     */
    public function citasReporteDia(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $fecha = $request->input('fecha');

        $citas = DB::table('citas')
            ->join('mascotas', 'citas.id_mascota', '=', 'mascotas.id_mascota')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select(
                'citas.*',
                'mascotas.nombre as mascota_nombre',
                'mascotas.especie',
                'mascotas.raza',
                'usuarios.nombre as dueno_nombre',
                'usuarios.email as dueno_email',
                'usuarios.telefono as dueno_telefono'
            )
            ->where('citas.fecha', $fecha)
            ->orderBy('citas.hora', 'asc')
            ->get();

        return view('admin.reporte-dia-citas', compact('citas', 'fecha'));
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

        // Check for duplicate pet (same owner, name, species, raza and peso)
        $duplicateQuery = DB::table('mascotas')
            ->where('id_usuario', $request->id_usuario)
            ->where('nombre', trim($request->nombre))
            ->where('especie', trim($request->especie));
        if (!empty($request->raza)) {
            $duplicateQuery->where('raza', trim($request->raza));
        } else {
            $duplicateQuery->whereNull('raza');
        }
        if (!empty($request->peso)) {
            $duplicateQuery->where('peso', $request->peso);
        } else {
            $duplicateQuery->whereNull('peso');
        }
        if ($duplicateQuery->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Esta mascota ya está registrada.');
        }

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

    /**
     * Historial clínico de una mascota: lista todas sus citas con detalles.
     */
    public function mascotasHistorial($id)
    {
        $mascota = DB::table('mascotas')
            ->join('usuarios', 'mascotas.id_usuario', '=', 'usuarios.id_usuario')
            ->select(
                'mascotas.*',
                'usuarios.nombre as dueno_nombre',
                'usuarios.email as dueno_email',
                'usuarios.telefono as dueno_telefono'
            )
            ->where('mascotas.id_mascota', $id)
            ->first();

        if (! $mascota) {
            return redirect()->route('admin.mascotas.index')->with('error', 'Mascota no encontrada.');
        }

        $citas = DB::table('citas')
            ->where('id_mascota', $id)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return view('admin.historial-mascota', compact('mascota', 'citas'));
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
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:cliente,admin,recepcionista',
        ]);

        $userData = [
            'nombre' => trim($request->nombre),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'fecha_registro' => now(),
        ];

        if ($request->filled('telefono') && Schema::hasColumn('usuarios', 'telefono')) {
            $userData['telefono'] = trim($request->telefono);
        }

        DB::table('usuarios')->insert($userData);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function usuariosUpdate(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email,'.$id.',id_usuario',
            'telefono' => 'nullable|string|max:20',
            'rol' => 'required|in:cliente,admin,recepcionista',
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'nombre' => trim($request->nombre),
            'email' => strtolower(trim($request->email)),
            'rol' => $request->rol,
        ];

        if ($request->has('telefono') && Schema::hasColumn('usuarios', 'telefono')) {
            $updateData['telefono'] = $request->filled('telefono') ? trim($request->telefono) : null;
        }

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

    /**
     * Reporte formal descargable en PDF de Productos organizados por categoría.
     */
    public function productosPdf(Request $request)
    {
        $categoriaId = $request->query('categoria_id');

        $catQuery = DB::table('categorias');
        if ($categoriaId && $categoriaId !== 'todas') {
            $catQuery->where('id_categoria', $categoriaId);
        }
        $categorias = $catQuery->orderBy('nombre', 'asc')->get();

        $totalProductos = 0;
        $totalStock = 0;
        $valorTotalInventario = 0;

        foreach ($categorias as $cat) {
            $prods = DB::table('productos')
                ->where('id_categoria', $cat->id_categoria)
                ->orderBy('nombre', 'asc')
                ->get();

            $cat->productos = $prods;
            $cat->total_prods = $prods->count();
            $cat->total_stock = $prods->sum('stock');
            $cat->subtotal_valor = $prods->sum(function ($p) {
                return (float) $p->precio * (int) $p->stock;
            });

            $totalProductos += $cat->total_prods;
            $totalStock += $cat->total_stock;
            $valorTotalInventario += $cat->subtotal_valor;
        }

        // Productos sin categoría si se seleccionan todas
        $productosSinCategoria = collect();
        if (! $categoriaId || $categoriaId === 'todas') {
            $productosSinCategoria = DB::table('productos')
                ->whereNull('id_categoria')
                ->orderBy('nombre', 'asc')
                ->get();

            $totalProductos += $productosSinCategoria->count();
            $totalStock += $productosSinCategoria->sum('stock');
            $valorTotalInventario += $productosSinCategoria->sum(function ($p) {
                return (float) $p->precio * (int) $p->stock;
            });
        }

        $categoriaSeleccionada = ($categoriaId && $categoriaId !== 'todas')
            ? $categorias->first()
            : null;

        $todasCategorias = DB::table('categorias')->orderBy('nombre', 'asc')->get();

        return view('admin.reporte-productos-pdf', compact(
            'categorias',
            'productosSinCategoria',
            'totalProductos',
            'totalStock',
            'valorTotalInventario',
            'categoriaSeleccionada',
            'todasCategorias',
            'categoriaId'
        ));
    }

    /**
     * Reporte formal descargable en PDF de Categorías de Productos.
     */
    public function categoriasPdf()
    {
        $categorias = DB::table('categorias')
            ->select('categorias.*')
            ->selectRaw('(SELECT COUNT(*) FROM productos WHERE productos.id_categoria = categorias.id_categoria) as total_productos')
            ->selectRaw('(SELECT COALESCE(SUM(stock), 0) FROM productos WHERE productos.id_categoria = categorias.id_categoria) as total_stock')
            ->orderBy('nombre', 'asc')
            ->get();

        $totalCategorias = $categorias->count();
        $totalProductos = DB::table('productos')->count();
        $totalStock = DB::table('productos')->sum('stock');

        return view('admin.reporte-categorias-pdf', compact(
            'categorias',
            'totalCategorias',
            'totalProductos',
            'totalStock'
        ));
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

    /* =========================================================================
     * CONFIGURACIÓN DE HORARIOS, RECESOS, DÍAS NO LABORABLES Y BLOQUEOS (R-34)
     * ========================================================================= */

    public function horariosIndex()
    {
        $horarios = DB::table('configuracion_horarios')
            ->orderBy('dia_semana', 'asc')
            ->get();

        $recesos = DB::table('horarios_recesos')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        $diasNoLaborables = DB::table('dias_no_laborables')
            ->orderBy('fecha', 'asc')
            ->get();

        $bloqueos = DB::table('bloqueos_personal')
            ->orderBy('fecha', 'desc')
            ->get();

        $profesionales = CitaService::getProfesionales();

        return view('admin.horarios', compact(
            'horarios',
            'recesos',
            'diasNoLaborables',
            'bloqueos',
            'profesionales'
        ));
    }

    public function horariosAtencionUpdate(Request $request)
    {
        $request->validate([
            'horarios' => 'required|array',
            'horarios.*.id' => 'required|exists:configuracion_horarios,id',
            'horarios.*.hora_apertura' => 'required',
            'horarios.*.hora_cierre' => 'required',
            'horarios.*.intervalo_minutos' => 'required|integer|min:15|max:120',
        ]);

        foreach ($request->horarios as $item) {
            DB::table('configuracion_horarios')
                ->where('id', $item['id'])
                ->update([
                    'hora_apertura' => $item['hora_apertura'],
                    'hora_cierre' => $item['hora_cierre'],
                    'intervalo_minutos' => (int) $item['intervalo_minutos'],
                    'activo' => isset($item['activo']) ? true : false,
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('admin.horarios.index')->with('success', 'Horarios de atención de la clínica actualizados correctamente.');
    }

    public function recesosStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'aplica_a' => 'required|string|max:150',
        ]);

        DB::table('horarios_recesos')->insert([
            'nombre' => trim($request->nombre),
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'aplica_a' => trim($request->aplica_a),
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.horarios.index')->with('success', 'Receso laboral registrado exitosamente.');
    }

    public function recesosDestroy($id)
    {
        DB::table('horarios_recesos')->where('id', $id)->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Receso eliminado.');
    }

    public function diasNoLaborablesStore(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'motivo' => 'required|string|max:255',
        ]);

        DB::table('dias_no_laborables')->insert([
            'fecha' => $request->fecha,
            'motivo' => trim($request->motivo),
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.horarios.index')->with('success', 'Día no laborable registrado exitosamente.');
    }

    public function diasNoLaborablesDestroy($id)
    {
        DB::table('dias_no_laborables')->where('id', $id)->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Día no laborable eliminado.');
    }

    public function bloqueosPersonalStore(Request $request)
    {
        $request->validate([
            'profesional' => 'required|string|max:150',
            'fecha' => 'required|date',
            'tipo_bloqueo' => 'required|in:completo,parcial',
            'hora_inicio' => 'nullable|required_if:tipo_bloqueo,parcial',
            'hora_fin' => 'nullable|required_if:tipo_bloqueo,parcial',
            'motivo' => 'required|string|max:255',
        ]);

        $horaInicio = $request->tipo_bloqueo === 'parcial' ? $request->hora_inicio : null;
        $horaFin = $request->tipo_bloqueo === 'parcial' ? $request->hora_fin : null;

        DB::table('bloqueos_personal')->insert([
            'profesional' => trim($request->profesional),
            'fecha' => $request->fecha,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'motivo' => trim($request->motivo),
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.horarios.index')->with('success', 'Bloqueo de disponibilidad del personal registrado.');
    }

    public function bloqueosPersonalDestroy($id)
    {
        DB::table('bloqueos_personal')->where('id', $id)->delete();

        return redirect()->route('admin.horarios.index')->with('success', 'Bloqueo de personal eliminado.');
    }

    /**
     * =========================================================================
     * CATÁLOGO Y PRECIOS POR SERVICIO
     * =========================================================================
     */
    public function serviciosIndex()
    {
        $servicios = DB::table('servicios')->orderBy('categoria')->orderBy('nombre')->get();
        $categorias = DB::table('servicios')->select('categoria')->distinct()->pluck('categoria');

        return view('admin.servicios', compact('servicios', 'categorias'));
    }

    public function serviciosStore(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string|max:100',
            'nombre' => 'required|string|max:150|unique:servicios,nombre',
            'precio' => 'required|numeric|min:0',
            'precio_texto' => 'nullable|string|max:100',
            'duracion' => 'nullable|string|max:50',
            'incluye' => 'nullable|string|max:500',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $precioTexto = $request->precio_texto ?: ('$'.number_format($request->precio, 2).' MXN');

        DB::table('servicios')->insert([
            'categoria' => trim($request->categoria),
            'nombre' => trim($request->nombre),
            'precio' => $request->precio,
            'precio_texto' => $precioTexto,
            'duracion' => $request->duracion ? trim($request->duracion) : '30 min',
            'incluye' => $request->incluye ? trim($request->incluye) : null,
            'descripcion' => $request->descripcion ? trim($request->descripcion) : null,
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio registrado exitosamente.');
    }

    public function serviciosUpdate(Request $request, $id)
    {
        $request->validate([
            'categoria' => 'required|string|max:100',
            'nombre' => 'required|string|max:150|unique:servicios,nombre,'.$id.',id_servicio',
            'precio' => 'required|numeric|min:0',
            'precio_texto' => 'nullable|string|max:100',
            'duracion' => 'nullable|string|max:50',
            'incluye' => 'nullable|string|max:500',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $precioTexto = $request->precio_texto ?: ('$'.number_format($request->precio, 2).' MXN');

        DB::table('servicios')->where('id_servicio', $id)->update([
            'categoria' => trim($request->categoria),
            'nombre' => trim($request->nombre),
            'precio' => $request->precio,
            'precio_texto' => $precioTexto,
            'duracion' => $request->duracion ? trim($request->duracion) : null,
            'incluye' => $request->incluye ? trim($request->incluye) : null,
            'descripcion' => $request->descripcion ? trim($request->descripcion) : null,
            'activo' => $request->has('activo') ? (bool) $request->activo : true,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.servicios.index')->with('success', 'Precio y detalles del servicio actualizados exitosamente.');
    }

    public function serviciosToggle($id)
    {
        $srv = DB::table('servicios')->where('id_servicio', $id)->first();
        if ($srv) {
            DB::table('servicios')->where('id_servicio', $id)->update([
                'activo' => ! $srv->activo,
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.servicios.index')->with('success', 'Estado de disponibilidad del servicio actualizado.');
    }
}
