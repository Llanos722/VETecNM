@extends('layouts.admin')

@section('title', 'VETecNM - Gestión de Citas Médicas')
@section('header_title', 'Gestión de Citas Médicas')

@section('content')
<div class="card-custom">
    <div class="card-header-flex">
        <div>
            <h3><i class="fa-solid fa-calendar-check" style="color: #2563eb;"></i> Citas Médicas Veterinarias</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Administra, agenda y actualiza el estado de las citas clínicas.</span>
        </div>
        <button class="btn-action btn-add" onclick="openCreateModal()">
            <i class="fa-solid fa-plus"></i> Agendar Nueva Cita
        </button>
    </div>

    <!-- Filter Buttons -->
    <div style="display: flex; gap: 10px; margin-bottom: 1.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.citas.index') }}" class="btn-action" style="background: {{ !$estadoFilter ? '#334155' : '#e2e8f0' }}; color: {{ !$estadoFilter ? 'white' : '#334155' }}; font-size: 0.82rem; padding: 6px 14px;">Todas</a>
        <a href="{{ route('admin.citas.index', ['estado' => 'Pendiente']) }}" class="btn-action" style="background: {{ $estadoFilter === 'Pendiente' ? '#d97706' : '#e2e8f0' }}; color: {{ $estadoFilter === 'Pendiente' ? 'white' : '#334155' }}; font-size: 0.82rem; padding: 6px 14px;">Pendientes</a>
        <a href="{{ route('admin.citas.index', ['estado' => 'Confirmada']) }}" class="btn-action" style="background: {{ $estadoFilter === 'Confirmada' ? '#059669' : '#e2e8f0' }}; color: {{ $estadoFilter === 'Confirmada' ? 'white' : '#334155' }}; font-size: 0.82rem; padding: 6px 14px;">Confirmadas</a>
        <a href="{{ route('admin.citas.index', ['estado' => 'Finalizada']) }}" class="btn-action" style="background: {{ $estadoFilter === 'Finalizada' ? '#2563eb' : '#e2e8f0' }}; color: {{ $estadoFilter === 'Finalizada' ? 'white' : '#334155' }}; font-size: 0.82rem; padding: 6px 14px;">Finalizadas</a>
        <a href="{{ route('admin.citas.index', ['estado' => 'Cancelada']) }}" class="btn-action" style="background: {{ $estadoFilter === 'Cancelada' ? '#dc2626' : '#e2e8f0' }}; color: {{ $estadoFilter === 'Cancelada' ? 'white' : '#334155' }}; font-size: 0.82rem; padding: 6px 14px;">Canceladas</a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mascota</th>
                    <th>Dueño / Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Motivo de Consulta</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citas as $c)
                    <tr>
                        <td><strong>#{{ $c->id_cita }}</strong></td>
                        <td>
                            <strong style="color: #0f172a;"><i class="fa-solid fa-paw" style="color: #64748b;"></i> {{ $c->mascota_nombre }}</strong>
                            <br><span style="font-size: 0.78rem; color: #64748b;">{{ $c->especie }} ({{ $c->raza ?? 'N/A' }})</span>
                        </td>
                        <td>
                            <span>{{ $c->dueno_nombre }}</span>
                            <br><span style="font-size: 0.78rem; color: #64748b;">{{ $c->dueno_email }}</span>
                        </td>
                        <td>{{ $c->fecha }}</td>
                        <td>{{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}</td>
                        <td>{{ $c->motivo }}</td>
                        <td><span class="status-badge status-{{ $c->estado }}">{{ $c->estado }}</span></td>
                        <td style="text-align: right; white-space: nowrap;">
                            <!-- Change Status Quick Form -->
                            <form action="{{ route('admin.citas.status', $c->id_cita) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <select name="estado" onchange="this.form.submit()" style="padding: 4px 8px; font-size: 0.78rem; border-radius: 6px; border: 1px solid #cbd5e1; cursor: pointer;">
                                    <option value="Pendiente" {{ $c->estado === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Confirmada" {{ $c->estado === 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                    <option value="Finalizada" {{ $c->estado === 'Finalizada' ? 'selected' : '' }}>Finalizada</option>
                                    <option value="Cancelada" {{ $c->estado === 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </form>

                            <button class="btn-action btn-edit" onclick='openEditModal(@json($c))' title="Editar Cita">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <form action="{{ route('admin.citas.destroy', $c->id_cita) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que deseas eliminar esta cita médica?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Eliminar Cita">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No se encontraron citas médicas en esta categoría.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agendar Nueva Cita -->
<div id="modalCreate" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-calendar-plus" style="color: #2563eb;"></i> Agendar Cita Médica</h4>
            <button class="modal-close" onclick="closeModal('modalCreate')">&times;</button>
        </div>
        <form action="{{ route('admin.citas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_mascota">Seleccionar Mascota y Dueño *</label>
                <select name="id_mascota" id="id_mascota" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($mascotas as $m)
                        <option value="{{ $m->id_mascota }}">{{ $m->nombre }} ({{ $m->especie }}) - Dueño: {{ $m->dueno_nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha">Fecha *</label>
                    <input type="date" name="fecha" id="fecha" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="hora">Hora *</label>
                    <input type="time" name="hora" id="hora" required>
                </div>
            </div>
            <div class="form-group">
                <label for="motivo">Motivo de la Consulta *</label>
                <input type="text" name="motivo" id="motivo" placeholder="Ej: Vacunación, Desparasitación, Chequeo..." required>
            </div>
            <div class="form-group">
                <label for="estado">Estado Inicial *</label>
                <select name="estado" id="estado" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmada" selected>Confirmada</option>
                    <option value="Finalizada">Finalizada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalCreate')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Guardar Cita</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Cita -->
<div id="modalEdit" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Editar Cita Médica</h4>
            <button class="modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form id="formEditCita" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_id_mascota">Seleccionar Mascota *</label>
                <select name="id_mascota" id="edit_id_mascota" required>
                    @foreach($mascotas as $m)
                        <option value="{{ $m->id_mascota }}">{{ $m->nombre }} ({{ $m->especie }}) - Dueño: {{ $m->dueno_nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_fecha">Fecha *</label>
                    <input type="date" name="fecha" id="edit_fecha" required>
                </div>
                <div class="form-group">
                    <label for="edit_hora">Hora *</label>
                    <input type="time" name="hora" id="edit_hora" required>
                </div>
            </div>
            <div class="form-group">
                <label for="edit_motivo">Motivo de Consulta *</label>
                <input type="text" name="motivo" id="edit_motivo" required>
            </div>
            <div class="form-group">
                <label for="edit_estado">Estado *</label>
                <select name="estado" id="edit_estado" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Finalizada">Finalizada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalEdit')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Actualizar Cita</button>
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

    function openEditModal(cita) {
        document.getElementById('formEditCita').action = "/admin/citas/" + cita.id_cita;
        document.getElementById('edit_id_mascota').value = cita.id_mascota;
        document.getElementById('edit_fecha').value = cita.fecha;
        document.getElementById('edit_hora').value = cita.hora;
        document.getElementById('edit_motivo').value = cita.motivo;
        document.getElementById('edit_estado').value = cita.estado;
        document.getElementById('modalEdit').classList.add('active');
    }
</script>
@endsection
