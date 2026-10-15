@extends('layouts.admin')

@section('title', 'VETecNM - Configuración de Horarios & Disponibilidad')
@section('header_title', 'Configuración de Horarios & Disponibilidad')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
    <div>
        <h2 style="font-size: 1.4rem; color: #0f172a; margin: 0;">
            <i class="fa-solid fa-clock" style="color: #2563eb;"></i> Configuración de Horarios y Disponibilidad
        </h2>
        <p style="font-size: 0.88rem; color: #64748b; margin: 4px 0 0 0;">
            Administra los horarios de atención de la clínica, descansos/recesos, días no laborables y bloqueos de agenda del personal.
        </p>
    </div>
</div>

@if(session('success'))
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; color: #10b981;"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.2rem; color: #ef4444;"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<!-- Tabs Navigation -->
<div style="display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <button class="tab-btn active" onclick="switchScheduleTab('tab-atencion', this)">
        <i class="fa-solid fa-business-time"></i> Horarios de Atención Semanales
    </button>
    <button class="tab-btn" onclick="switchScheduleTab('tab-recesos', this)">
        <i class="fa-solid fa-mug-hot"></i> Recesos Laborales
    </button>
    <button class="tab-btn" onclick="switchScheduleTab('tab-dias', this)">
        <i class="fa-solid fa-calendar-xmark"></i> Días No Laborables
    </button>
    <button class="tab-btn" onclick="switchScheduleTab('tab-bloqueos', this)">
        <i class="fa-solid fa-user-slash"></i> Bloqueos de Disponibilidad del Personal
    </button>
</div>

<!-- =======================================================================
     TAB 1: HORARIOS DE ATENCIÓN DE LA CLÍNICA (Lunes a Domingo)
     ======================================================================= -->
<div id="tab-atencion" class="tab-panel active">
    <div class="card-custom">
        <div class="card-header-flex">
            <div>
                <h3><i class="fa-solid fa-calendar-week" style="color: #2563eb;"></i> Horario Oficial de Atención Semanal</h3>
                <span style="font-size: 0.85rem; color: #64748b;">Configura los días y rangos de horas en que VETecNM recibe consultas y citas médicas.</span>
            </div>
        </div>

        <form action="{{ route('admin.horarios.atencion.update') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 140px;">Día</th>
                            <th style="width: 120px; text-align: center;">¿Labora?</th>
                            <th>Hora Apertura</th>
                            <th>Hora Cierre</th>
                            <th>Intervalo Cita (Minutos)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horarios as $index => $h)
                            <tr>
                                <td>
                                    <strong style="color: #1e293b; font-size: 0.95rem;">
                                        {{ $h->dia_nombre }}
                                    </strong>
                                    <input type="hidden" name="horarios[{{ $index }}][id]" value="{{ $h->id }}">
                                </td>
                                <td style="text-align: center;">
                                    <label class="switch-toggle" style="cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                        <input type="checkbox" name="horarios[{{ $index }}][activo]" value="1" {{ $h->activo ? 'checked' : '' }}>
                                        <span style="font-size: 0.82rem; color: {{ $h->activo ? '#059669' : '#dc2626' }}; font-weight: 600;">
                                            {{ $h->activo ? 'Abierto' : 'Cerrado' }}
                                        </span>
                                    </label>
                                </td>
                                <td>
                                    <input type="time" name="horarios[{{ $index }}][hora_apertura]" value="{{ substr($h->hora_apertura, 0, 5) }}" required style="max-width: 150px; padding: 6px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px;">
                                </td>
                                <td>
                                    <input type="time" name="horarios[{{ $index }}][hora_cierre]" value="{{ substr($h->hora_cierre, 0, 5) }}" required style="max-width: 150px; padding: 6px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px;">
                                </td>
                                <td>
                                    <select name="horarios[{{ $index }}][intervalo_minutos]" style="max-width: 160px; padding: 6px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px;">
                                        <option value="15" {{ $h->intervalo_minutos == 15 ? 'selected' : '' }}>15 minutos</option>
                                        <option value="30" {{ $h->intervalo_minutos == 30 ? 'selected' : '' }}>30 minutos (Estándar)</option>
                                        <option value="45" {{ $h->intervalo_minutos == 45 ? 'selected' : '' }}>45 minutos</option>
                                        <option value="60" {{ $h->intervalo_minutos == 60 ? 'selected' : '' }}>60 minutos (1 hora)</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem; text-align: right;">
                <button type="submit" class="btn-action btn-add">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios en Horario Semanal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =======================================================================
     TAB 2: RECESOS LABORALES (Almuerzos / Pausas)
     ======================================================================= -->
<div id="tab-recesos" class="tab-panel">
    <div class="card-custom">
        <div class="card-header-flex">
            <div>
                <h3><i class="fa-solid fa-mug-hot" style="color: #d97706;"></i> Recesos y Pausas Laborales</h3>
                <span style="font-size: 0.85rem; color: #64748b;">Los horarios de receso se descartan automáticamente de los turnos disponibles para evitar citas.</span>
            </div>
            <button class="btn-action btn-add" onclick="openModal('modalReceso')">
                <i class="fa-solid fa-plus"></i> Agregar Nuevo Receso
            </button>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Descripción del Receso</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Aplica A</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recesos as $r)
                        <tr>
                            <td><strong>{{ $r->nombre }}</strong></td>
                            <td><span class="status-badge" style="background: #fef3c7; color: #92400e;">{{ \Carbon\Carbon::parse($r->hora_inicio)->format('h:i A') }}</span></td>
                            <td><span class="status-badge" style="background: #fef3c7; color: #92400e;">{{ \Carbon\Carbon::parse($r->hora_fin)->format('h:i A') }}</span></td>
                            <td>
                                @if($r->aplica_a === 'todos')
                                    <span style="font-weight: 600; color: #2563eb;"><i class="fa-solid fa-users"></i> Todo el Personal</span>
                                @else
                                    <span style="color: #475569;"><i class="fa-solid fa-user-doctor"></i> {{ $r->aplica_a }}</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.horarios.recesos.destroy', $r->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este receso?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Eliminar Receso">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No se tienen recesos configurados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =======================================================================
     TAB 3: DÍAS NO LABORABLES / FESTIVOS
     ======================================================================= -->
<div id="tab-dias" class="tab-panel">
    <div class="card-custom">
        <div class="card-header-flex">
            <div>
                <h3><i class="fa-solid fa-calendar-xmark" style="color: #dc2626;"></i> Días No Laborables / Feriados</h3>
                <span style="font-size: 0.85rem; color: #64748b;">Fechas en las que la clínica permanece cerrada y no se permite agendar ninguna cita.</span>
            </div>
            <button class="btn-action btn-add" style="background: #dc2626;" onclick="openModal('modalDiaNoLab')">
                <i class="fa-solid fa-plus"></i> Agregar Día No Laborable
            </button>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Motivo / Festividad</th>
                        <th>Estado</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diasNoLaborables as $d)
                        <tr>
                            <td>
                                <strong><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($d->fecha)->translatedFormat('d \d\e F, Y') }}</strong>
                            </td>
                            <td>{{ $d->motivo }}</td>
                            <td>
                                <span class="status-badge" style="background: #fee2e2; color: #991b1b;">Cerrado Oficial</span>
                            </td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.horarios.dias.destroy', $d->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este día no laborable?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Eliminar Día">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No hay días no laborables registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =======================================================================
     TAB 4: BLOQUEOS DE DISPONIBILIDAD DEL PERSONAL
     ======================================================================= -->
<div id="tab-bloqueos" class="tab-panel">
    <div class="card-custom">
        <div class="card-header-flex">
            <div>
                <h3><i class="fa-solid fa-user-slash" style="color: #7c3aed;"></i> Bloqueos de Disponibilidad del Personal</h3>
                <span style="font-size: 0.85rem; color: #64748b;">Bloquea horarios de veterinarios o estilistas por vacaciones, congresos, cirugías privadas o permisos.</span>
            </div>
            <button class="btn-action btn-add" style="background: #7c3aed;" onclick="openModal('modalBloqueo')">
                <i class="fa-solid fa-plus"></i> Registrar Bloqueo de Personal
            </button>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Profesional</th>
                        <th>Fecha</th>
                        <th>Tipo y Horario del Bloqueo</th>
                        <th>Motivo / Razón</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bloqueos as $b)
                        <tr>
                            <td>
                                <strong style="color: #0f172a;"><i class="fa-solid fa-user-doctor"></i> {{ $b->profesional }}</strong>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($b->fecha)->format('d/m/Y') }}</td>
                            <td>
                                @if(empty($b->hora_inicio) && empty($b->hora_fin))
                                    <span class="status-badge" style="background: #ede9fe; color: #6d28d9; font-weight: 700;">Todo el Día Completo</span>
                                @else
                                    <span class="status-badge" style="background: #f1f5f9; color: #334155;">
                                        {{ \Carbon\Carbon::parse($b->hora_inicio)->format('h:i A') }} – {{ \Carbon\Carbon::parse($b->hora_fin)->format('h:i A') }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $b->motivo }}</td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.horarios.bloqueos.destroy', $b->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este bloqueo?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Eliminar Bloqueo">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No hay bloqueos de personal registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =======================================================================
     MODALES PARA AGREGAR RECESO, DÍA NO LABORABLE Y BLOQUEO
     ======================================================================= -->

<!-- Modal Receso -->
<div id="modalReceso" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-mug-hot" style="color: #d97706;"></i> Agregar Receso Laboral</h4>
            <button class="modal-close" onclick="closeModal('modalReceso')">&times;</button>
        </div>
        <form action="{{ route('admin.horarios.recesos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="receso_nombre">Nombre o Descripción del Receso *</label>
                <input type="text" name="nombre" id="receso_nombre" placeholder="Ej: Receso de Almuerzo / Comida" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="receso_inicio">Hora de Inicio *</label>
                    <input type="time" name="hora_inicio" id="receso_inicio" required>
                </div>
                <div class="form-group">
                    <label for="receso_fin">Hora de Fin *</label>
                    <input type="time" name="hora_fin" id="receso_fin" required>
                </div>
            </div>
            <div class="form-group">
                <label for="receso_aplica">¿A quién aplica este receso? *</label>
                <select name="aplica_a" id="receso_aplica" required>
                    <option value="todos">Todo el Personal de la Clínica</option>
                    @foreach($profesionales as $p)
                        <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalReceso')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Guardar Receso</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Día No Laborable -->
<div id="modalDiaNoLab" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-calendar-xmark" style="color: #dc2626;"></i> Agregar Día No Laborable</h4>
            <button class="modal-close" onclick="closeModal('modalDiaNoLab')">&times;</button>
        </div>
        <form action="{{ route('admin.horarios.dias.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="dia_fecha">Fecha *</label>
                <input type="date" name="fecha" id="dia_fecha" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label for="dia_motivo">Motivo o Feriado Oficial *</label>
                <input type="text" name="motivo" id="dia_motivo" placeholder="Ej: Día de la Independencia, Asueto, Aniversario..." required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalDiaNoLab')">Cancelar</button>
                <button type="submit" class="btn-action btn-add" style="background: #dc2626;">Guardar Día No Laborable</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Bloqueo Personal -->
<div id="modalBloqueo" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-user-slash" style="color: #7c3aed;"></i> Bloquear Disponibilidad de Personal</h4>
            <button class="modal-close" onclick="closeModal('modalBloqueo')">&times;</button>
        </div>
        <form action="{{ route('admin.horarios.bloqueos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="bloqueo_profesional">Seleccionar Trabajador / Profesional *</label>
                <select name="profesional" id="bloqueo_profesional" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($profesionales as $p)
                        <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="bloqueo_fecha">Fecha del Bloqueo *</label>
                <input type="date" name="fecha" id="bloqueo_fecha" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>Tipo de Bloqueo *</label>
                <div style="display: flex; gap: 20px; margin-top: 6px;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <input type="radio" name="tipo_bloqueo" value="completo" checked onchange="toggleBloqueoHoras(false)">
                        <span>Todo el Día Completo</span>
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <input type="radio" name="tipo_bloqueo" value="parcial" onchange="toggleBloqueoHoras(true)">
                        <span>Horas Específicas</span>
                    </label>
                </div>
            </div>
            <div id="rowBloqueoHoras" class="form-row" style="display: none;">
                <div class="form-group">
                    <label for="bloqueo_hora_ini">Hora Inicio</label>
                    <input type="time" name="hora_inicio" id="bloqueo_hora_ini">
                </div>
                <div class="form-group">
                    <label for="bloqueo_hora_fin">Hora Fin</label>
                    <input type="time" name="hora_fin" id="bloqueo_hora_fin">
                </div>
            </div>
            <div class="form-group">
                <label for="bloqueo_motivo">Motivo del Bloqueo *</label>
                <input type="text" name="motivo" id="bloqueo_motivo" placeholder="Ej: Vacaciones, Capacitación, Cirugía Programada, Permiso" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalBloqueo')">Cancelar</button>
                <button type="submit" class="btn-action btn-add" style="background: #7c3aed;">Registrar Bloqueo</button>
            </div>
        </form>
    </div>
</div>

<style>
    .tab-btn {
        background: transparent;
        border: none;
        padding: 10px 18px;
        font-family: inherit;
        font-size: 0.92rem;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .tab-btn:hover {
        color: #2563eb;
    }
    .tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
    }
    .tab-panel {
        display: none;
    }
    .tab-panel.active {
        display: block;
    }
</style>
@endsection

@section('scripts')
<script>
    function switchScheduleTab(tabId, btnElement) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));

        btnElement.classList.add('active');
        const targetPanel = document.getElementById(tabId);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }
    }

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('active');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('active');
    }

    function toggleBloqueoHoras(mostrar) {
        const row = document.getElementById('rowBloqueoHoras');
        if (row) {
            row.style.display = mostrar ? 'flex' : 'none';
        }
    }
</script>
@endsection
