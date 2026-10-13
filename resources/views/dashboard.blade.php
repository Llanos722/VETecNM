<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VETecNM - Panel Principal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body {
            display: block;
            background-color: #f1f5f9;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
        .navbar {
            background-color: var(--primary-color, #1e3a8a);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-admin-link {
            background: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
        }
        .btn-admin-link:hover {
            background: #1d4ed8;
        }
        .btn-logout {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
        }
        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .welcome-card {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .data-table th, .data-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .data-table th {
            background: #f8fafc;
            color: var(--primary-color, #1e3a8a);
            font-weight: 600;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-admin { background: #dbeafe; color: #1e40af; }
        .badge-cliente { background: #fef3c7; color: #92400e; }
        .badge-confirmada { background: #dcfce7; color: #166534; }
        .badge-pendiente { background: #fef9c3; color: #854d0e; }
        .badge-finalizada { background: #e0f2fe; color: #075985; }
        .badge-cancelada { background: #fee2e2; color: #991b1b; }

        /* Action Buttons */
        .btn-schedule-main {
            background: #0284c7;
            color: white;
            border: none;
            padding: 0.65rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .btn-schedule-main:hover {
            background: #0369a1;
        }

        .btn-secondary-custom {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            padding: 0.65rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-secondary-custom:hover {
            background: #e2e8f0;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-card {
            background: white;
            border-radius: 14px;
            max-width: 620px;
            width: 100%;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.8rem;
        }
        .modal-header h3 {
            margin: 0;
            color: #0f172a;
            font-size: 1.2rem;
        }
        .modal-close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #94a3b8;
        }
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .input-group-modern {
            margin-bottom: 1rem;
        }
        .input-group-modern label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .input-group-modern input, .input-group-modern select, .input-group-modern textarea {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.92rem;
            box-sizing: border-box;
        }
        .input-group-modern input:focus, .input-group-modern select:focus, .input-group-modern textarea:focus {
            outline: none;
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        /* Estilos de la ventana azul de alerta (R-32) */
        .modal-backdrop-blue {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-blue-modal:hover {
            background: #f8fafc;
        }
        @keyframes popIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fa-solid fa-dog"></i>
            <span>VETecNM</span>
        </div>
        <div class="user-menu">
            <a href="{{ route('home') }}" style="color: white; text-decoration: none; font-size: 0.9rem; margin-right: 10px;">
                <i class="fa-solid fa-globe"></i> Ver Portal
            </a>
            @if(session('user_rol') === 'admin' || session('user_rol') === 'recepcionista')
                <a href="{{ route('admin.dashboard') }}" class="btn-admin-link">
                    <i class="fa-solid fa-user-shield"></i> Panel Staff / Admin
                </a>
            @endif
            <span><i class="fa-regular fa-user"></i> {{ session('user_nombre', 'Usuario') }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
            </form>
        </div>
    </nav>

    <div class="container">
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

        @if(session('error'))
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 1.2rem; color: #ef4444;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('user_rol') === 'admin' || session('user_rol') === 'recepcionista')
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 1rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <span><i class="fa-solid fa-shield-halved"></i> <strong>Modo {{ ucfirst(session('user_rol')) }} Activo:</strong> Tienes acceso para gestionar citas y atención médica.</span>
                <a href="{{ route('admin.citas.index') }}" class="btn-admin-link">Ir a Gestión de Citas <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endif

        <!-- Card de Bienvenida & Acciones Principales -->
        <div class="welcome-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="margin: 0 0 6px 0; color: #0f172a;">Hola, {{ session('user_nombre') }} 👋</h2>
                    <p style="color: #64748b; margin: 0;">Gestiona tus mascotas y agenda citas médicas veterinarias con nuestros profesionales.</p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <!-- R-30: BOTÓN AGENDAR CITA PARA CLIENTES REGISTRADOS -->
                    <button type="button" class="btn-schedule-main" onclick="openAgendarModal()">
                        <i class="fa-solid fa-calendar-plus"></i> Agendar Cita (R-30)
                    </button>
                    <button type="button" class="btn-secondary-custom" onclick="openPetModal()">
                        <i class="fa-solid fa-paw"></i> Registrar Mascota
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-paw"></i></div>
                    <div class="stat-info">
                        <h3>{{ $misMascotas->count() }}</h3>
                        <p>Mis Mascotas</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="stat-info">
                        <h3>{{ $citas->count() }}</h3>
                        <p>Mis Citas Agendadas</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-user-doctor"></i></div>
                    <div class="stat-info">
                        <h3>{{ count($profesionales) }}</h3>
                        <p>Especialistas Médicos</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Citas del Cliente (R-30) -->
        <div class="welcome-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="margin: 0; color: #0f172a;"><i class="fa-solid fa-calendar-days" style="color: #0284c7;"></i> Mis Citas Veterinarias</h3>
                <button type="button" class="btn-schedule-main" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;" onclick="openAgendarModal()">
                    <i class="fa-solid fa-plus"></i> Nueva Cita
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Mascota</th>
                            <th>Servicio Solicitado</th>
                            <th>Especialista Asignado</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($citas as $c)
                            <tr>
                                <td><strong>#{{ $c->id_cita }}</strong></td>
                                <td>
                                    <strong><i class="fa-solid fa-paw" style="color: #64748b;"></i> {{ $c->mascota_nombre }}</strong>
                                    <span style="font-size: 0.78rem; color: #64748b;">({{ $c->especie }})</span>
                                </td>
                                <td>{{ $c->servicio ?? $c->motivo }}</td>
                                <td>
                                    <span style="color: #0369a1; font-weight: 500;">
                                        <i class="fa-solid fa-user-doctor"></i> {{ $c->profesional ?? 'Equipo Médico General' }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</td>
                                <td><strong>{{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}</strong></td>
                                <td>
                                    <span class="badge badge-{{ strtolower($c->estado) }}">{{ $c->estado }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2rem;">
                                    Aún no tienes citas agendadas. Haz clic en <strong>Agendar Cita</strong> para programar una consulta.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         MODAL R-30: AGENDAMIENTO DE CITAS PARA CLIENTES REGISTRADOS
         Selecciona: servicio, profesional de salud/estética, mascota, fecha y hora
         ========================================================================= -->
    <div id="modalAgendarCliente" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div>
                    <h3><i class="fa-solid fa-calendar-plus" style="color: #0284c7;"></i> Agendar Cita Médica (R-30)</h3>
                    <span style="font-size: 0.82rem; color: #64748b;">Selecciona servicio, especialista, tu mascota, fecha y horario disponible.</span>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeAgendarModal()">&times;</button>
            </div>

            @if($misMascotas->isEmpty())
                <div style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 1rem; border-radius: 8px; margin-bottom: 1.2rem;">
                    <strong><i class="fa-solid fa-circle-info"></i> Registra primero una mascota</strong>
                    <p style="margin: 4px 0 10px 0; font-size: 0.88rem;">Para agendar una cita necesitas tener al menos una mascota registrada en tu perfil.</p>
                    <button type="button" class="btn-schedule-main" onclick="closeAgendarModal(); openPetModal();">Registrar mi mascota ahora</button>
                </div>
            @endif

            <form action="{{ route('citas.agendar.cliente') }}" method="POST">
                @csrf

                <!-- Mascota que asistirá (R-30) -->
                <div class="input-group-modern">
                    <label for="cli_id_mascota"><i class="fa-solid fa-paw"></i> Mascota que asistirá a la cita *</label>
                    <select name="id_mascota" id="cli_id_mascota" required>
                        <option value="">-- Selecciona tu mascota --</option>
                        @foreach($misMascotas as $m)
                            <option value="{{ $m->id_mascota }}">{{ $m->nombre }} ({{ $m->especie }} - {{ $m->raza ?? 'Mestizo' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-grid-2">
                    <!-- Servicio (R-30) -->
                    <div class="input-group-modern">
                        <label for="cli_servicio"><i class="fa-solid fa-stethoscope"></i> Servicio Requerido *</label>
                        <select name="servicio" id="cli_servicio" required onchange="cargarHorariosCliente()">
                            <option value="">-- Seleccionar Servicio --</option>
                            @foreach($serviciosDisponibles as $catNombre => $srvList)
                                <optgroup label="{{ $catNombre }}">
                                    @foreach($srvList as $srv)
                                        <option value="{{ $srv }}">{{ $srv }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- Profesional de Salud / Estética (R-30) -->
                    <div class="input-group-modern">
                        <label for="cli_profesional"><i class="fa-solid fa-user-doctor"></i> Profesional de Salud/Estética *</label>
                        <select name="profesional" id="cli_profesional" required onchange="cargarHorariosCliente()">
                            <option value="">-- Seleccionar Especialista --</option>
                            @foreach($profesionales as $p)
                                <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Fecha deseada (R-30) -->
                    <div class="input-group-modern">
                        <label for="cli_fecha"><i class="fa-regular fa-calendar"></i> Fecha de la Cita *</label>
                        <input type="date" name="fecha" id="cli_fecha" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required onchange="cargarHorariosCliente()">
                    </div>

                    <!-- Horario disponible dinámico (R-31, Regla de 30 minutos) -->
                    <div class="input-group-modern">
                        <label for="cli_hora"><i class="fa-regular fa-clock"></i> Horario Disponible (R-31) *</label>
                        <select name="hora" id="cli_hora" required>
                            <option value="">-- Selecciona fecha y profesional --</option>
                        </select>
                    </div>
                </div>

                <small id="cli_hora_info" style="color: #64748b; font-size: 0.78rem; display: block; margin-top: -6px; margin-bottom: 12px;">
                    Horarios calculados según disponibilidad laboral, recesos y anticipación mínima de 30 minutos.
                </small>

                <!-- Motivo / Síntomas -->
                <div class="input-group-modern">
                    <label for="cli_motivo"><i class="fa-solid fa-notes-medical"></i> Motivo de la Consulta / Observaciones</label>
                    <textarea name="motivo" id="cli_motivo" rows="2" placeholder="Describe brevemente síntomas o cualquier solicitud especial para el especialista..."></textarea>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;">
                    <button type="button" class="btn-secondary-custom" onclick="closeAgendarModal()">Cancelar</button>
                    <button type="submit" class="btn-schedule-main">
                        <i class="fa-solid fa-calendar-check"></i> Confirmar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =========================================================================
         MODAL REGISTRAR MASCOTA
         ========================================================================= -->
    <div id="modalRegistrarMascota" class="modal-overlay">
        <div class="modal-card" style="max-width: 480px;">
            <div class="modal-header">
                <h3><i class="fa-solid fa-paw" style="color: #059669;"></i> Registrar Mascota</h3>
                <button type="button" class="modal-close-btn" onclick="closePetModal()">&times;</button>
            </div>
            <form action="{{ route('dashboard') }}/mascota" method="POST">
                @csrf
                <div class="input-group-modern">
                    <label>Nombre de la Mascota *</label>
                    <input type="text" name="nombre" placeholder="Ej: Max, Luna, Bobby" required>
                </div>
                <div class="form-grid-2">
                    <div class="input-group-modern">
                        <label>Especie *</label>
                        <select name="especie" required>
                            <option value="Perro">Perro</option>
                            <option value="Gato">Gato</option>
                            <option value="Ave">Ave</option>
                            <option value="Conejo">Conejo</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="input-group-modern">
                        <label>Raza</label>
                        <input type="text" name="raza" placeholder="Ej: Labrador, Siames">
                    </div>
                </div>
                <div class="input-group-modern">
                    <label>Peso en Kg (Opcional)</label>
                    <input type="number" step="0.01" name="peso" placeholder="Ej: 12.5">
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;">
                    <button type="button" class="btn-secondary-custom" onclick="closePetModal()">Cancelar</button>
                    <button type="submit" class="btn-schedule-main" style="background: #059669;">Guardar Mascota</button>
                </div>
            </form>
        </div>
    </div>

    <!-- =========================================================================
         R-32 REQUISITO VISUAL EXPLÍCITO:
         "emergerá una ventana de color azul con icono de alerta blanco notificando
         que el horario ya no se encuentra disponible."
         ========================================================================= -->
    <div id="modalAlertaAzulCliente" class="modal-backdrop-blue" style="display: none;">
        <div class="modal-card-blue">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem auto; border: 2px solid rgba(255,255,255,0.5);">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 3rem; color: #ffffff;"></i>
                </div>
                <h3 style="color: #ffffff; font-size: 1.5rem; margin: 0 0 8px 0; font-weight: 700;">
                    ¡Horario No Disponible!
                </h3>
                <p id="alertaAzulTextoCli" style="color: #e0f2fe; font-size: 1.05rem; line-height: 1.5; margin: 0;">
                    El horario ya no se encuentra disponible.
                </p>
                <p id="alertaAzulDetalleCli" style="color: #bae6fd; font-size: 0.88rem; margin-top: 10px; font-style: italic;">
                </p>
            </div>
            <div style="text-align: center;">
                <button type="button" class="btn-blue-modal" onclick="closeAlertaAzulCli()">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Entendido, Seleccionar Otro Horario
                </button>
            </div>
        </div>
    </div>

    <script>
        function openAgendarModal() {
            document.getElementById('modalAgendarCliente').classList.add('active');
            cargarHorariosCliente();
        }

        function closeAgendarModal() {
            document.getElementById('modalAgendarCliente').classList.remove('active');
        }

        function openPetModal() {
            document.getElementById('modalRegistrarMascota').classList.add('active');
        }

        function closePetModal() {
            document.getElementById('modalRegistrarMascota').classList.remove('active');
        }

        function mostrarAlertaAzulCli(mensaje, detalle = '') {
            document.getElementById('alertaAzulTextoCli').innerText = mensaje || 'El horario ya no se encuentra disponible.';
            document.getElementById('alertaAzulDetalleCli').innerText = detalle || '';
            document.getElementById('modalAlertaAzulCliente').style.display = 'flex';
        }

        function closeAlertaAzulCli() {
            document.getElementById('modalAlertaAzulCliente').style.display = 'none';
        }

        // Cargar horarios dinámicos para clientes (R-31)
        function cargarHorariosCliente() {
            const fecha = document.getElementById('cli_fecha').value;
            const profesional = document.getElementById('cli_profesional').value;
            const servicio = document.getElementById('cli_servicio').value;
            const selectHora = document.getElementById('cli_hora');
            const info = document.getElementById('cli_hora_info');

            if (!fecha) return;

            selectHora.innerHTML = '<option value="">Consultando disponibilidad...</option>';

            fetch(`/api/citas/disponibilidad?fecha=${fecha}&profesional=${encodeURIComponent(profesional)}&servicio=${encodeURIComponent(servicio)}`)
                .then(res => res.json())
                .then(data => {
                    selectHora.innerHTML = '';
                    if (!data.disponible || !data.slots || data.slots.length === 0) {
                        selectHora.innerHTML = '<option value="">No hay horarios disponibles</option>';
                        info.textContent = data.motivo_cierre || 'No hay horarios disponibles en esta fecha.';
                        mostrarAlertaAzulCli('El horario ya no se encuentra disponible.', data.motivo_cierre || 'Por favor selecciona otra fecha o profesional.');
                    } else {
                        info.textContent = `${data.slots.length} turnos disponibles para este profesional y fecha.`;
                        data.slots.forEach(slot => {
                            const opt = document.createElement('option');
                            opt.value = slot;
                            opt.textContent = slot;
                            selectHora.appendChild(opt);
                        });
                    }
                })
                .catch(() => {
                    selectHora.innerHTML = '<option value="">Error al cargar turnos</option>';
                });
        }

        // Alerta azul si el backend la envía en sesión (R-32)
        @if(session('horario_no_disponible_alerta'))
            window.addEventListener('DOMContentLoaded', function() {
                mostrarAlertaAzulCli(
                    @json(session('horario_no_disponible_alerta')['mensaje']),
                    @json(session('horario_no_disponible_alerta')['detalle'] ?? '')
                );
            });
        @endif
    </script>
</body>
</html>
