@extends('layouts.admin')

@section('title', 'VETecNM - Gestión de Mascotas')
@section('header_title', 'Gestión de Mascotas')

@section('content')
@if(session('success'))
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-circle-check" style="font-size: 1.1rem; color: #059669;"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem; color: #dc2626;"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="card-custom">
    <div class="card-header-flex">
        <div>
            <h3><i class="fa-solid fa-paw" style="color: #059669;"></i> Expediente de Mascotas</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Cada mascota puede tener hasta 2 dueños. Administradores y Recepcionistas pueden asignar o quitar mascotas a clientes.</span>
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
                    <th>Edad</th>
                    <th>Peso (kg)</th>
                    <th style="min-width: 240px;">Dueños / Clientes (Máx. 2)</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mascotas as $m)
                    @php
                        $duenosList = isset($m->duenos) ? $m->duenos : collect();
                    @endphp
                    <tr>
                        <td><strong>#{{ $m->id_mascota }}</strong></td>
                        <td><strong style="color: #0f172a;"><i class="fa-solid fa-paw" style="color: #059669;"></i> {{ $m->nombre }}</strong></td>
                        <td>{{ $m->especie }}</td>
                        <td>{{ $m->raza ?? 'No especificada' }}</td>
                        <td>{{ isset($m->edad) && $m->edad !== null ? $m->edad.' año(s)' : 'N/A' }}</td>
                        <td>{{ $m->peso ? $m->peso.' kg' : 'N/A' }}</td>
                        <td>
                            @if($duenosList->isEmpty())
                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 6px; font-size: 0.76rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Sin dueño asignado
                                </span>
                            @else
                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                    @foreach($duenosList as $dueno)
                                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px 8px; font-size: 0.82rem;">
                                            <div>
                                                <strong>{{ $dueno->nombre }}</strong>
                                                <span style="color: #64748b; font-size: 0.74rem; display: block;">{{ $dueno->email }}</span>
                                            </div>
                                            <form action="{{ route('admin.mascotas.quitar-dueno', $m->id_mascota) }}" method="POST" style="margin: 0;" onsubmit="return confirm('¿Quitar a {{ $dueno->nombre }} como dueño de {{ $m->nombre }}?');">
                                                @csrf
                                                <input type="hidden" name="id_usuario" value="{{ $dueno->id_usuario }}">
                                                <button type="submit" class="btn-action btn-delete" style="padding: 2px 6px; font-size: 0.72rem; line-height: 1;" title="Quitar este dueño">
                                                    <i class="fa-solid fa-user-xmark"></i> Quitar
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($duenosList->count() < 2)
                                <div style="margin-top: 6px;">
                                    <button type="button" class="btn-action" style="background: #0284c7; color: white; padding: 3px 8px; font-size: 0.75rem;" onclick="openAsignarModal({{ $m->id_mascota }}, '{{ addslashes($m->nombre) }}', {{ json_encode($duenosList->pluck('id_usuario')) }})">
                                        <i class="fa-solid fa-user-plus"></i> Asignar Dueño ({{ $duenosList->count() }}/2)
                                    </button>
                                </div>
                            @else
                                <div style="margin-top: 4px;">
                                    <span style="font-size: 0.72rem; color: #059669; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-circle-check"></i> 2 de 2 dueños (Límite máximo)
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <a href="{{ route('admin.mascotas.historial', $m->id_mascota) }}" class="btn-action" style="background: #2563eb; color: white;" title="Ver Historial Clínico">
                                <i class="fa-solid fa-clock-rotate-left"></i> Historial
                            </a>

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
    <div class="modal-container" style="max-width: 540px;">
        <div class="modal-header">
            <h4><i class="fa-solid fa-paw" style="color: #059669;"></i> Registrar Mascota</h4>
            <button class="modal-close" onclick="closeModal('modalCreate')">&times;</button>
        </div>
        <form action="{{ route('admin.mascotas.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="id_usuario">Dueño Principal (Cliente) *</label>
                    <select name="id_usuario" id="id_usuario" required>
                        <option value="">-- Seleccionar Dueño Principal --</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id_usuario }}" {{ old('id_usuario') == $u->id_usuario ? 'selected' : '' }}>
                                {{ $u->nombre }} ({{ $u->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_usuario')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_usuario_secundario">Segundo Dueño (Opcional - Máx. 2)</label>
                    <select name="id_usuario_secundario" id="id_usuario_secundario">
                        <option value="">-- Sin segundo dueño (Opcional) --</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id_usuario }}" {{ old('id_usuario_secundario') == $u->id_usuario ? 'selected' : '' }}>
                                {{ $u->nombre }} ({{ $u->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_usuario_secundario')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div style="font-size: 0.78rem; color: #64748b; margin-top: -8px; margin-bottom: 14px;">
                <i class="fa-solid fa-circle-info"></i> Máximo 2 dueños por mascota. No se permite el doble registro de la misma mascota para el mismo usuario.
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre de la Mascota *</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Ej: Firulais, Michi..." value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="especie">Especie *</label>
                    <select name="especie" id="especie" required>
                        <option value="Perro" {{ old('especie') == 'Perro' ? 'selected' : '' }}>Perro</option>
                        <option value="Gato" {{ old('especie') == 'Gato' ? 'selected' : '' }}>Gato</option>
                        <option value="Ave" {{ old('especie') == 'Ave' ? 'selected' : '' }}>Ave</option>
                        <option value="Conejo" {{ old('especie') == 'Conejo' ? 'selected' : '' }}>Conejo</option>
                        <option value="Reptil" {{ old('especie') == 'Reptil' ? 'selected' : '' }}>Reptil</option>
                        <option value="Otro" {{ old('especie') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('especie')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="raza">Raza</label>
                    <input type="text" name="raza" id="raza" placeholder="Ej: Poodle, Siamés..." value="{{ old('raza') }}">
                    @error('raza')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="edad">Edad (en años)</label>
                    <input type="number" name="edad" id="edad" min="0" max="100" placeholder="Ej: 3" value="{{ old('edad') }}">
                    @error('edad')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="peso">Peso en kg</label>
                    <input type="number" step="0.01" name="peso" id="peso" placeholder="Ej: 5.5" value="{{ old('peso') }}">
                    @error('peso')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalCreate')">Cancelar</button>
                <button type="submit" class="btn-action btn-add" style="background:#059669;">Guardar Mascota</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Asignar Dueño -->
<div id="modalAsignarDueno" class="modal-backdrop">
    <div class="modal-container" style="max-width: 480px;">
        <div class="modal-header">
            <h4><i class="fa-solid fa-user-plus" style="color: #0284c7;"></i> Asignar Dueño a Mascota</h4>
            <button class="modal-close" onclick="closeModal('modalAsignarDueno')">&times;</button>
        </div>
        <form id="formAsignarDueno" method="POST">
            @csrf
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 0.85rem; color: #166534;">
                Asignando nuevo dueño a: <strong id="asignar_mascota_nombre"></strong> (Máximo 2 dueños permitidos por mascota).
            </div>
            <div class="form-group">
                <label for="asignar_id_usuario">Seleccionar Cliente / Dueño *</label>
                <select name="id_usuario" id="asignar_id_usuario" required>
                    <option value="">-- Seleccionar Cliente --</option>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->id_usuario }}" class="opt-asignar-usuario" data-user-id="{{ $u->id_usuario }}">
                            {{ $u->nombre }} ({{ $u->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="font-size: 0.78rem; color: #64748b; margin-top: -6px; margin-bottom: 14px;">
                <i class="fa-solid fa-shield-halved"></i> Se validará automáticamente que el cliente no tenga ya registrada otra mascota con el mismo nombre y especie.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalAsignarDueno')">Cancelar</button>
                <button type="submit" class="btn-action btn-add" style="background: #0284c7;">Asignar Dueño</button>
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
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_nombre">Nombre *</label>
                    <input type="text" name="nombre" id="edit_nombre" required>
                </div>
                <div class="form-group">
                    <label for="edit_especie">Especie *</label>
                    <select name="especie" id="edit_especie" required>
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
                    <label for="edit_raza">Raza</label>
                    <input type="text" name="raza" id="edit_raza">
                </div>
                <div class="form-group">
                    <label for="edit_edad">Edad (en años)</label>
                    <input type="number" name="edad" id="edit_edad" min="0" max="100">
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
        document.getElementById('edit_nombre').value = mascota.nombre;
        document.getElementById('edit_especie').value = mascota.especie;
        document.getElementById('edit_raza').value = mascota.raza || '';
        document.getElementById('edit_edad').value = (mascota.edad !== null && mascota.edad !== undefined) ? mascota.edad : '';
        document.getElementById('edit_peso').value = mascota.peso || '';
        document.getElementById('modalEdit').classList.add('active');
    }

    function openAsignarModal(mascotaId, mascotaNombre, currentOwnerIds) {
        document.getElementById('formAsignarDueno').action = "/admin/mascotas/" + mascotaId + "/asignar-dueno";
        document.getElementById('asignar_mascota_nombre').textContent = mascotaNombre;

        const select = document.getElementById('asignar_id_usuario');
        select.value = '';

        const options = select.querySelectorAll('.opt-asignar-usuario');
        options.forEach(opt => {
            const uid = parseInt(opt.getAttribute('data-user-id'), 10);
            if (currentOwnerIds.includes(uid)) {
                opt.style.display = 'none';
                opt.disabled = true;
            } else {
                opt.style.display = '';
                opt.disabled = false;
            }
        });

        document.getElementById('modalAsignarDueno').classList.add('active');
    }
</script>
@endsection
