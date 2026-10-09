@extends('layouts.admin')

@section('title', 'VETecNM - Gestión de Mascotas')
@section('header_title', 'Gestión de Mascotas')

@section('content')
<div class="card-custom">
    <div class="card-header-flex">
        <div>
            <h3><i class="fa-solid fa-paw" style="color: #059669;"></i> Expediente de Mascotas</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Lista de pacientes veterinarios registrados y sus dueños.</span>
        </div>
        <button class="btn-action btn-add" style="background: #059669;" onclick="openCreateModal()">
            <i class="fa-solid fa-plus"></i> Registrar Mascota
        </button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Mascota</th>
                    <th>Especie</th>
                    <th>Raza</th>
                    <th>Peso (kg)</th>
                    <th>Dueño / Cliente</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mascotas as $m)
                    <tr>
                        <td><strong>#{{ $m->id_mascota }}</strong></td>
                        <td><strong style="color: #0f172a;"><i class="fa-solid fa-paw"></i> {{ $m->nombre }}</strong></td>
                        <td>{{ $m->especie }}</td>
                        <td>{{ $m->raza ?? 'No especificada' }}</td>
                        <td>{{ $m->peso ? $m->peso.' kg' : 'N/A' }}</td>
                        <td>
                            <span>{{ $m->dueno_nombre }}</span>
                            <br><span style="font-size: 0.78rem; color: #64748b;">{{ $m->dueno_email }}</span>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <button class="btn-action btn-edit" onclick='openEditModal(@json($m))' title="Editar Mascota">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>

                            <form action="{{ route('admin.mascotas.destroy', $m->id_mascota) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar mascota y sus citas asociadas?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Eliminar Mascota">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No hay mascotas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear Mascota -->
<div id="modalCreate" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-paw" style="color: #059669;"></i> Registrar Mascota</h4>
            <button class="modal-close" onclick="closeModal('modalCreate')">&times;</button>
        </div>
        <form action="{{ route('admin.mascotas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_usuario">Dueño / Cliente *</label>
                <select name="id_usuario" id="id_usuario" required>
                    <option value="">-- Seleccionar Cliente --</option>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->id_usuario }}">{{ $u->nombre }} ({{ $u->email }}) [{{ ucfirst($u->rol) }}]</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre de la Mascota *</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Ej: Firulais, Michi..." required>
                </div>
                <div class="form-group">
                    <label for="especie">Especie *</label>
                    <select name="especie" id="especie" required>
                        <option value="Perro">Perro</option>
                        <option value="Gato">Gato</option>
                        <option value="Ave">Ave</option>
                        <option value="Conejo">Conejo</option>
                        <option value="Reptil">Reptil</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="raza">Raza</label>
                    <input type="text" name="raza" id="raza" placeholder="Ej: Poodle, Siamés...">
                </div>
                <div class="form-group">
                    <label for="peso">Peso en kg</label>
                    <input type="number" step="0.01" name="peso" id="peso" placeholder="Ej: 5.5">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalCreate')">Cancelar</button>
                <button type="submit" class="btn-action btn-add" style="background:#059669;">Guardar Mascota</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Mascota -->
<div id="modalEdit" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Editar Mascota</h4>
            <button class="modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form id="formEditMascota" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_id_usuario">Dueño / Cliente *</label>
                <select name="id_usuario" id="edit_id_usuario" required>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->id_usuario }}">{{ $u->nombre }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_nombre">Nombre *</label>
                    <input type="text" name="nombre" id="edit_nombre" required>
                </div>
                <div class="form-group">
                    <label for="edit_especie">Especie *</label>
                    <input type="text" name="especie" id="edit_especie" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_raza">Raza</label>
                    <input type="text" name="raza" id="edit_raza">
                </div>
                <div class="form-group">
                    <label for="edit_peso">Peso en kg</label>
                    <input type="number" step="0.01" name="peso" id="edit_peso">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalEdit')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Actualizar Mascota</button>
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

    function openEditModal(mascota) {
        document.getElementById('formEditMascota').action = "/admin/mascotas/" + mascota.id_mascota;
        document.getElementById('edit_id_usuario').value = mascota.id_usuario;
        document.getElementById('edit_nombre').value = mascota.nombre;
        document.getElementById('edit_especie').value = mascota.especie;
        document.getElementById('edit_raza').value = mascota.raza || '';
        document.getElementById('edit_peso').value = mascota.peso || '';
        document.getElementById('modalEdit').classList.add('active');
    }
</script>
@endsection
