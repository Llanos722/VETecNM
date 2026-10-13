@extends('layouts.admin')

@section('title', 'VETecNM - Gestión de Citas Médicas')
@section('header_title', 'Gestión de Citas Médicas')

@section('content')
<div class="card-custom">
    <div class="card-header-flex" style="flex-wrap: wrap; gap: 12px;">
        <div>
            <h3><i class="fa-solid fa-calendar-check" style="color: #2563eb;"></i> Citas Médicas Veterinarias</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Administra, agenda presencialmente o por teléfono y actualiza el estado de las citas.</span>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <!-- R-33: Agendamiento Presencial o Telefónico -->
            <button class="btn-action" style="background: #0d9488; color: white;" onclick="openPresencialModal()">
                <i class="fa-solid fa-headset"></i> Agendamiento en Recepción (Presencial / Teléfono)
            </button>
            <button class="btn-action btn-add" onclick="openCreateModal()">
                <i class="fa-solid fa-plus"></i> Agendar Cita Regular
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 1.2rem; color: #10b981;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('alerta_error_general'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 1.2rem; color: #ef4444;"></i>
            <span>{{ session('alerta_error_general') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 1.5rem;">
            <strong><i class="fa-solid fa-triangle-exclamation"></i> Por favor revisa los errores:</strong>
            <ul style="margin: 6px 0 0 1.2rem; padding: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                    <th>Fecha & Hora</th>
                    <th>Servicio & Profesional</th>
                    <th>Canal</th>
                    <th>Motivo</th>
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
                            @if(!empty($c->telefono_contacto ?? $c->dueno_telefono))
                                <br><span style="font-size: 0.75rem; color: #0284c7;"><i class="fa-solid fa-phone"></i> {{ $c->telefono_contacto ?? $c->dueno_telefono }}</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</strong>
                            <br><span style="font-size: 0.82rem; color: #2563eb; font-weight: 600;"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}</span>
                        </td>
                        <td>
                            <strong style="font-size: 0.85rem; color: #0f172a;">{{ $c->servicio ?? 'Consulta Médica General' }}</strong>
                            <br><span style="font-size: 0.78rem; color: #475569;"><i class="fa-solid fa-user-doctor"></i> {{ $c->profesional ?? 'Sin asignar' }}</span>
                        </td>
                        <td>
                            @if(($c->canal ?? 'web') === 'presencial')
                                <span class="status-badge" style="background: #e0f2fe; color: #0369a1;"><i class="fa-solid fa-building"></i> Presencial</span>
                            @elseif(($c->canal ?? 'web') === 'telefono')
                                <span class="status-badge" style="background: #fef3c7; color: #92400e;"><i class="fa-solid fa-phone"></i> Teléfono</span>
                            @else
                                <span class="status-badge" style="background: #f1f5f9; color: #475569;"><i class="fa-solid fa-globe"></i> En Línea</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.85rem;">{{ $c->motivo }}</span>
                            @if(!empty($c->notas))
                                <br><span style="font-size: 0.75rem; color: #64748b; font-style: italic;">Nota: {{ $c->notas }}</span>
                            @endif
                        </td>
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
                        <td colspan="9" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No se encontraron citas médicas registradas en esta categoría.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- =========================================================================
     R-32 REQUISITO VISUAL EXPLÍCITO:
     "emergerá una ventana de color azul con icono de alerta blanco notificando
     que el horario ya no se encuentra disponible."
     ========================================================================= -->
<div id="modalAlertaAzulHorario" class="modal-backdrop-blue" style="display: none;">
    <div class="modal-card-blue">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem auto; border: 2px solid rgba(255,255,255,0.5);">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 3rem; color: #ffffff;"></i>
            </div>
            <h3 style="color: #ffffff; font-size: 1.5rem; margin: 0 0 8px 0; font-weight: 700;">
                ¡Horario No Disponible!
            </h3>
            <p id="alertaAzulTexto" style="color: #e0f2fe; font-size: 1.05rem; line-height: 1.5; margin: 0;">
                El horario ya no se encuentra disponible.
            </p>
            <p id="alertaAzulDetalle" style="color: #bae6fd; font-size: 0.88rem; margin-top: 10px; font-style: italic;">
            </p>
        </div>
        <div style="text-align: center;">
            <button type="button" class="btn-blue-modal" onclick="closeAlertaAzul()">
                <i class="fa-solid fa-arrow-rotate-left"></i> Entendido, Elegir Otro Horario
            </button>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL R-33: AGENDAMIENTO EN RECEPCIÓN (PRESENCIAL O POR TELÉFONO)
     ========================================================================= -->
<div id="modalPresencial" class="modal-backdrop">
    <div class="modal-container" style="max-width: 650px;">
        <div class="modal-header">
            <h4><i class="fa-solid fa-headset" style="color: #0d9488;"></i> Agendamiento Presencial o Telefónico (R-33)</h4>
            <button class="modal-close" onclick="closeModal('modalPresencial')">&times;</button>
        </div>
        <form action="{{ route('admin.citas.presencial.store') }}" method="POST">
            @csrf

            <!-- Canal / Vía de Solicitud -->
            <div class="form-group" style="background: #f0fdfa; border: 1px solid #ccfbf1; padding: 12px; border-radius: 8px;">
                <label style="font-weight: 600; color: #0f766e; margin-bottom: 6px; display: block;">Modalidad de Solicitud *</label>
                <div style="display: flex; gap: 24px;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 6px; font-weight: 500;">
                        <input type="radio" name="canal" value="presencial" checked>
                        <span><i class="fa-solid fa-building"></i> Presencial (Ventanilla de Clínica)</span>
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 6px; font-weight: 500;">
                        <input type="radio" name="canal" value="telefono">
                        <span><i class="fa-solid fa-phone"></i> Vía Telefónica</span>
                    </label>
                </div>
            </div>

            <!-- Identificación del Cliente -->
            <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label style="font-weight: 600; color: #1e293b; margin: 0;">Datos del Dueño / Cliente *</label>
                    <button type="button" class="btn-toggle-client" onclick="toggleNuevoCliente()" style="background: none; border: none; color: #0284c7; font-size: 0.8rem; cursor: pointer; text-decoration: underline;">
                        <span id="btnClientToggleText">+ Registrar Nuevo Cliente Rápido</span>
                    </button>
                </div>

                <div id="boxClienteExistente" class="form-group" style="margin-bottom: 0;">
                    <select name="id_usuario" id="pres_id_usuario" onchange="actualizarMascotasDeCliente(this.value)">
                        <option value="">-- Seleccionar Cliente Registrado --</option>
                        @foreach($clientes as $cl)
                            <option value="{{ $cl->id_usuario }}">{{ $cl->nombre }} (Tel: {{ $cl->telefono ?? 'Sin tel' }} - {{ $cl->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div id="boxNuevoCliente" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre del Cliente *</label>
                            <input type="text" name="cliente_nombre" id="pres_cliente_nombre" placeholder="Ej: Patricia Morales">
                        </div>
                        <div class="form-group">
                            <label>Teléfono de Contacto *</label>
                            <input type="tel" name="cliente_telefono" id="pres_cliente_telefono" placeholder="Ej: 3411234567">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Correo Electrónico (Opcional)</label>
                        <input type="email" name="cliente_email" id="pres_cliente_email" placeholder="correo@ejemplo.com">
                    </div>
                </div>
            </div>

            <!-- Mascota del Paciente -->
            <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label style="font-weight: 600; color: #1e293b; margin: 0;">Paciente / Mascota *</label>
                    <button type="button" class="btn-toggle-client" onclick="toggleNuevaMascota()" style="background: none; border: none; color: #0284c7; font-size: 0.8rem; cursor: pointer; text-decoration: underline;">
                        <span id="btnPetToggleText">+ Registrar Nueva Mascota</span>
                    </button>
                </div>

                <div id="boxMascotaExistente" class="form-group" style="margin-bottom: 0;">
                    <select name="id_mascota" id="pres_id_mascota">
                        <option value="">-- Seleccionar Mascota --</option>
                        @foreach($mascotas as $m)
                            <option value="{{ $m->id_mascota }}" data-owner="{{ $m->id_usuario }}">{{ $m->nombre }} ({{ $m->especie }}) - Dueño: {{ $m->dueno_nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="boxNuevaMascota" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre de la Mascota *</label>
                            <input type="text" name="mascota_nombre" id="pres_mascota_nombre" placeholder="Ej: Toby, Misi, Rocky">
                        </div>
                        <div class="form-group">
                            <label>Especie *</label>
                            <select name="mascota_especie" id="pres_mascota_especie">
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                                <option value="Ave">Ave</option>
                                <option value="Conejo">Conejo</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Raza (Opcional)</label>
                        <input type="text" name="mascota_raza" id="pres_mascota_raza" placeholder="Ej: Poodle, Mestizo, Husky">
                    </div>
                </div>
            </div>

            <!-- Servicio & Profesional (R-30) -->
            <div class="form-row">
                <div class="form-group">
                    <label for="pres_servicio">Servicio Requerido *</label>
                    <select name="servicio" id="pres_servicio" required onchange="cargarDisponibilidadPresencial()">
                        <option value="">-- Seleccionar Servicio --</option>
                        @foreach($serviciosDisponibles as $catNombre => $srvList)
                            <optgroup label="{{ $catNombre }}">
                                @foreach($srvList as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="pres_profesional">Profesional de Salud / Estética *</label>
                    <select name="profesional" id="pres_profesional" required onchange="cargarDisponibilidadPresencial()">
                        <option value="">-- Seleccionar Profesional --</option>
                        @foreach($profesionales as $p)
                            <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Fecha & Horario Disponible (R-31, Regla de 30 minutos) -->
            <div class="form-row">
                <div class="form-group">
                    <label for="pres_fecha">Fecha *</label>
                    <input type="date" name="fecha" id="pres_fecha" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required onchange="cargarDisponibilidadPresencial()">
                </div>
                <div class="form-group">
                    <label for="pres_hora">Horario Disponible (R-31) *</label>
                    <select name="hora" id="pres_hora" required>
                        <option value="">-- Selecciona fecha y profesional --</option>
                    </select>
                    <small id="pres_hora_info" style="color: #64748b; font-size: 0.76rem; display: block; margin-top: 4px;">
                        Muestra únicamente horarios hábiles sin recesos ni citas simultáneas.
                    </small>
                </div>
            </div>

            <div class="form-group">
                <label for="pres_motivo">Motivo de la Cita / Síntomas *</label>
                <input type="text" name="motivo" id="pres_motivo" placeholder="Ej: Revisión general, Vacuna antirrábica, Malestar..." required>
            </div>

            <div class="form-group">
                <label for="pres_notas">Notas de Recepción (Opcional)</label>
                <textarea name="notas" id="pres_notas" rows="2" placeholder="Detalles de la llamada o indicaciones del cliente en recepción..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalPresencial')">Cancelar</button>
                <button type="submit" class="btn-action" style="background: #0d9488; color: white;">
                    <i class="fa-solid fa-check"></i> Confirmar Cita en Recepción
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================
     MODAL AGENDAR CITA REGULAR
     ========================================================================= -->
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
                    <label for="reg_servicio">Servicio *</label>
                    <select name="servicio" id="reg_servicio" onchange="cargarDisponibilidadRegular()">
                        <option value="">-- Seleccionar Servicio --</option>
                        @foreach($serviciosDisponibles as $catNombre => $srvList)
                            <optgroup label="{{ $catNombre }}">
                                @foreach($srvList as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="reg_profesional">Profesional *</label>
                    <select name="profesional" id="reg_profesional" onchange="cargarDisponibilidadRegular()">
                        <option value="">-- Seleccionar Profesional --</option>
                        @foreach($profesionales as $p)
                            <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha">Fecha *</label>
                    <input type="date" name="fecha" id="fecha" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required onchange="cargarDisponibilidadRegular()">
                </div>
                <div class="form-group">
                    <label for="hora_select">Hora Disponible (R-31) *</label>
                    <select name="hora" id="hora_select" required>
                        <option value="">-- Cargar Horarios --</option>
                    </select>
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

<!-- =========================================================================
     MODAL EDITAR CITA
     ========================================================================= -->
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
                    <label for="edit_servicio">Servicio</label>
                    <select name="servicio" id="edit_servicio">
                        <option value="">-- Seleccionar Servicio --</option>
                        @foreach($serviciosDisponibles as $catNombre => $srvList)
                            <optgroup label="{{ $catNombre }}">
                                @foreach($srvList as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_profesional">Profesional</label>
                    <select name="profesional" id="edit_profesional">
                        <option value="">-- Sin profesional asignado --</option>
                        @foreach($profesionales as $p)
                            <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
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

<style>
    /* Estilos de la ventana azul de alerta (R-32) */
    .modal-backdrop-blue {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .modal-card-blue {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        color: white;
        padding: 2.2rem 2.5rem;
        border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(29, 78, 216, 0.5);
        max-width: 460px;
        width: 100%;
        border: 2px solid rgba(255, 255, 255, 0.2);
        animation: popIn 0.25s ease-out;
    }
    .btn-blue-modal {
        background: #ffffff;
        color: #1d4ed8;
        border: none;
        padding: 0.8rem 1.8rem;
        font-size: 0.95rem;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform 0.15s, background-color 0.15s;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .btn-blue-modal:hover {
        background: #f8fafc;
        transform: translateY(-1px);
    }
    @keyframes popIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endsection

@section('scripts')
<script>
    function openCreateModal() {
        document.getElementById('modalCreate').classList.add('active');
        cargarDisponibilidadRegular();
    }

    function openPresencialModal() {
        document.getElementById('modalPresencial').classList.add('active');
        cargarDisponibilidadPresencial();
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function openEditModal(cita) {
        document.getElementById('formEditCita').action = "/admin/citas/" + cita.id_cita;
        document.getElementById('edit_id_mascota').value = cita.id_mascota;
        if (document.getElementById('edit_servicio')) {
            document.getElementById('edit_servicio').value = cita.servicio || '';
        }
        if (document.getElementById('edit_profesional')) {
            document.getElementById('edit_profesional').value = cita.profesional || '';
        }
        document.getElementById('edit_fecha').value = cita.fecha;
        document.getElementById('edit_hora').value = cita.hora.substring(0, 5);
        document.getElementById('edit_motivo').value = cita.motivo;
        document.getElementById('edit_estado').value = cita.estado;
        document.getElementById('modalEdit').classList.add('active');
    }

    // Modal azul de alerta R-32
    function mostrarAlertaAzul(mensaje, detalle = '') {
        document.getElementById('alertaAzulTexto').innerText = mensaje || 'El horario ya no se encuentra disponible.';
        document.getElementById('alertaAzulDetalle').innerText = detalle || '';
        document.getElementById('modalAlertaAzulHorario').style.display = 'flex';
    }

    function closeAlertaAzul() {
        document.getElementById('modalAlertaAzulHorario').style.display = 'none';
    }

    // Toggle para cliente existente vs nuevo
    let modoNuevoCliente = false;
    function toggleNuevoCliente() {
        modoNuevoCliente = !modoNuevoCliente;
        document.getElementById('boxClienteExistente').style.display = modoNuevoCliente ? 'none' : 'block';
        document.getElementById('boxNuevoCliente').style.display = modoNuevoCliente ? 'block' : 'none';
        document.getElementById('btnClientToggleText').innerText = modoNuevoCliente ? '← Seleccionar Cliente Existente' : '+ Registrar Nuevo Cliente Rápido';

        document.getElementById('pres_id_usuario').required = !modoNuevoCliente;
        document.getElementById('pres_cliente_nombre').required = modoNuevoCliente;
        document.getElementById('pres_cliente_telefono').required = modoNuevoCliente;
    }

    // Toggle para mascota existente vs nueva
    let modoNuevaMascota = false;
    function toggleNuevaMascota() {
        modoNuevaMascota = !modoNuevaMascota;
        document.getElementById('boxMascotaExistente').style.display = modoNuevaMascota ? 'none' : 'block';
        document.getElementById('boxNuevaMascota').style.display = modoNuevaMascota ? 'block' : 'none';
        document.getElementById('btnPetToggleText').innerText = modoNuevaMascota ? '← Seleccionar Mascota Existente' : '+ Registrar Nueva Mascota';

        document.getElementById('pres_id_mascota').required = !modoNuevaMascota;
        document.getElementById('pres_mascota_nombre').required = modoNuevaMascota;
        document.getElementById('pres_mascota_especie').required = modoNuevaMascota;
    }

    function actualizarMascotasDeCliente(userId) {
        const selectMascota = document.getElementById('pres_id_mascota');
        if (!selectMascota) return;

        let options = selectMascota.querySelectorAll('option');
        options.forEach(opt => {
            if (!opt.value) return;
            const owner = opt.getAttribute('data-owner');
            if (!userId || owner === userId) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });
    }

    // Cargar disponibilidad dinámica (R-31) en Agendamiento Regular
    function cargarDisponibilidadRegular() {
        const fecha = document.getElementById('fecha').value;
        const profesional = document.getElementById('reg_profesional').value;
        const servicio = document.getElementById('reg_servicio').value;
        const selectHora = document.getElementById('hora_select');

        if (!fecha) return;

        selectHora.innerHTML = '<option value="">Consultando disponibilidad...</option>';

        fetch(`/api/citas/disponibilidad?fecha=${fecha}&profesional=${encodeURIComponent(profesional)}&servicio=${encodeURIComponent(servicio)}`)
            .then(res => res.json())
            .then(data => {
                selectHora.innerHTML = '';
                if (!data.disponible || !data.slots || data.slots.length === 0) {
                    selectHora.innerHTML = '<option value="">No hay horarios disponibles</option>';
                    mostrarAlertaAzul(data.motivo_cierre || 'El horario ya no se encuentra disponible.');
                } else {
                    data.slots.forEach(slot => {
                        const opt = document.createElement('option');
                        opt.value = slot;
                        opt.textContent = slot;
                        selectHora.appendChild(opt);
                    });
                }
            })
            .catch(() => {
                selectHora.innerHTML = '<option value="09:00">09:00 AM</option><option value="10:00">10:00 AM</option>';
            });
    }

    // Cargar disponibilidad dinámica (R-31) en Agendamiento Presencial
    function cargarDisponibilidadPresencial() {
        const fecha = document.getElementById('pres_fecha').value;
        const profesional = document.getElementById('pres_profesional').value;
        const servicio = document.getElementById('pres_servicio').value;
        const selectHora = document.getElementById('pres_hora');
        const info = document.getElementById('pres_hora_info');

        if (!fecha) return;

        selectHora.innerHTML = '<option value="">Consultando disponibilidad...</option>';

        fetch(`/api/citas/disponibilidad?fecha=${fecha}&profesional=${encodeURIComponent(profesional)}&servicio=${encodeURIComponent(servicio)}`)
            .then(res => res.json())
            .then(data => {
                selectHora.innerHTML = '';
                if (!data.disponible || !data.slots || data.slots.length === 0) {
                    selectHora.innerHTML = '<option value="">No hay horarios disponibles</option>';
                    info.textContent = data.motivo_cierre || 'No hay horarios disponibles.';
                    mostrarAlertaAzul('El horario ya no se encuentra disponible.', data.motivo_cierre || '');
                } else {
                    info.textContent = `${data.slots.length} turnos disponibles respetando recesos y sin empalmes.`;
                    data.slots.forEach(slot => {
                        const opt = document.createElement('option');
                        opt.value = slot;
                        opt.textContent = slot;
                        selectHora.appendChild(opt);
                    });
                }
            })
            .catch(() => {
                selectHora.innerHTML = '<option value="">Error al cargar horarios</option>';
            });
    }

    // Auto-mostrar alerta azul si se disparó desde el backend (R-32)
    @if(session('horario_no_disponible_alerta'))
        window.addEventListener('DOMContentLoaded', function() {
            mostrarAlertaAzul(
                @json(session('horario_no_disponible_alerta')['mensaje']),
                @json(session('horario_no_disponible_alerta')['detalle'] ?? '')
            );
        });
    @endif
</script>
@endsection
