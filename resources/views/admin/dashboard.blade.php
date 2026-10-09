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
                    <th>Motivo</th>
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
                        <td>{{ $c->motivo }}</td>
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
