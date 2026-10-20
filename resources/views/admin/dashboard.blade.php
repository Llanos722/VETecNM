@extends('layouts.admin')

@section('title', 'VETecNM - Panel de Control Admin')
@section('header_title', 'Dashboard de Administración')

@section('content')
<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-box" style="background: white;">
        <div class="stat-icon" style="background: #2563eb;"><i class="fa-solid fa-calendar-check"></i></div>
        <div class="stat-info">
            <h3>{{ $totalCitas }}</h3>
            <p>Citas Totales ({{ $citasPendientes }} Pendientes)</p>
        </div>
    </div>
    <div class="stat-box" style="background: white;">
        <div class="stat-icon" style="background: #059669;"><i class="fa-solid fa-paw"></i></div>
        <div class="stat-info">
            <h3>{{ $totalMascotas }}</h3>
            <p>Mascotas Registradas</p>
        </div>
    </div>
    <div class="stat-box" style="background: white;">
        <div class="stat-icon" style="background: #d97706;"><i class="fa-solid fa-users"></i></div>
        <div class="stat-info">
            <h3>{{ $totalUsuarios }}</h3>
            <p>Usuarios ({{ $totalClientes }} Clientes, {{ $totalAdmins }} Admins)</p>
        </div>
    </div>
    <div class="stat-box" style="background: white;">
        <div class="stat-icon" style="background: #7c3aed;"><i class="fa-solid fa-boxes-packing"></i></div>
        <div class="stat-info">
            <h3>{{ $totalProductos }}</h3>
            <p>Productos en {{ $totalCategorias }} Categorías</p>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-flex">
        <h3><i class="fa-solid fa-clock-rotate-left"></i> Citas Médicas Recientes</h3>
        <a href="{{ route('admin.citas.index') }}" class="btn-action btn-add" style="font-size: 0.82rem; padding: 6px 12px;">
            Ver Todas las Citas <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID Cita</th>
                    <th>Mascota</th>
                    <th>Dueño</th>
                    <th>Fecha & Hora</th>
                    <th>Motivo & Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citasRecientes as $c)
                    <tr>
                        <td><strong>#{{ $c->id_cita }}</strong></td>
                        <td><i class="fa-solid fa-paw" style="color: #64748b;"></i> <strong>{{ $c->mascota_nombre }}</strong> ({{ $c->especie }})</td>
                        <td>{{ $c->dueno_nombre }}</td>
                        <td><i class="fa-regular fa-calendar"></i> {{ $c->fecha }} a las {{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}</td>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;">{{ $c->motivo }}</div>
                            <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.76rem; font-weight: 700; color: #059669; margin-top: 3px;">
                                <i class="fa-solid fa-tag"></i> ${{ number_format($c->precio ?? \App\Services\CitaService::getPrecioServicio($c->servicio), 2) }} MXN
                            </span>
                        </td>
                        <td><span class="status-badge status-{{ $c->estado }}">{{ $c->estado }}</span></td>
                        <td>
                            <form action="{{ route('admin.citas.status', $c->id_cita) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                @if($c->estado === 'Pendiente')
                                    <input type="hidden" name="estado" value="Confirmada">
                                    <button type="submit" class="btn-action btn-edit" title="Confirmar Cita"><i class="fa-solid fa-check"></i> Confirmar</button>
                                @elseif($c->estado === 'Confirmada')
                                    <input type="hidden" name="estado" value="Finalizada">
                                    <button type="submit" class="btn-action btn-add" style="background:#059669; padding:4px 8px; font-size:0.75rem;" title="Finalizar Cita"><i class="fa-solid fa-flag-checkered"></i> Finalizar</button>
                                @else
                                    <span style="font-size: 0.8rem; color: #94a3b8;">Sin acciones</span>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2rem;">No hay citas registradas en el sistema.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-flex">
        <div>
            <h3><i class="fa-solid fa-boxes-packing" style="color: #2563eb;"></i> Productos y Artículos en Inventario</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Artículos registrados en catálogo con stock y precio actual.</span>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn-action btn-add" style="font-size: 0.82rem; padding: 6px 12px; background: #2563eb;">
            Ver Catálogo Completo <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productosRecientes as $p)
                    <tr>
                        <td><strong>#{{ $p->id_producto }}</strong></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 28px; height: 28px; border-radius: 6px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 0.85rem;">
                                    <i class="fa-solid fa-box"></i>
                                </div>
                                <strong style="color: #0f172a;">{{ $p->nombre }}</strong>
                            </div>
                        </td>
                        <td>
                            @if($p->categoria_nombre)
                                <span class="status-badge" style="background: #f3e8ff; color: #7c3aed; border: 1px solid #d8b4fe;">
                                    <i class="fa-solid fa-tag"></i> {{ $p->categoria_nombre }}
                                </span>
                            @else
                                <span style="color: #94a3b8; font-style: italic;">Sin Categoría</span>
                            @endif
                        </td>
                        <td><strong style="color: #059669; font-size: 0.95rem;">${{ number_format($p->precio, 2) }} MXN</strong></td>
                        <td>
                            @if($p->stock > 5)
                                <span class="status-badge status-Confirmada">{{ $p->stock }} unidades</span>
                            @elseif($p->stock > 0)
                                <span class="status-badge status-Pendiente">{{ $p->stock }} unidades (Bajo)</span>
                            @else
                                <span class="status-badge status-Cancelada">Agotado (0)</span>
                            @endif
                        </td>
                        <td style="max-width: 260px; white-space: normal; color: #475569; font-size: 0.85rem;">
                            {{ $p->descripcion ? Str::limit($p->descripcion, 65) : 'Sin detalles' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 2rem;">No hay productos registrados en el inventario.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card-custom">
    <h3><i class="fa-solid fa-bolt"></i> Acceso Rápido a Módulos Administrativos</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-top: 1rem;">
        <a href="{{ route('admin.citas.index') }}" class="card-custom" style="text-decoration:none; margin:0; display:flex; align-items:center; gap:15px; border-left: 4px solid #2563eb;">
            <i class="fa-solid fa-calendar-days" style="font-size: 2rem; color:#2563eb;"></i>
            <div>
                <strong style="color:#0f172a; display:block;">Gestionar Citas</strong>
                <span style="font-size:0.8rem; color:#64748b;">Agendar, aprobar o cancelar</span>
            </div>
        </a>
        <a href="{{ route('admin.mascotas.index') }}" class="card-custom" style="text-decoration:none; margin:0; display:flex; align-items:center; gap:15px; border-left: 4px solid #059669;">
            <i class="fa-solid fa-dog" style="font-size: 2rem; color:#059669;"></i>
            <div>
                <strong style="color:#0f172a; display:block;">Gestionar Mascotas</strong>
                <span style="font-size:0.8rem; color:#64748b;">Ver expedientes e historial</span>
            </div>
        </a>
        <a href="{{ route('admin.usuarios.index') }}" class="card-custom" style="text-decoration:none; margin:0; display:flex; align-items:center; gap:15px; border-left: 4px solid #d97706;">
            <i class="fa-solid fa-user-gear" style="font-size: 2rem; color:#d97706;"></i>
            <div>
                <strong style="color:#0f172a; display:block;">Gestionar Usuarios</strong>
                <span style="font-size:0.8rem; color:#64748b;">Clientes y Administradores</span>
            </div>
        </a>
        <a href="{{ route('admin.productos.index') }}" class="card-custom" style="text-decoration:none; margin:0; display:flex; align-items:center; gap:15px; border-left: 4px solid #7c3aed;">
            <i class="fa-solid fa-store" style="font-size: 2rem; color:#7c3aed;"></i>
            <div>
                <strong style="color:#0f172a; display:block;">Catálogo / Inventario</strong>
                <span style="font-size:0.8rem; color:#64748b;">Productos y Categorías</span>
            </div>
        </a>
    </div>
</div>
@endsection
