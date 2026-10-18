@extends('layouts.admin')

@section('title', 'VETecNM - Historial de ' . $mascota->nombre)
@section('header_title', 'Historial Clínico')

@section('content')

<style>
    /* =========================================================
     * 1. ESTILOS DE PANTALLA (INTERFAZ WEB ADMIN)
     * ========================================================= */
    .documento-formal {
        display: none; /* En pantalla no se muestra el formato impreso */
    }

    .historial-hero {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 60%, #0d9488 100%);
        border-radius: 16px;
        padding: 26px 30px;
        margin-bottom: 22px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }
    .historial-hero-left { display: flex; align-items: center; gap: 20px; }
    .historial-avatar {
        width: 68px; height: 68px;
        background: rgba(255,255,255,0.18);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem;
        border: 2px solid rgba(255,255,255,0.35);
        flex-shrink: 0;
    }
    .historial-hero h2 { margin: 0 0 4px 0; font-size: 1.55rem; font-weight: 800; }
    .historial-hero p { margin: 0; font-size: 0.88rem; opacity: 0.88; }
    .hero-meta { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px; }
    .hero-meta-item {
        display: flex; align-items: center; gap: 6px; font-size: 0.82rem;
        background: rgba(255,255,255,0.14); padding: 4px 12px; border-radius: 20px;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 18px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .stat-card .stat-num { font-size: 1.8rem; font-weight: 800; line-height: 1; margin-bottom: 4px; }
    .stat-card .stat-label { font-size: 0.76rem; color: #64748b; }

    .historial-table { width: 100%; border-collapse: collapse; background: #fff; }
    .historial-table th {
        background: #1e3a5f;
        color: #fff;
        padding: 11px 13px;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        text-align: left;
    }
    .historial-table td { padding: 11px 13px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 0.84rem; }
    .historial-table tr:hover td { background: #f8fafc; }

    .btn-pdf {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white; border: none; border-radius: 8px;
        padding: 9px 20px; font-size: 0.88rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        box-shadow: 0 4px 12px rgba(220,38,38,0.3);
        transition: all 0.2s;
    }
    .btn-pdf:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(220,38,38,0.4); color: white; }

    .cita-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.74rem; font-weight: 700; }
    .badge-Finalizada { background: #dbeafe; color: #1d4ed8; }
    .badge-Confirmada { background: #dcfce7; color: #15803d; }
    .badge-Pendiente  { background: #fef3c7; color: #92400e; }
    .badge-Cancelada  { background: #fee2e2; color: #991b1b; }

    .empty-state { text-align: center; padding: 50px 20px; color: #94a3b8; }
    .empty-state i { font-size: 3rem; margin-bottom: 14px; display: block; opacity: 0.4; }

    /* =========================================================
     * 2. ESTILOS DE IMPRESIÓN FORMAL (DOCUMENTO PDF)
     * ========================================================= */
    @media print {
        @page {
            size: letter portrait;
            margin: 12mm 15mm 15mm 15mm;
        }

        /* Ocultar la pantalla web completa y el layout de admin */
        .sidebar,
        .topbar,
        .pantalla-sistema,
        .main-wrapper > header,
        .no-print,
        .alert-toast,
        .modal-backdrop,
        footer {
            display: none !important;
            visibility: hidden !important;
        }

        /* Limpiar el contenedor del body */
        body {
            background: #ffffff !important;
            color: #000000 !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            font-family: 'Arial', 'Helvetica', sans-serif !important;
            font-size: 9.5pt !important;
            line-height: 1.35 !important;
        }

        .main-wrapper, .content-body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        /* MOSTRAR ÚNICAMENTE EL DOCUMENTO FORMAL */
        .documento-formal {
            display: block !important;
            visibility: visible !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            color: #111827 !important;
        }

        /* Elementos del Documento Formal */
        .doc-header {
            border-bottom: 2pt solid #1e3a5f;
            padding-bottom: 8pt;
            margin-bottom: 12pt;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .doc-institucional h1 {
            font-size: 13pt;
            font-weight: bold;
            color: #1e3a5f;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .doc-institucional h2 {
            font-size: 10pt;
            font-weight: 600;
            color: #334155;
            margin: 2pt 0 0 0;
        }
        .doc-institucional p {
            font-size: 8pt;
            color: #64748b;
            margin: 2pt 0 0 0;
        }

        .doc-control {
            text-align: right;
            font-size: 8pt;
            color: #334155;
            line-height: 1.4;
        }
        .doc-control .folio {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0f172a;
        }

        .doc-titulo-seccion {
            background: #f1f5f9;
            border-left: 4pt solid #1e3a5f;
            padding: 5pt 8pt;
            font-size: 10pt;
            font-weight: bold;
            color: #1e3a5f;
            text-transform: uppercase;
            margin-bottom: 8pt;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Cédula de datos (Mascota y Propietario) */
        .doc-ficha-tabla {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-bottom: 14pt;
        }
        .doc-ficha-tabla td {
            padding: 4pt 7pt;
            border: 1pt solid #cbd5e1;
            vertical-align: middle;
        }
        .doc-ficha-tabla .lbl {
            background: #f8fafc;
            font-weight: bold;
            color: #334155;
            width: 18%;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .doc-ficha-tabla .val {
            color: #0f172a;
            width: 32%;
        }

        /* Tabla formal de consultas */
        .doc-tabla-citas {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.2pt;
            margin-bottom: 14pt;
        }
        .doc-tabla-citas th {
            background: #1e3a5f !important;
            color: #ffffff !important;
            font-weight: bold;
            font-size: 7.8pt;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 5pt 6pt;
            border: 1pt solid #1e3a5f;
            text-align: left;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .doc-tabla-citas td {
            padding: 5pt 6pt;
            border: 1pt solid #cbd5e1;
            vertical-align: top;
            color: #1e293b;
        }
        .doc-tabla-citas tr:nth-child(even) td {
            background: #f8fafc !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .doc-tabla-citas tr {
            page-break-inside: avoid;
        }

        /* Resumen formal */
        .doc-resumen {
            display: flex;
            justify-content: space-between;
            background: #f8fafc;
            border: 1pt solid #cbd5e1;
            padding: 6pt 10pt;
            font-size: 8.5pt;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 22pt;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            page-break-inside: avoid;
        }

        /* Sección de Firmas */
        .doc-firmas {
            display: flex;
            justify-content: space-around;
            margin-top: 35pt;
            margin-bottom: 15pt;
            page-break-inside: avoid;
        }
        .doc-firma-box {
            text-align: center;
            width: 40%;
        }
        .doc-firma-linea {
            border-top: 1pt solid #000;
            margin-bottom: 4pt;
            padding-top: 3pt;
        }
        .doc-firma-titulo {
            font-size: 8pt;
            font-weight: bold;
            color: #0f172a;
        }
        .doc-firma-sub {
            font-size: 7.2pt;
            color: #64748b;
        }

        /* Pie formal */
        .doc-footer {
            border-top: 1pt solid #cbd5e1;
            padding-top: 5pt;
            font-size: 7pt;
            color: #64748b;
            text-align: center;
            line-height: 1.4;
            page-break-inside: avoid;
        }
    }
</style>

{{-- =========================================================
     CAPA 1: PANTALLA SISTEMA (Solo visible en el navegador)
     ========================================================= --}}
<div class="pantalla-sistema">

    {{-- Hero Card Mascota --}}
    <div class="historial-hero">
        <div class="historial-hero-left">
            <div class="historial-avatar">
                @if(strtolower($mascota->especie) === 'gato') 🐱
                @elseif(strtolower($mascota->especie) === 'ave') 🐦
                @elseif(strtolower($mascota->especie) === 'conejo') 🐰
                @elseif(strtolower($mascota->especie) === 'reptil') 🦎
                @else 🐶
                @endif
            </div>
            <div>
                <h2>{{ $mascota->nombre }}</h2>
                <p>{{ $mascota->especie }}{{ $mascota->raza ? ' · ' . $mascota->raza : '' }}{{ $mascota->peso ? ' · ' . $mascota->peso . ' kg' : '' }}</p>
                <div class="hero-meta">
                    <span class="hero-meta-item"><i class="fa-solid fa-user"></i> {{ $mascota->dueno_nombre }}</span>
                    @if($mascota->dueno_email)
                        <span class="hero-meta-item"><i class="fa-solid fa-envelope"></i> {{ $mascota->dueno_email }}</span>
                    @endif
                    @if(!empty($mascota->dueno_telefono))
                        <span class="hero-meta-item"><i class="fa-solid fa-phone"></i> {{ $mascota->dueno_telefono }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
            <button type="button" class="btn-pdf" onclick="descargarPDF()">
                <i class="fa-solid fa-file-pdf"></i> Descargar PDF
            </button>
            <a href="{{ route('admin.mascotas.index') }}" class="btn-action" style="background:rgba(255,255,255,0.18); color:white; border:1px solid rgba(255,255,255,0.35);">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    {{-- Estadísticas rápidas --}}
    @php
        $totalCitas   = $citas->count();
        $finalizadas  = $citas->where('estado', 'Finalizada')->count();
        $confirmadas  = $citas->where('estado', 'Confirmada')->count();
        $pendientes   = $citas->where('estado', 'Pendiente')->count();
        $canceladas   = $citas->where('estado', 'Cancelada')->count();
        $totalGastado = $citas->whereIn('estado', ['Finalizada', 'Confirmada'])->sum('precio');
    @endphp

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num" style="color:#1e3a5f;">{{ $totalCitas }}</div>
            <div class="stat-label">Consultas Totales</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#1d4ed8;">{{ $finalizadas }}</div>
            <div class="stat-label">Finalizadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#15803d;">{{ $confirmadas }}</div>
            <div class="stat-label">Confirmadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#92400e;">{{ $pendientes }}</div>
            <div class="stat-label">Pendientes</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#991b1b;">{{ $canceladas }}</div>
            <div class="stat-label">Canceladas</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#059669; font-size:1.4rem;">${{ number_format($totalGastado, 2) }}</div>
            <div class="stat-label">Total Facturado MXN</div>
        </div>
    </div>

    {{-- Tabla web interactiva --}}
    <div class="card-custom">
        <div class="card-header-flex" style="margin-bottom:16px;">
            <div>
                <h3 style="font-size:1.1rem; font-weight:700;"><i class="fa-solid fa-clock-rotate-left" style="color:#2563eb;"></i> Historial de Consultas Médicas</h3>
                <span style="font-size:0.83rem; color:#64748b;">Expediente de citas para <strong>{{ $mascota->nombre }}</strong></span>
            </div>
            <button type="button" class="btn-pdf" onclick="descargarPDF()">
                <i class="fa-solid fa-file-pdf"></i> Descargar PDF
            </button>
        </div>

        @if($citas->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-calendar-xmark"></i>
                <p style="font-size:1.05rem; font-weight:600; color:#475569;">Sin consultas registradas</p>
                <p style="font-size:0.85rem;">{{ $mascota->nombre }} aún no tiene historial de citas en el sistema.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="historial-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Servicio</th>
                            <th>Profesional</th>
                            <th>Motivo / Notas</th>
                            <th>Canal</th>
                            <th>Precio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citas as $c)
                            <tr>
                                <td><strong style="color:#1e3a5f;">#{{ $c->id_cita }}</strong></td>
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</strong><br>
                                    <span style="font-size:0.75rem; color:#94a3b8;">{{ \Carbon\Carbon::parse($c->fecha)->isoFormat('dddd') }}</span>
                                </td>
                                <td>
                                    <span style="color:#2563eb; font-weight:700;">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}
                                    </span>
                                </td>
                                <td><strong style="font-size:0.85rem;">{{ $c->servicio ?? 'Consulta Médica General' }}</strong></td>
                                <td>
                                    @if($c->profesional)
                                        <span style="font-size:0.82rem;"><i class="fa-solid fa-user-doctor" style="color:#0d9488;"></i> {{ $c->profesional }}</span>
                                    @else
                                        <span style="color:#94a3b8; font-size:0.82rem;">Sin asignar</span>
                                    @endif
                                </td>
                                <td style="max-width:200px;">
                                    <span style="font-size:0.82rem;">{{ $c->motivo }}</span>
                                    @if(!empty($c->notas))
                                        <br><span style="font-size:0.75rem; color:#64748b; font-style:italic;"><i class="fa-solid fa-note-sticky"></i> {{ $c->notas }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(($c->canal ?? 'web') === 'presencial')
                                        <span style="font-size:0.75rem; background:#e0f2fe; color:#0369a1; padding:2px 8px; border-radius:10px; white-space:nowrap;"><i class="fa-solid fa-building"></i> Presencial</span>
                                    @elseif(($c->canal ?? 'web') === 'telefono')
                                        <span style="font-size:0.75rem; background:#fef3c7; color:#92400e; padding:2px 8px; border-radius:10px; white-space:nowrap;"><i class="fa-solid fa-phone"></i> Teléfono</span>
                                    @else
                                        <span style="font-size:0.75rem; background:#f1f5f9; color:#475569; padding:2px 8px; border-radius:10px; white-space:nowrap;"><i class="fa-solid fa-globe"></i> En Línea</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-weight:700; color:#059669; font-size:0.85rem; white-space:nowrap;">
                                        ${{ number_format($c->precio ?? 0, 2) }} MXN
                                    </span>
                                </td>
                                <td>
                                    <span class="cita-badge badge-{{ $c->estado }}">{{ $c->estado }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

{{-- =========================================================
     CAPA 2: DOCUMENTO FORMAL DE IMPRESIÓN / PDF
     (Solo se imprime este bloque formal con datos institucionales)
     ========================================================= --}}
<div class="documento-formal">

    {{-- Membrete Oficial --}}
    <div class="doc-header">
        <div class="doc-institucional">
            <h1>Clínica Veterinaria Universitaria · VETecNM</h1>
            <h2>Área de Servicios Médicos Veterinarios y Salud Animal</h2>
            <p>Tecnológico Nacional de México · Campus Central · Tel: (771) 000-0000 · contacto@vetecnm.mx</p>
        </div>
        <div class="doc-control">
            <div class="folio">EXPEDIENTE N° #EXP-{{ str_pad($mascota->id_mascota, 5, '0', STR_PAD_LEFT) }}</div>
            <div>Fecha de Emisión: <strong>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong></div>
            <div>Hora: {{ \Carbon\Carbon::now()->format('H:i') }} hrs</div>
        </div>
    </div>

    {{-- Título de la Ficha --}}
    <div class="doc-titulo-seccion">
        Expediente Clínico y Registro Histórico de Atenciones
    </div>

    {{-- Cédula de Identificación del Paciente y Propietario --}}
    <table class="doc-ficha-tabla">
        <tr>
            <td class="lbl">Paciente:</td>
            <td class="val"><strong>{{ $mascota->nombre }}</strong></td>
            <td class="lbl">Especie / Raza:</td>
            <td class="val">{{ $mascota->especie }}{{ $mascota->raza ? ' · ' . $mascota->raza : '' }}</td>
        </tr>
        <tr>
            <td class="lbl">Propietario:</td>
            <td class="val">{{ $mascota->dueno_nombre }}</td>
            <td class="lbl">Peso Registrado:</td>
            <td class="val">{{ $mascota->peso ? $mascota->peso . ' kg' : 'No registrado' }}</td>
        </tr>
        <tr>
            <td class="lbl">Teléfono:</td>
            <td class="val">{{ $mascota->dueno_telefono ?: 'No registrado' }}</td>
            <td class="lbl">Correo Electrónico:</td>
            <td class="val">{{ $mascota->dueno_email ?: 'No registrado' }}</td>
        </tr>
    </table>

    {{-- Título de la Tabla de Consultas --}}
    <div class="doc-titulo-seccion">
        Detalle Cronológico de Consultas Médicas
    </div>

    {{-- Tabla Formal de Citas --}}
    <table class="doc-tabla-citas">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 14%;">Fecha y Hora</th>
                <th style="width: 18%;">Servicio Clínico</th>
                <th style="width: 18%;">Médico / Profesional</th>
                <th style="width: 27%;">Motivo / Observaciones Médicas</th>
                <th style="width: 8%; text-align:right;">Importe</th>
                <th style="width: 10%; text-align:center;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citas as $c)
                <tr>
                    <td><strong>#{{ $c->id_cita }}</strong></td>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</strong><br>
                        <span style="color:#475569; font-size:7.5pt;">{{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}</span>
                    </td>
                    <td><strong>{{ $c->servicio ?? 'Consulta General' }}</strong></td>
                    <td>{{ $c->profesional ?: 'No asignado' }}</td>
                    <td>
                        <div>{{ $c->motivo }}</div>
                        @if(!empty($c->notas))
                            <div style="font-size:7.5pt; color:#475569; margin-top:2pt; font-style:italic;">
                                <strong>Obs:</strong> {{ $c->notas }}
                            </div>
                        @endif
                    </td>
                    <td style="text-align:right; font-weight:bold;">
                        ${{ number_format($c->precio ?? 0, 2) }}
                    </td>
                    <td style="text-align:center;">
                        <strong>{{ $c->estado }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:12pt; color:#64748b;">
                        No se registran antecedentes de consultas médicas para este paciente.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Resumen Estadístico Formal --}}
    <div class="doc-resumen">
        <span>Total de Consultas Registradas: {{ $totalCitas }} (Completadas: {{ $finalizadas }}, Confirmadas: {{ $confirmadas }}, Pendientes: {{ $pendientes }})</span>
        <span>Monto Total Facturado: ${{ number_format($totalGastado, 2) }} MXN</span>
    </div>

    {{-- Firmas Oficiales --}}
    <div class="doc-firmas">
        <div class="doc-firma-box">
            <div class="doc-firma-linea"></div>
            <div class="doc-firma-titulo">M.V.Z. Responsable de Turno</div>
            <div class="doc-firma-sub">Firma y Cédula Profesional</div>
        </div>
        <div class="doc-firma-box">
            <div class="doc-firma-linea"></div>
            <div class="doc-firma-titulo">{{ $mascota->dueno_nombre }}</div>
            <div class="doc-firma-sub">Firma de Conformidad del Propietario</div>
        </div>
    </div>

    {{-- Pie de Página Formal --}}
    <div class="doc-footer">
        Documento oficial emitido por el Sistema de Gestión Clínica Veterinaria VETecNM.<br>
        Este historial es confidencial y para uso exclusivo del propietario y del personal médico veterinario autorizado.
    </div>

</div>

@endsection

@section('scripts')
<script>
    function descargarPDF() {
        const tituloOriginal = document.title;
        document.title = 'Expediente_Clinico_{{ preg_replace("/[^A-Za-z0-9]/", "_", $mascota->nombre) }}_{{ now()->format("Ymd") }}';
        window.print();
        document.title = tituloOriginal;
    }
</script>
@endsection
