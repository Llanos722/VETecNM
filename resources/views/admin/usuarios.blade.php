@extends('layouts.admin')

@section('title', 'VETecNM - Gestión de Usuarios')
@section('header_title', 'Gestión de Usuarios')

@section('content')
<div class="card-custom">
    <div class="card-header-flex">
        <div>
            <h3><i class="fa-solid fa-users" style="color: #d97706;"></i> Cuentas de Usuarios del Sistema</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Administra accesos, roles (Clientes y Administradores) y contraseñas.</span>
        </div>
        <button class="btn-action btn-add" style="background: #d97706;" onclick="openCreateModal()">
            <i class="fa-solid fa-user-plus"></i> Crear Nuevo Usuario
        </button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Mascotas Registradas</th>
                    <th>Fecha Registro</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $u)
                    <tr>
                        <td><strong>#{{ $u->id_usuario }}</strong></td>
                        <td><strong style="color: #0f172a;"><i class="fa-regular fa-user"></i> {{ $u->nombre }}</strong></td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if($u->rol === 'admin')
                                <span class="admin-badge"><i class="fa-solid fa-shield"></i> {{ ucfirst($u->rol) }}</span>
                            @else
                                <span class="status-badge status-Pendiente" style="background: #f1f5f9; color: #475569;">{{ ucfirst($u->rol) }}</span>
                            @endif
                        </td>
                        <td><i class="fa-solid fa-paw" style="color: #059669;"></i> {{ $u->total_mascotas }} mascota(s)</td>
                        <td>{{ \Carbon\Carbon::parse($u->fecha_registro)->format('d/m/Y H:i') }}</td>
                        <td style="text-align: right; white-space: nowrap;">
                            <button class="btn-action btn-edit" onclick='openEditModal(@json($u))' title="Editar Usuario">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>

                            @if(session('user_id') != $u->id_usuario)
                                <form action="{{ route('admin.usuarios.destroy', $u->id_usuario) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar usuario? Toda su información relacionada también se eliminará.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Eliminar Usuario">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.78rem; color: #94a3b8; font-style: italic;">(Tu usuario)</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear Usuario -->
<div id="modalCreate" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-user-plus" style="color: #d97706;"></i> Crear Usuario</h4>
            <button class="modal-close" onclick="closeModal('modalCreate')">&times;</button>
        </div>
        <form action="{{ route('admin.usuarios.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre Completo *</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ej: Maria López" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico *</label>
                <input type="email" name="email" id="email" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Contraseña *</label>
                    <input type="password" name="password" id="password" minlength="6" placeholder="Mínimo 6 caracteres" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol de Sistema *</label>
                    <select name="rol" id="rol" required>
                        <option value="cliente" selected>Cliente</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalCreate')">Cancelar</button>
                <button type="submit" class="btn-action btn-add" style="background:#d97706;">Crear Usuario</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div id="modalEdit" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-user-pen" style="color: #f59e0b;"></i> Editar Usuario</h4>
            <button class="modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form id="formEditUsuario" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_nombre">Nombre Completo *</label>
                <input type="text" name="nombre" id="edit_nombre" required>
            </div>
            <div class="form-group">
                <label for="edit_email">Correo Electrónico *</label>
                <input type="email" name="email" id="edit_email" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_rol">Rol de Sistema *</label>
                    <select name="rol" id="edit_rol" required>
                        <option value="cliente">Cliente</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_password">Nueva Contraseña (Opcional)</label>
                    <input type="password" name="password" id="edit_password" placeholder="Dejar en blanco para mantener">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalEdit')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Actualizar Usuario</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openCreateModal() {
        document.getElementById('modalCreate').classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function openEditModal(usuario) {
        document.getElementById('formEditUsuario').action = "/admin/usuarios/" + usuario.id_usuario;
        document.getElementById('edit_nombre').value = usuario.nombre;
        document.getElementById('edit_email').value = usuario.email;
        document.getElementById('edit_rol').value = usuario.rol;
        document.getElementById('edit_password').value = '';
        document.getElementById('modalEdit').classList.add('active');
    }
</script>
@endsection
