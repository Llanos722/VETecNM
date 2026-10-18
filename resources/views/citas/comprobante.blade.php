<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Cita Médica #{{ str_pad($cita->id_cita, 6, '0', STR_PAD_LEFT) }} - VETecNM</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #1e3a8a;
            --primary-dark: #0f172a;
            --accent: #0284c7;
            --success: #059669;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-600: #475569;
            --slate-800: #1e293b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f1f5f9;
            color: var(--slate-800);
            line-height: 1.5;
            padding: 2rem 1rem;
        }

        .actions-bar {
            max-width: 820px;
            margin: 0 auto 1.5rem auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.65rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.92rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-print {
            background: #1e3a8a;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
        }

        .btn-print:hover {
            background: #1e40af;
            transform: translateY(-1px);
        }

        .btn-back {
            background: #ffffff;
            color: #334155;
            border: 1px solid var(--slate-200);
        }

        .btn-back:hover {
            background: var(--slate-50);
            border-color: #cbd5e1;
        }

        /* Contenedor del Comprobante */
        .voucher-card {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--slate-200);
            overflow: hidden;
            position: relative;
        }

        .voucher-top-bar {
            height: 8px;
            background: linear-gradient(90deg, #1e3a8a 0%, #0284c7 50%, #059669 100%);
        }

        .voucher-inner {
            padding: 2.5rem 3rem;
        }

        /* Encabezado */
        .voucher-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--slate-100);
            padding-bottom: 1.8rem;
            margin-bottom: 2rem;
            gap: 1.5rem;
        }

        .clinic-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .clinic-logo-badge {
            width: 58px;
            height: 58px;
            background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 8px 16px rgba(2, 132, 199, 0.25);
        }

        .clinic-title h1 {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
            margin-bottom: 3px;
        }

        .clinic-title p {
            font-size: 0.82rem;
            color: var(--slate-600);
            font-weight: 500;
        }

        .voucher-meta {
            text-align: right;
        }

        .folio-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
            padding: 6px 14px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .voucher-date {
            font-size: 0.78rem;
            color: var(--slate-600);
        }

        .document-title-badge {
            text-align: center;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid var(--slate-200);
            border-radius: 10px;
            padding: 0.9rem;
            margin-bottom: 2rem;
        }

        .document-title-badge h2 {
            font-size: 1.05rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--slate-800);
            margin-bottom: 3px;
        }

        .document-title-badge p {
            font-size: 0.82rem;
            color: var(--slate-600);
        }

        /* Grillas de Información */
        .info-sections-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.8rem;
        }

        .info-card {
            background: var(--slate-50);
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 1.25rem 1.4rem;
        }

        .info-card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--primary);
            border-bottom: 1px solid var(--slate-200);
            padding-bottom: 0.6rem;
            margin-bottom: 0.9rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.88rem;
            padding: 0.35rem 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--slate-600);
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: var(--slate-800);
            text-align: right;
        }

        /* Detalle Central de la Cita */
        .appointment-highlight {
            background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
            border: 1.5px solid #bfdbfe;
            border-radius: 12px;
            padding: 1.5rem 1.8rem;
            margin-bottom: 2rem;
        }

        .appointment-highlight-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            text-align: center;
        }

        .highlight-item {
            padding: 0.5rem;
        }

        .highlight-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0369a1;
            margin-bottom: 4px;
        }

        .highlight-value {
            font-size: 1.12rem;
            font-weight: 800;
            color: var(--slate-800);
        }

        .highlight-value.price {
            color: #059669;
        }

        .status-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-Pendiente {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .status-Confirmada {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .status-Finalizada {
            background: #e0f2fe;
            color: #075985;
            border: 1px solid #7dd3fc;
        }

        .status-Cancelada {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Observaciones y Motivo */
        .notes-card {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 10px;
            padding: 1.1rem 1.4rem;
            margin-bottom: 2rem;
        }

        .notes-card h4 {
            font-size: 0.84rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--slate-600);
            margin-bottom: 6px;
        }

        .notes-card p {
            font-size: 0.9rem;
            color: var(--slate-800);
            line-height: 1.5;
        }

        /* Políticas y Recomendaciones */
        .rules-section {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 1.2rem 1.4rem;
            margin-bottom: 2.2rem;
            font-size: 0.82rem;
            color: #92400e;
        }

        .rules-section h4 {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rules-section ul {
            padding-left: 1.2rem;
            line-height: 1.6;
        }

        /* Footer del Comprobante & Firmas */
        .voucher-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1px solid var(--slate-200);
            padding-top: 1.8rem;
            gap: 2rem;
        }

        .signature-box {
            text-align: center;
            width: 240px;
        }

        .signature-line {
            width: 100%;
            height: 1px;
            background: #94a3b8;
            margin-bottom: 8px;
        }

        .signature-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--slate-800);
        }

        .signature-subtitle {
            font-size: 0.72rem;
            color: var(--slate-600);
        }

        .validation-stamp {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .qr-placeholder {
            width: 76px;
            height: 76px;
            background: #ffffff;
            border: 1.5px solid var(--slate-300);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #0f172a;
        }

        .qr-placeholder i {
            font-size: 2.4rem;
        }

        .validation-text {
            font-size: 0.72rem;
            color: var(--slate-600);
            max-width: 220px;
            line-height: 1.4;
        }

        /* ESTILOS DE IMPRESIÓN (PRINT) */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }

            .actions-bar {
                display: none !important;
            }

            .voucher-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }

            .voucher-inner {
                padding: 1.5rem !important;
            }

            @page {
                margin: 1cm;
                size: portrait;
            }
        }

        @media (max-width: 640px) {
            .info-sections-grid {
                grid-template-columns: 1fr;
            }

            .appointment-highlight-grid {
                grid-template-columns: 1fr 1fr;
            }

            .voucher-inner {
                padding: 1.5rem;
            }

            .voucher-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .voucher-meta {
                text-align: left;
            }

            .voucher-footer {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <!-- Barra de Acciones Superior -->
    <div class="actions-bar">
        <a href="{{ route('dashboard') }}" class="btn-action btn-back">
            <i class="fa-solid fa-arrow-left"></i> Regresar al Portal de Usuario
        </a>
        <div style="display: flex; gap: 10px;">
            <button type="button" onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-print"></i> Imprimir / Guardar en PDF
            </button>
        </div>
    </div>

    <!-- Tarjeta Formal del Comprobante -->
    <div class="voucher-card">
        <div class="voucher-top-bar"></div>
        <div class="voucher-inner">
            <!-- Encabezado Institucional -->
            <div class="voucher-header">
                <div class="clinic-brand">
                    <div class="clinic-logo-badge">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>
                    <div class="clinic-title">
                        <h1>VETecNM Hospital Veterinario</h1>
                        <p><i class="fa-solid fa-location-dot"></i> Centro Médico Universitario • Av. Tecnológico #100</p>
                        <p><i class="fa-solid fa-phone"></i> Tel: (341) 123-4567 • Urgencias y Citas</p>
                    </div>
                </div>
                <div class="voucher-meta">
                    <div class="folio-badge">
                        FOLIO: #VET-{{ str_pad($cita->id_cita, 6, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="voucher-date">
                        Fecha de Expedición: {{ now()->format('d/m/Y h:i A') }}
                    </div>
                </div>
            </div>

            <!-- Título de Documento Oficial -->
            <div class="document-title-badge">
                <h2>Comprobante Oficial de Cita Médica</h2>
                <p>Documento de confirmación y pase de ingreso a consulta clínica veterinaria</p>
            </div>

            <!-- Bloques Informativos de Paciente y Titular -->
            <div class="info-sections-grid">
                <!-- Datos del Propietario -->
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fa-solid fa-user-check"></i> Datos del Propietario / Cliente
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nombre Completo:</span>
                        <span class="info-value">{{ $cita->dueno_nombre }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Correo Electrónico:</span>
                        <span class="info-value">{{ $cita->dueno_email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Teléfono de Contacto:</span>
                        <span class="info-value">{{ $cita->telefono_contacto ?: ($cita->dueno_telefono ?: 'No especificado') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Canal de Solicitud:</span>
                        <span class="info-value">{{ strtoupper($cita->canal ?? 'WEB') }}</span>
                    </div>
                </div>

                <!-- Datos de la Mascota / Paciente -->
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fa-solid fa-paw"></i> Expediente del Paciente (Mascota)
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nombre del Paciente:</span>
                        <span class="info-value" style="color: #1e3a8a; font-size: 0.95rem;">
                            {{ $cita->mascota_nombre }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Especie:</span>
                        <span class="info-value">{{ $cita->especie }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Raza:</span>
                        <span class="info-value">{{ $cita->raza ?: 'Mestizo / Criollo' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Peso Corporal:</span>
                        <span class="info-value">
                            {{ $cita->mascota_peso ? $cita->mascota_peso . ' kg' : 'Por valorar en consulta' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Resumen Destacado de la Cita Médica -->
            <div class="appointment-highlight">
                <div class="appointment-highlight-grid">
                    <div class="highlight-item">
                        <div class="highlight-label"><i class="fa-regular fa-calendar"></i> Fecha Programada</div>
                        <div class="highlight-value">
                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                        </div>
                        <div style="font-size: 0.74rem; color: #64748b; margin-top: 2px;">
                            {{ \Carbon\Carbon::parse($cita->fecha)->translatedFormat('l') }}
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-label"><i class="fa-regular fa-clock"></i> Horario de Cita</div>
                        <div class="highlight-value">
                            {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                        </div>
                        <div style="font-size: 0.74rem; color: #64748b; margin-top: 2px;">Turno Asignado</div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-label"><i class="fa-solid fa-user-doctor"></i> Médico / Especialista</div>
                        <div class="highlight-value" style="font-size: 0.96rem;">
                            {{ $cita->profesional ?? 'Equipo Médico General' }}
                        </div>
                        <div style="font-size: 0.74rem; color: #64748b; margin-top: 2px;">Consultorio Central</div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-label"><i class="fa-solid fa-receipt"></i> Tarifa / Costo</div>
                        <div class="highlight-value price">
                            ${{ number_format($cita->precio ?? \App\Services\CitaService::getPrecioServicio($cita->servicio), 2) }} <span style="font-size: 0.75rem;">MXN</span>
                        </div>
                        <div style="margin-top: 4px;">
                            <span class="status-pill status-{{ $cita->estado }}">{{ $cita->estado }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicio y Motivo de Consulta -->
            <div class="notes-card">
                <h4><i class="fa-solid fa-stethoscope" style="color: #0284c7;"></i> Servicio Veterinario & Motivo</h4>
                <div style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                    {{ $cita->servicio ?? 'Consulta Médica Veterinaria' }}
                </div>
                <p>
                    <i class="fa-solid fa-comment-medical" style="color: #64748b;"></i>
                    <strong>Observaciones / Síntomas:</strong>
                    {{ $cita->motivo ?: ($cita->notas ?: 'Revisión y valoración clínica periódica.') }}
                </p>
            </div>

            <!-- Normativas y Recomendaciones de Asistencia -->
            <div class="rules-section">
                <h4><i class="fa-solid fa-triangle-exclamation"></i> Indicaciones Importantes para su Cita</h4>
                <ul>
                    <li>Presentarse con <strong>10 minutos de anticipación</strong> en el área de recepción para revisión de signos vitales.</li>
                    <li>Por protocolo de seguridad clínica: perros con <strong>collar y correa obligatoria</strong>; gatos o pequeñas especies dentro de <strong>transportadora segura</strong>.</li>
                    <li>Traer consigo la <strong>cartilla de vacunación</strong> vigente del paciente (física o digital).</li>
                    <li>En caso de requerir cancelación o cambio de horario, favor de notificar con al menos <strong>2 horas de anticipación</strong>.</li>
                </ul>
            </div>

            <!-- Footer Formal: Sellos y Firma de Validación -->
            <div class="voucher-footer">
                <div class="validation-stamp">
                    <div class="qr-placeholder">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <div class="validation-text">
                        <strong>Comprobante Autenticado Digitalmente</strong><br>
                        Código de Validación Institucional VETecNM. Válido para acceso directo a consulta.
                    </div>
                </div>

                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-title">Dirección de Servicios Médicos</div>
                    <div class="signature-subtitle">VETecNM • Centro Clínico Veterinario</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
