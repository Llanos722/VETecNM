<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Citas — {{ \Carbon\Carbon::parse($fecha)->isoFormat('dddd D [de] MMMM [de] YYYY') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* =========================================================
         * RESET & BASE
         * ========================================================= */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #cbd5e1;
            color: #0f172a;
            font-size: 12.5px;
            line-height: 1.35;
        }

        /* =========================================================
         * BARRA SUPERIOR DE HERRAMIENTAS (Solo en pantalla)
         * ========================================================= */
        .screen-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            background: #0f172a;
            padding: 10px 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.25);
        }
        .toolbar-brand {
            font-size: 0.95rem; font-weight: 800; color: #fff;
            display: flex; align-items: center; gap: 8px;
        }
        .toolbar-brand span { color: #38bdf8; }
        .toolbar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .tb-btn {
            display: inline-flex; align-items: center; gap: 6px;
            border: none; border-radius: 6px; padding: 7px 14px;
            font-size: 0.82rem; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: all 0.18s;
        }
        .tb-btn-pdf {
            background: #dc2626; color: #fff;
        }
        .tb-btn-pdf:hover { background: #b91c1c; }
        .tb-btn-back {
            background: #334155; color: #e2e8f0;
        }
        .tb-btn-back:hover { background: #475569; color: #fff; }
        .tb-date-form {
            display: flex; align-items: center; gap: 6px;
        }
        .tb-date-form label { color: #94a3b8; font-size: 0.78rem; }
        .tb-date-form input[type="date"] {
            padding: 6px 9px; border-radius: 6px;
            border: 1px solid #475569; background: #1e293b;
            color: #f1f5f9; font-size: 0.8rem; outline: none;
        }
        .tb-date-form button {
            padding: 6px 12px; border-radius: 6px; border: none;
            background: #2563eb; color: #fff; font-size: 0.8rem;
            font-weight: 600; cursor: pointer;
        }
        .tb-date-form button:hover { background: #1d4ed8; }

        /* =========================================================
         * HOJA DE DOCUMENTO FORMAL (Proporción Vertical / Carta)
         * ========================================================= */
        .documento-hoja-wrap {
            max-width: 860px; /* Ancho proporción vertical */
            margin: 24px auto 40px;
            padding: 0 16px;
        }
        .documento-hoja {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            padding: 38px 42px;
            border-radius: 4px;
        }

        /* Membrete Oficial */
        .doc-header {
            border-bottom: 2pt solid #1e3a5f;
            padding-bottom: 10px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }
        .doc-inst h1 {
            font-size: 1.15rem;
            font-weight: 800;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin-bottom: 2px;
        }
        .doc-inst h2 {
            font-size: 0.86rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 2px;
        }
        .doc-inst p {
            font-size: 0.74rem;
            color: #64748b;
        }

        .doc-meta {
            text-align: right;
            font-size: 0.74rem;
            color: #334155;
            line-height: 1.45;
            min-width: 200px;
        }
        .doc-meta .tipo {
            font-weight: 800;
            color: #0f172a;
            font-size: 0.82rem;
            text-transform: uppercase;
        }

        /* Título del reporte */
        .doc-titulo-banda {
            background: #f1f5f9;
            border-left: 4px solid #1e3a5f;
            padding: 7px 12px;
            font-size: 0.92rem;
            font-weight: 800;
            color: #1e3a5f;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .doc-titulo-banda .fecha-sub {
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            text-transform: none;
        }

        /* Ficha resumen ejecutiva */
        .doc-resumen-tabla {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.76rem;
            margin-bottom: 14px;
        }
        .doc-resumen-tabla td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: center;
        }
        .doc-resumen-tabla .lbl {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
        }
        .doc-resumen-tabla .val {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0f172a;
        }

        /* Tabla oficial de citas (optimizada para formato vertical) */
        .doc-tabla-datos {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.74rem;
            margin-bottom: 16px;
        }
        .doc-tabla-datos th {
            background: #1e3a5f;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 6px 7px;
            border: 1px solid #1e3a5f;
            text-align: left;
        }
        .doc-tabla-datos td {
            padding: 6px 7px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
            color: #1e293b;
            line-height: 1.3;
        }
        .doc-tabla-datos tr:nth-child(even) td {
            background: #f8fafc;
        }

        .estado-chip {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.68rem;
            font-weight: 700;
            border: 1px solid #cbd5e1;
            text-align: center;
        }

        /* Área de firmas */
        .doc-firmas {
            display: flex;
            justify-content: space-around;
            margin-top: 36px;
            margin-bottom: 14px;
            page-break-inside: avoid;
        }
        .doc-firma-col {
            width: 42%;
            text-align: center;
        }
        .doc-firma-linea {
            border-top: 1px solid #000;
            margin-bottom: 4px;
            padding-top: 3px;
        }
        .doc-firma-cargo {
            font-size: 0.75rem;
            font-weight: 700;
            color: #0f172a;
        }
        .doc-firma-sub {
            font-size: 0.68rem;
            color: #64748b;
        }

        /* Pie de página */
        .doc-footer {
            border-top: 1px solid #cbd5e1;
            padding-top: 6px;
            font-size: 0.66rem;
            color: #64748b;
            text-align: center;
            line-height: 1.4;
            page-break-inside: avoid;
        }

        /* =========================================================
         * ESTILOS DE IMPRESIÓN (PDF FORMAL EN ORIENTACIÓN VERTICAL)
         * ========================================================= */
        @media print {
            @page {
                size: letter portrait; /* <-- FORMATO VERTICAL */
                margin: 12mm 12mm 12mm 12mm;
            }

            /* Ocultar barra superior y cualquier otro elemento web */
            .screen-toolbar,
            .no-print {
                display: none !important;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
                font-family: Arial, Helvetica, sans-serif !important;
                font-size: 8pt !important;
            }

            .documento-hoja-wrap {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .documento-hoja {
                box-shadow: none !important;
                padding: 0 !important;
                border-radius: 0 !important;
            }

            .doc-header {
                border-bottom: 2pt solid #1e3a5f !important;
                padding-bottom: 6pt !important;
                margin-bottom: 8pt !important;
            }
            .doc-inst h1 { font-size: 11pt !important; color: #1e3a5f !important; }
            .doc-inst h2 { font-size: 8.5pt !important; color: #334155 !important; }
            .doc-inst p { font-size: 7pt !important; color: #64748b !important; }
            .doc-meta { font-size: 7pt !important; }

            .doc-titulo-banda {
                background: #f1f5f9 !important;
                border-left: 3pt solid #1e3a5f !important;
                padding: 4pt 7pt !important;
                font-size: 8.5pt !important;
                margin-bottom: 8pt !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .doc-resumen-tabla {
                margin-bottom: 8pt !important;
                font-size: 7.2pt !important;
            }
            .doc-resumen-tabla td {
                padding: 3pt 5pt !important;
                border: 0.8pt solid #94a3b8 !important;
            }
            .doc-resumen-tabla .lbl {
                background: #f1f5f9 !important;
                font-size: 6.5pt !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .doc-resumen-tabla .val {
                font-size: 8pt !important;
            }

            .doc-tabla-datos {
                font-size: 7pt !important;
                margin-bottom: 10pt !important;
            }
            .doc-tabla-datos th {
                background: #1e3a5f !important;
                color: #ffffff !important;
                padding: 4pt 5pt !important;
                font-size: 6.8pt !important;
                border: 0.8pt solid #1e3a5f !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .doc-tabla-datos td {
                padding: 4pt 5pt !important;
                border: 0.8pt solid #cbd5e1 !important;
            }
            .doc-tabla-datos tr:nth-child(even) td {
                background: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .doc-tabla-datos tr {
                page-break-inside: avoid;
            }

            .doc-firmas {
                margin-top: 24pt !important;
                margin-bottom: 8pt !important;
                page-break-inside: avoid;
            }
            .doc-firma-linea {
                border-top: 0.8pt solid #000 !important;
            }
            .doc-firma-cargo {
                font-size: 7.5pt !important;
            }
            .doc-firma-sub {
                font-size: 6.5pt !important;
            }

            .doc-footer {
                font-size: 6.5pt !important;
                padding-top: 4pt !important;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

@if(!request()->has('auto_print'))
{{-- ===== BARRA DE HERRAMIENTAS (PANTALLA) ===== --}}
<div class="screen-toolbar no-print">
    <div class="toolbar-brand">
        <i class="fa-solid fa-paw" style="color:#38bdf8;"></i>
        VETec<span>NM</span> &nbsp;|&nbsp; <span style="font-size:0.8rem; font-weight:500; color:#cbd5e1;">Reporte Oficial de Citas</span>
    </div>
    <div class="toolbar-right">
        <form class="tb-date-form" method="GET" action="{{ route('admin.citas.reporte-dia') }}">
            <label><i class="fa-solid fa-calendar-day"></i> Fecha:</label>
            <input type="date" name="fecha" value="{{ $fecha }}" required>
            <button type="submit"><i class="fa-solid fa-arrows-rotate"></i> Consultar</button>
        </form>
        <button type="button" class="tb-btn tb-btn-pdf" onclick="imprimirPDF()">
            <i class="fa-solid fa-file-pdf"></i> Descargar PDF
        </button>
        <a href="{{ route('admin.citas.index') }}" class="tb-btn tb-btn-back">
            <i class="fa-solid fa-arrow-left"></i> Volver a Citas
        </a>
    </div>
</div>
@endif

@php
    $total        = $citas->count();
    $confirmadas  = $citas->where('estado', 'Confirmada')->count();
    $pendientes   = $citas->where('estado', 'Pendiente')->count();
    $finalizadas  = $citas->where('estado', 'Finalizada')->count();
    $canceladas   = $citas->where('estado', 'Cancelada')->count();
    $totalFactura = $citas->whereIn('estado', ['Finalizada', 'Confirmada'])->sum('precio');
@endphp

{{-- ===== HOJA DEL DOCUMENTO FORMAL (ORIENTACIÓN VERTICAL) ===== --}}
<div class="documento-hoja-wrap">
    <div class="documento-hoja">

        {{-- Membrete Oficial --}}
        <div class="doc-header">
            <div class="doc-inst">
                <h1>Clínica Veterinaria Universitaria · VETecNM</h1>
                <h2>Coordinación de Servicios Médicos Veterinarios y Atención Clínica</h2>
                <p>Tecnológico Nacional de México · Campus Central · Tel: (771) 000-0000 · contacto@vetecnm.mx</p>
            </div>
            <div class="doc-meta">
                <div class="tipo">REPORTE OFICIAL DE CITAS MÉDICAS</div>
                <div>Fecha de Emisión: <strong>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} hrs</strong></div>
                <div>Sistema: <strong>Control Operativo VETecNM</strong></div>
            </div>
        </div>

        {{-- Título y Fecha del Reporte --}}
        <div class="doc-titulo-banda">
            <span>Agenda de Citas del Día</span>
            <span class="fecha-sub">{{ \Carbon\Carbon::parse($fecha)->isoFormat('dddd D [de] MMMM [de] YYYY') }}</span>
        </div>

        {{-- Resumen Ejecutivo en formato de tabla formal --}}
        <table class="doc-resumen-tabla">
            <tr>
                <td class="lbl">Total Citas</td>
                <td class="lbl">Confirmadas</td>
                <td class="lbl">Pendientes</td>
                <td class="lbl">Finalizadas</td>
                <td class="lbl">Canceladas</td>
                <td class="lbl">Total Facturado / Proyectado</td>
            </tr>
            <tr>
                <td class="val">{{ $total }}</td>
                <td class="val" style="color:#15803d;">{{ $confirmadas }}</td>
                <td class="val" style="color:#b45309;">{{ $pendientes }}</td>
                <td class="val" style="color:#1d4ed8;">{{ $finalizadas }}</td>
                <td class="val" style="color:#b91c1c;">{{ $canceladas }}</td>
                <td class="val" style="color:#047857;">${{ number_format($totalFactura, 2) }} MXN</td>
            </tr>
        </table>

        {{-- Tabla de Citas Médicas Adaptada a Vertical --}}
        <table class="doc-tabla-datos">
            <thead>
                <tr>
                    <th style="width: 4%; text-align:center;">#</th>
                    <th style="width: 10%;">Hora</th>
                    <th style="width: 15%;">Paciente</th>
                    <th style="width: 17%;">Propietario</th>
                    <th style="width: 20%;">Servicio & Profesional</th>
                    <th style="width: 20%;">Motivo / Observaciones</th>
                    <th style="width: 7%; text-align:right;">Precio</th>
                    <th style="width: 7%; text-align:center;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citas as $i => $c)
                    <tr>
                        <td style="text-align:center; font-weight:bold;">{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}</strong>
                        </td>
                        <td>
                            <strong>{{ $c->mascota_nombre }}</strong><br>
                            <span style="font-size:0.68rem; color:#475569;">{{ $c->especie }}{{ $c->raza ? ' · ' . $c->raza : '' }}</span>
                        </td>
                        <td>
                            <strong>{{ $c->dueno_nombre }}</strong>
                            @if(!empty($c->dueno_telefono))
                                <br><span style="font-size:0.68rem; color:#475569;">Tel: {{ $c->dueno_telefono }}</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $c->servicio ?? 'Consulta General' }}</strong>
                            <br><span style="font-size:0.68rem; color:#0d9488;">
                                <i class="fa-solid fa-user-doctor" style="font-size:0.65rem;"></i> {{ $c->profesional ?: 'No asignado' }}
                            </span>
                            <span style="font-size:0.65rem; color:#64748b;"> · {{ ucfirst($c->canal ?? 'Web') }}</span>
                        </td>
                        <td>
                            <div>{{ $c->motivo }}</div>
                            @if(!empty($c->notas))
                                <div style="font-size:0.68rem; color:#475569; font-style:italic; margin-top:2px;">
                                    <strong>Obs:</strong> {{ $c->notas }}
                                </div>
                            @endif
                        </td>
                        <td style="text-align:right; font-weight:bold;">
                            ${{ number_format($c->precio ?? 0, 2) }}
                        </td>
                        <td style="text-align:center;">
                            <span class="estado-chip">{{ $c->estado }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:16px; color:#64748b;">
                            No se registran citas médicas programadas para la fecha seleccionada ({{ \Carbon\Carbon::parse($fecha)->isoFormat('D [de] MMMM [de] YYYY') }}).
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Firmas Oficiales --}}
        <div class="doc-firmas">
            <div class="doc-firma-col">
                <div class="doc-firma-linea"></div>
                <div class="doc-firma-cargo">Director(a) / Administrador(a) de Clínica</div>
                <div class="doc-firma-sub">Firma y Sello Oficial</div>
            </div>
            <div class="doc-firma-col">
                <div class="doc-firma-linea"></div>
                <div class="doc-firma-cargo">Coordinador(a) de Citas Médicas</div>
                <div class="doc-firma-sub">Firma de Validación Operativa</div>
            </div>
        </div>

        {{-- Pie de Reporte Formal --}}
        <div class="doc-footer">
            Documento emitido para control interno y seguimiento operativo por la Clínica Veterinaria Universitaria VETecNM.<br>
            Cualquier aclaración sobre las citas programadas deberá ser canalizada a la Coordinación Médica de la clínica.
        </div>

    </div>
</div>

<script>
    function imprimirPDF() {
        const tituloOriginal = document.title;
        document.title = 'Reporte_Citas_VETecNM_{{ str_replace("-", "", $fecha) }}';
        window.print();
        document.title = tituloOriginal;
    }

    // Auto-abrir diálogo de PDF al cargar
    window.addEventListener('load', function() {
        setTimeout(imprimirPDF, 400);
    });
</script>

</body>
</html>
