<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VETecNM - Portal del Paciente y Cliente</title>
    <!-- Fuentes Google: Poppins e Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-navy: #1e3a8a;
            --primary-dark: #0f172a;
            --accent-blue: #0284c7;
            --accent-green: #059669;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: #f1f5f9;
            color: var(--slate-800);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Formal */
        .portal-navbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: #ffffff;
            padding: 0.85rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .portal-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #38bdf8;
        }

        .brand-text h1 {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            line-height: 1.1;
        }

        .brand-text span {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #93c5fd;
            font-weight: 600;
        }

        .portal-nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-link-btn {
            color: #e2e8f0;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .nav-link-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .user-profile-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 4px 12px 4px 6px;
            border-radius: 30px;
        }

        .avatar-initials {
            width: 32px;
            height: 32px;
            background: #0284c7;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .user-profile-info {
            line-height: 1.2;
        }

        .user-profile-name {
            font-size: 0.84rem;
            font-weight: 600;
            color: #ffffff;
        }

        .user-profile-role {
            font-size: 0.7rem;
            color: #93c5fd;
        }

        .btn-logout-header {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.45rem 0.9rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-logout-header:hover {
            background: #dc2626;
        }

        /* Contenedor Principal */
        .portal-main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.25rem;
            width: 100%;
            flex: 1;
        }

        /* Banner de Bienvenida y Perfil Formal */
        .client-profile-hero {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--slate-200);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
            padding: 1.8rem 2.2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .hero-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .hero-avatar {
            width: 68px;
            height: 68px;
            border-radius: 16px;
            background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            box-shadow: 0 8px 16px rgba(2, 132, 199, 0.25);
        }

        .hero-details h2 {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .hero-meta-badges {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .hero-meta-item {
            font-size: 0.82rem;
            color: var(--slate-600);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--slate-100);
            padding: 4px 10px;
            border-radius: 6px;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Botones Primarios y Secundarios */
        .btn-portal-primary {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.4rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.92rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-portal-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.4);
        }

        .btn-portal-secondary {
            background: white;
            color: var(--slate-700);
            border: 1.5px solid var(--slate-300);
            padding: 0.75rem 1.3rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.92rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-portal-secondary:hover {
            background: var(--slate-100);
            border-color: #94a3b8;
        }

        /* Banner de Éxito con Botón Directo a Comprobante */
        .alert-voucher-success {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1.5px solid #a7f3d0;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.08);
        }

        .alert-voucher-text {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #065f46;
        }

        .alert-voucher-text i {
            font-size: 1.8rem;
            color: #059669;
        }

        .btn-download-voucher-lg {
            background: #059669;
            color: white;
            padding: 0.65rem 1.3rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.25);
            transition: all 0.2s;
        }

        .btn-download-voucher-lg:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        /* Pestañas de Navegación */
        .portal-tabs-nav {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid var(--slate-200);
            margin-bottom: 1.8rem;
        }

        .tab-btn {
            background: none;
            border: none;
            padding: 0.85rem 1.4rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--slate-600);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: var(--primary-navy);
        }

        .tab-btn.active {
            color: var(--accent-blue);
            border-bottom-color: var(--accent-blue);
            font-weight: 700;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.25s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tarjeta Contenedora de Sección */
        .portal-card {
            background: white;
            border-radius: 14px;
            border: 1px solid var(--slate-200);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            padding: 1.8rem;
            margin-bottom: 2rem;
        }

        .portal-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 10px;
        }

        .portal-card-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--slate-800);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Tabla Formal de Citas Médicas */
        .citas-table-responsive {
            overflow-x: auto;
        }

        .citas-formal-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.9rem;
        }

        .citas-formal-table th {
            background: #f8fafc;
            color: var(--slate-700);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-top: 1px solid var(--slate-200);
            border-bottom: 2px solid var(--slate-200);
            text-align: left;
        }

        .citas-formal-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--slate-200);
            vertical-align: middle;
            color: var(--slate-700);
        }

        .citas-formal-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-folio {
            font-family: monospace;
            font-weight: 700;
            color: #1e40af;
            background: #eff6ff;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid #bfdbfe;
            display: inline-block;
        }

        .pet-name-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .pet-mini-icon {
            width: 28px;
            height: 28px;
            background: #f1f5f9;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.85rem;
        }

        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-pendiente {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .badge-confirmada {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .badge-finalizada {
            background: #e0f2fe;
            color: #075985;
            border: 1px solid #7dd3fc;
        }

        .badge-cancelada {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .btn-comprobante-action {
            background: #f0fdf4;
            color: #166534;
            border: 1.5px solid #a7f3d0;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-comprobante-action:hover {
            background: #dcfce7;
            border-color: #86efac;
            transform: translateY(-1px);
        }

        /* Grilla de Mascotas */
        .pets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .pet-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            padding: 1.5rem;
            transition: all 0.2s ease;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .pet-card:hover {
            border-color: var(--accent-blue);
            box-shadow: 0 8px 24px rgba(2, 132, 199, 0.1);
            transform: translateY(-2px);
        }

        .pet-card-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.2rem;
        }

        .pet-card-avatar {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1.5px solid #bfdbfe;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: #1e40af;
        }

        .pet-card-title h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--slate-800);
            margin: 0;
        }

        .pet-card-title span {
            font-size: 0.8rem;
            color: var(--slate-600);
            font-weight: 500;
        }

        .pet-info-list {
            margin-bottom: 1.2rem;
            border-top: 1px dashed var(--slate-200);
            border-bottom: 1px dashed var(--slate-200);
            padding: 0.8rem 0;
            font-size: 0.86rem;
        }

        .pet-info-item {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .pet-info-label {
            color: var(--slate-600);
        }

        .pet-info-val {
            font-weight: 600;
            color: var(--slate-800);
        }

        .pet-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: white;
            border-radius: 16px;
            max-width: 620px;
            width: 100%;
            padding: 2.2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--slate-200);
            padding-bottom: 1rem;
        }

        .modal-header h3 {
            margin: 0 0 4px 0;
            color: #0f172a;
            font-size: 1.3rem;
            font-weight: 800;
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 1.6rem;
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.2s;
        }

        .modal-close-btn:hover {
            color: #0f172a;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
            margin-bottom: 1.2rem;
        }

        .input-group-modern {
            margin-bottom: 1.2rem;
        }

        .input-group-modern label {
            display: block;
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--slate-700);
            margin-bottom: 6px;
        }

        .input-group-modern input,
        .input-group-modern select,
        .input-group-modern textarea {
            width: 100%;
            padding: 0.75rem 0.95rem;
            border: 1.5px solid var(--slate-300);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.92rem;
            box-sizing: border-box;
            color: var(--slate-800);
        }

        .input-group-modern input:focus,
        .input-group-modern select:focus,
        .input-group-modern textarea:focus {
            outline: none;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        /* Ventana Azul de Alerta de Horario (R-32) */
        .modal-backdrop-blue {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(5px);
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
            border-radius: 18px;
            box-shadow: 0 25px 50px -12px rgba(29, 78, 216, 0.5);
            max-width: 480px;
            width: 100%;
            border: 2px solid rgba(255, 255, 255, 0.25);
            text-align: center;
        }

        .btn-blue-modal {
            background: #ffffff;
            color: #1d4ed8;
            border: none;
            padding: 0.85rem 1.8rem;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-blue-modal:hover {
            background: #f8fafc;
        }

        @media (max-width: 768px) {
            .client-profile-hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
            }

            .portal-tabs-nav {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Institucional Formal -->
    <nav class="portal-navbar">
        <a href="{{ route('home') }}" class="portal-brand">
            <div class="brand-icon">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
            <div class="brand-text">
                <h1>VETecNM</h1>
                <span>Centro Clínico Veterinario</span>
            </div>
        </a>

        <div class="portal-nav-actions">
            <a href="{{ route('home') }}" class="nav-link-btn">
                <i class="fa-solid fa-globe"></i> Portal Público
            </a>

            <div class="user-profile-badge">
                <div class="avatar-initials">
                    {{ strtoupper(substr(session('user_nombre', 'U'), 0, 2)) }}
                </div>
                <div class="user-profile-info">
                    <div class="user-profile-name">{{ session('user_nombre', 'Usuario') }}</div>
                    <div class="user-profile-role">Propietario / Cliente</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout-header" title="Cerrar sesión">
                    <i class="fa-solid fa-power-off"></i> Salir
                </button>
            </form>
        </div>
    </nav>

    <!-- Contenedor Principal del Portal -->
    <div class="portal-main-container">

        <!-- Mensajes Flash de Sesión -->
        @if (session('success'))
            <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.4rem; color: #10b981;"></i>
                <div style="font-weight: 600; font-size: 0.95rem;">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div style="background: #fef2f2; border: 1.5px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 1.4rem; color: #ef4444;"></i>
                <div style="font-weight: 600; font-size: 0.95rem;">{{ session('error') }}</div>
            </div>
        @endif

        <!-- Card de Descarga Inmediata de Comprobante si acaba de agendar -->
        @if (session('nueva_cita_id'))
            <div class="alert-voucher-success">
                <div class="alert-voucher-text">
                    <i class="fa-solid fa-receipt"></i>
                    <div>
                        <strong style="font-size: 1.05rem; display: block;">¡Tu comprobante de cita médica está listo!</strong>
                        <span style="font-size: 0.88rem; color: #047857;">Folio asignado: #VET-{{ str_pad(session('nueva_cita_id'), 6, '0', STR_PAD_LEFT) }}. Puedes descargarlo o imprimirlo ahora mismo.</span>
                    </div>
                </div>
                <a href="{{ route('citas.comprobante', session('nueva_cita_id')) }}" target="_blank" class="btn-download-voucher-lg">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Comprobante Oficial (PDF)
                </a>
            </div>
        @endif

        <!-- Hero: Perfil Formal del Cliente y Botones de Acción -->
        <div class="client-profile-hero">
            <div class="hero-left">
                <div class="hero-avatar">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div class="hero-details">
                    <h2>Bienvenido(a), {{ $usuario->nombre ?? session('user_nombre') }}</h2>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 4px;">
                        Expediente de Propietario en el Centro Clínico Veterinario VETecNM.
                    </p>
                    <div class="hero-meta-badges">
                        <span class="hero-meta-item">
                            <i class="fa-regular fa-envelope" style="color: #0284c7;"></i> {{ $usuario->email ?? session('user_email') }}
                        </span>
                        @if (!empty($usuario->telefono))
                            <span class="hero-meta-item">
                                <i class="fa-solid fa-phone" style="color: #059669;"></i> {{ $usuario->telefono }}
                            </span>
                        @endif
                        <span class="hero-meta-item">
                            <i class="fa-solid fa-shield-halved" style="color: #d97706;"></i> Cuenta Verificada
                        </span>
                    </div>
                </div>
            </div>

            <div class="hero-actions">
                <button type="button" class="btn-portal-primary" onclick="openAgendarModal()">
                    <i class="fa-solid fa-calendar-plus"></i> Agendar Cita Médica
                </button>
                <button type="button" class="btn-portal-secondary" onclick="openPetModal()">
                    <i class="fa-solid fa-paw"></i> Registrar Mascota
                </button>
            </div>
        </div>

        <!-- Pestañas de Navegación del Portal Especial -->
        <div class="portal-tabs-nav">
            <button type="button" class="tab-btn active" onclick="switchTab('tab-citas', this)">
                <i class="fa-solid fa-calendar-days"></i> Mis Citas Médicas ({{ $citas->count() }})
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('tab-mascotas', this)">
                <i class="fa-solid fa-paw"></i> Mis Mascotas ({{ $misMascotas->count() }})
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('tab-servicios', this)">
                <i class="fa-solid fa-stethoscope"></i> Catálogo de Servicios y Tarifas
            </button>
        </div>

        <!-- =========================================================================
             PESTAÑA 1: MIS CITAS MÉDICAS (Con Descarga de Comprobante)
             ========================================================================= -->
        <div id="tab-citas" class="tab-content active">
            <div class="portal-card">
                <div class="portal-card-header">
                    <div>
                        <h3><i class="fa-solid fa-calendar-check" style="color: #0284c7;"></i> Mis Citas Programadas</h3>
                        <p style="color: #64748b; font-size: 0.85rem; margin: 3px 0 0 0;">
                            Historial completo de citas veterinarias. Puedes consultar y descargar el comprobante oficial en cualquier momento.
                        </p>
                    </div>
                    <button type="button" class="btn-portal-primary" style="padding: 0.55rem 1.1rem; font-size: 0.85rem;" onclick="openAgendarModal()">
                        <i class="fa-solid fa-plus"></i> Nueva Cita
                    </button>
                </div>

                <div class="citas-table-responsive">
                    <table class="citas-formal-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Paciente / Mascota</th>
                                <th>Servicio Requerido</th>
                                <th>Especialista Asignado</th>
                                <th>Fecha & Horario</th>
                                <th>Tarifa</th>
                                <th>Estado</th>
                                <th style="text-align: right;">Comprobante</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($citas as $c)
                                <tr>
                                    <td>
                                        <span class="badge-folio">#VET-{{ str_pad($c->id_cita, 6, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <div class="pet-name-cell">
                                            <div class="pet-mini-icon">
                                                <i class="fa-solid fa-paw"></i>
                                            </div>
                                            <div>
                                                <div>{{ $c->mascota_nombre }}</div>
                                                <small style="color: #64748b; font-size: 0.76rem; font-weight: normal;">
                                                    {{ $c->especie }} {{ $c->raza ? '• ' . $c->raza : '' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #0f172a;">
                                            {{ $c->servicio ?: 'Consulta Médica General' }}
                                        </div>
                                        <small style="color: #64748b; font-size: 0.78rem; display: block; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $c->motivo ?: 'Revisión y valoración clínica' }}
                                        </small>
                                    </td>
                                    <td>
                                        <div style="color: #0369a1; font-weight: 600; font-size: 0.88rem;">
                                            <i class="fa-solid fa-user-doctor"></i> {{ $c->profesional ?? 'Equipo Médico General' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;">
                                            <i class="fa-regular fa-calendar" style="color: #64748b;"></i>
                                            {{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}
                                        </div>
                                        <small style="color: #0284c7; font-weight: 700;">
                                            <i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span style="font-weight: 700; color: #059669; background: #ecfdf5; padding: 3px 8px; border-radius: 6px; border: 1px solid #a7f3d0; font-size: 0.85rem;">
                                            ${{ number_format($c->precio ?? \App\Services\CitaService::getPrecioServicio($c->servicio), 2) }} MXN
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status badge-{{ strtolower($c->estado) }}">
                                            {{ $c->estado }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <!-- BOTÓN FORMAL DESCARGAR COMPROBANTE -->
                                        <a href="{{ route('citas.comprobante', $c->id_cita) }}" target="_blank" class="btn-comprobante-action" title="Descargar comprobante en formato PDF imprimible">
                                            <i class="fa-solid fa-file-invoice-dollar"></i> Descargar Comprobante
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; color: #94a3b8; padding: 3rem 1rem;">
                                        <div style="font-size: 2.5rem; margin-bottom: 10px; color: #cbd5e1;">
                                            <i class="fa-regular fa-calendar-xmark"></i>
                                        </div>
                                        <strong style="color: #475569; font-size: 1.05rem; display: block; margin-bottom: 6px;">No tienes citas programadas actualmente</strong>
                                        <p style="font-size: 0.88rem; margin-bottom: 1.2rem;">Agenda una cita con nuestros especialistas médicos para el cuidado de tu mascota.</p>
                                        <button type="button" class="btn-portal-primary" onclick="openAgendarModal()">
                                            <i class="fa-solid fa-calendar-plus"></i> Agendar Mi Primera Cita
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             PESTAÑA 2: MIS MASCOTAS (Datos de la Mascota y Expediente)
             ========================================================================= -->
        <div id="tab-mascotas" class="tab-content">
            <div class="portal-card">
                <div class="portal-card-header">
                    <div>
                        <h3><i class="fa-solid fa-paw" style="color: #059669;"></i> Expediente de Mis Mascotas</h3>
                        <p style="color: #64748b; font-size: 0.85rem; margin: 3px 0 0 0;">
                            Consulta los datos clínicos, peso registrado e historial de atención veterinaria de cada uno de tus compañeros.
                        </p>
                    </div>
                    <button type="button" class="btn-portal-primary" style="background: #059669; padding: 0.55rem 1.1rem; font-size: 0.85rem;" onclick="openPetModal()">
                        <i class="fa-solid fa-plus"></i> Registrar Mascota
                    </button>
                </div>

                @if ($misMascotas->isEmpty())
                    <div style="text-align: center; padding: 3rem 1rem; color: #64748b;">
                        <i class="fa-solid fa-dog" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                        <h4 style="color: #334155; margin-bottom: 6px;">No tienes mascotas registradas</h4>
                        <p style="font-size: 0.9rem; margin-bottom: 1.2rem;">Registra a tu mascota para poder agendar citas médicas y llevar su expediente clínico.</p>
                        <button type="button" class="btn-portal-primary" style="background: #059669;" onclick="openPetModal()">
                            <i class="fa-solid fa-paw"></i> Registrar Mascota Ahora
                        </button>
                    </div>
                @else
                    <div class="pets-grid">
                        @foreach ($misMascotas as $m)
                            <div class="pet-card">
                                <div class="pet-card-top">
                                    <div class="pet-card-avatar">
                                        @if (in_array(strtolower($m->especie), ['perro', 'canino']))
                                            <i class="fa-solid fa-dog"></i>
                                        @elseif(in_array(strtolower($m->especie), ['gato', 'felino']))
                                            <i class="fa-solid fa-cat"></i>
                                        @elseif(in_array(strtolower($m->especie), ['ave', 'pajaro']))
                                            <i class="fa-solid fa-dove"></i>
                                        @else
                                            <i class="fa-solid fa-paw"></i>
                                        @endif
                                    </div>
                                    <div class="pet-card-title">
                                        <h4>{{ $m->nombre }}</h4>
                                        <span>{{ $m->especie }} {{ $m->raza ? '• ' . $m->raza : '• Mestizo' }}</span>
                                    </div>
                                </div>

                                <div class="pet-info-list">
                                    <div class="pet-info-item">
                                        <span class="pet-info-label"><i class="fa-solid fa-weight-scale" style="color: #64748b;"></i> Peso Registrado:</span>
                                        <span class="pet-info-val">{{ $m->peso ? $m->peso . ' kg' : 'Sin registrar' }}</span>
                                    </div>
                                    <div class="pet-info-item">
                                        <span class="pet-info-label"><i class="fa-solid fa-file-medical" style="color: #64748b;"></i> Citas Totales:</span>
                                        <span class="pet-info-val">{{ $m->total_citas }} consulta(s)</span>
                                    </div>
                                    <div class="pet-info-item">
                                        <span class="pet-info-label"><i class="fa-regular fa-calendar-check" style="color: #64748b;"></i> Próxima Cita:</span>
                                        <span class="pet-info-val" style="color: #0284c7;">
                                            @if ($m->proxima_cita)
                                                {{ \Carbon\Carbon::parse($m->proxima_cita->fecha)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($m->proxima_cita->hora)->format('h:i A') }})
                                            @else
                                                Ninguna programada
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="pet-card-footer">
                                    <button type="button" class="btn-portal-secondary" style="font-size: 0.82rem; padding: 6px 12px;" onclick="agendarParaMascota({{ $m->id_mascota }})">
                                        <i class="fa-solid fa-calendar-plus" style="color: #0284c7;"></i> Agendar Cita
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- =========================================================================
             PESTAÑA 3: CATÁLOGO DE SERVICIOS Y TARIFAS
             ========================================================================= -->
        <div id="tab-servicios" class="tab-content">
            <div class="portal-card">
                <div class="portal-card-header">
                    <div>
                        <h3><i class="fa-solid fa-stethoscope" style="color: #0284c7;"></i> Catálogo de Servicios Médicos y Tarifas</h3>
                        <p style="color: #64748b; font-size: 0.85rem; margin: 3px 0 0 0;">
                            Conoce nuestros servicios veterinarios, tarifas oficiales garantizadas y duración estimada.
                        </p>
                    </div>
                    <button type="button" class="btn-portal-primary" onclick="openAgendarModal()">
                        <i class="fa-solid fa-calendar-plus"></i> Agendar Cita
                    </button>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem;">
                    @foreach ($serviciosPorCategoria as $categoria => $servicios)
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.4rem;">
                            <h4 style="color: #1e3a8a; font-size: 1.05rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-tag" style="color: #0284c7;"></i> {{ $categoria }}
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach ($servicios as $s)
                                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <div style="font-weight: 700; font-size: 0.92rem; color: #0f172a;">{{ $s['nombre'] }}</div>
                                            @if (!empty($s['duracion']))
                                                <small style="color: #64748b; font-size: 0.78rem;"><i class="fa-regular fa-clock"></i> {{ $s['duracion'] }}</small>
                                            @endif
                                        </div>
                                        <div style="text-align: right;">
                                            <span style="font-weight: 800; color: #059669; font-size: 0.95rem;">
                                                {{ $s['precio_texto'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <!-- =========================================================================
         MODAL FORMAL: AGENDAR CITA MÉDICA PARA CLIENTE (R-30, R-31, R-32)
         ========================================================================= -->
    <div id="modalAgendarCliente" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div>
                    <h3><i class="fa-solid fa-calendar-plus" style="color: #0284c7;"></i> Agendar Cita Médica</h3>
                    <span style="font-size: 0.84rem; color: #64748b;">Selecciona servicio, especialista, tu mascota, fecha y turno disponible.</span>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeAgendarModal()">&times;</button>
            </div>

            @if ($misMascotas->isEmpty())
                <div style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 1rem; border-radius: 8px; margin-bottom: 1.2rem;">
                    <strong><i class="fa-solid fa-circle-info"></i> Registra primero una mascota</strong>
                    <p style="margin: 4px 0 10px 0; font-size: 0.88rem;">Para agendar una cita necesitas tener al menos una mascota registrada en tu perfil.</p>
                    <button type="button" class="btn-portal-primary" style="background: #059669;" onclick="closeAgendarModal(); openPetModal();">Registrar mi mascota ahora</button>
                </div>
            @endif

            <form action="{{ route('citas.agendar.cliente') }}" method="POST">
                @csrf

                <!-- Mascota que asistirá (R-30) -->
                <div class="input-group-modern">
                    <label for="cli_id_mascota"><i class="fa-solid fa-paw" style="color: #0284c7;"></i> Mascota que asistirá a la cita *</label>
                    <select name="id_mascota" id="cli_id_mascota" required>
                        <option value="">-- Selecciona tu mascota --</option>
                        @foreach ($misMascotas as $m)
                            <option value="{{ $m->id_mascota }}">{{ $m->nombre }} ({{ $m->especie }} - {{ $m->raza ?? 'Mestizo' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-grid-2">
                    <!-- Servicio (R-30) -->
                    <div class="input-group-modern">
                        <label for="cli_servicio"><i class="fa-solid fa-stethoscope" style="color: #0284c7;"></i> Servicio Requerido *</label>
                        <select name="servicio" id="cli_servicio" required onchange="actualizarPrecioServicioCliente(); cargarHorariosCliente();">
                            <option value="" data-precio="" data-precio-texto="" data-duracion="" data-descripcion="" data-incluye="">-- Seleccionar Servicio --</option>
                            @foreach ($serviciosPorCategoria as $catNombre => $srvList)
                                <optgroup label="{{ $catNombre }}">
                                    @foreach ($srvList as $srv)
                                        <option value="{{ $srv['nombre'] }}" data-precio="{{ $srv['precio'] }}"
                                            data-precio-texto="{{ $srv['precio_texto'] }}"
                                            data-duracion="{{ $srv['duracion'] ?? '' }}"
                                            data-descripcion="{{ $srv['descripcion'] ?? '' }}"
                                            data-incluye="{{ $srv['incluye'] ?? '' }}"
                                            {{ old('servicio') === $srv['nombre'] ? 'selected' : '' }}>
                                            {{ $srv['nombre'] }} — {{ $srv['precio_texto'] }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- Profesional de Salud / Estética (R-30) -->
                    <div class="input-group-modern">
                        <label for="cli_profesional"><i class="fa-solid fa-user-doctor" style="color: #0284c7;"></i> Profesional de Salud/Estética *</label>
                        <select name="profesional" id="cli_profesional" required onchange="cargarHorariosCliente()">
                            <option value="">-- Seleccionar Especialista --</option>
                            @foreach ($profesionales as $p)
                                <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Tarjeta dinámica de precio y detalles del servicio -->
                <div id="cli_servicio_info_box" style="display: none; background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1px solid #a7f3d0; border-radius: 10px; padding: 0.85rem 1rem; margin-top: -6px; margin-bottom: 1.2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #059669; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <div>
                                <span style="font-size: 0.72rem; text-transform: uppercase; color: #047857; font-weight: 700; display: block;">Tarifa Oficial</span>
                                <span id="cli_servicio_precio" style="font-size: 1.2rem; font-weight: 800; color: #065f46;">$0.00 MXN</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px; background: rgba(5, 150, 105, 0.12); padding: 4px 10px; border-radius: 20px;">
                            <i class="fa-regular fa-clock" style="color: #059669; font-size: 0.82rem;"></i>
                            <span id="cli_servicio_duracion" style="font-size: 0.78rem; font-weight: 600; color: #047857;">Duración: --</span>
                        </div>
                    </div>
                    <div id="cli_servicio_descripcion_box" style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed #a7f3d0; font-size: 0.82rem; color: #065f46; line-height: 1.45;">
                        <span id="cli_servicio_descripcion"></span>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Fecha deseada (R-30) -->
                    <div class="input-group-modern">
                        <label for="cli_fecha"><i class="fa-regular fa-calendar" style="color: #0284c7;"></i> Fecha de la Cita *</label>
                        <input type="date" name="fecha" id="cli_fecha" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required onchange="cargarHorariosCliente()">
                    </div>

                    <!-- Horario disponible dinámico (Regla de 30 minutos) -->
                    <div class="input-group-modern">
                        <label for="cli_hora"><i class="fa-regular fa-clock" style="color: #0284c7;"></i> Horario Disponible *</label>
                        <select name="hora" id="cli_hora" required>
                            <option value="">-- Selecciona fecha y profesional --</option>
                        </select>
                    </div>
                </div>

                <small id="cli_hora_info" style="color: #64748b; font-size: 0.78rem; display: block; margin-top: -6px; margin-bottom: 14px;">
                    Horarios calculados según disponibilidad laboral, recesos y anticipación mínima de 30 minutos.
                </small>

                <!-- Motivo / Síntomas -->
                <div class="input-group-modern">
                    <label for="cli_motivo"><i class="fa-solid fa-notes-medical" style="color: #0284c7;"></i> Motivo de la Consulta / Síntomas</label>
                    <textarea name="motivo" id="cli_motivo" rows="2" placeholder="Describe brevemente síntomas o cualquier requerimiento especial para el médico..."></textarea>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #e2e8f0; padding-top: 1.2rem;">
                    <button type="button" class="btn-portal-secondary" onclick="closeAgendarModal()">Cancelar</button>
                    <button type="submit" class="btn-portal-primary">
                        <i class="fa-solid fa-calendar-check"></i> Confirmar Cita Médica
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =========================================================================
         MODAL FORMAL: REGISTRAR MASCOTA
         ========================================================================= -->
    <div id="modalRegistrarMascota" class="modal-overlay">
        <div class="modal-card" style="max-width: 480px;">
            <div class="modal-header">
                <div>
                    <h3><i class="fa-solid fa-paw" style="color: #059669;"></i> Registrar Mascota</h3>
                    <span style="font-size: 0.82rem; color: #64748b;">Agrega una nueva mascota a tu expediente clínico.</span>
                </div>
                <button type="button" class="modal-close-btn" onclick="closePetModal()">&times;</button>
            </div>
            <form action="{{ route('mascota.store') }}" method="POST">
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
                        <input type="text" name="raza" placeholder="Ej: Golden Retriever, Siamés">
                    </div>
                </div>
                <div class="input-group-modern">
                    <label>Peso en Kg (Opcional)</label>
                    <input type="number" step="0.01" name="peso" placeholder="Ej: 14.50">
                </div>
                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid #e2e8f0; padding-top: 1.2rem;">
                    <button type="button" class="btn-portal-secondary" onclick="closePetModal()">Cancelar</button>
                    <button type="submit" class="btn-portal-primary" style="background: #059669;">
                        <i class="fa-solid fa-check"></i> Guardar Mascota
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =========================================================================
         R-32 VENTANA AZUL DE ALERTA DE HORARIO NO DISPONIBLE
         ========================================================================= -->
    <div id="modalAlertaAzulCliente" class="modal-backdrop-blue" style="display: none;">
        <div class="modal-card-blue">
            <div style="width: 76px; height: 76px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem auto; border: 2px solid rgba(255,255,255,0.5);">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 2.8rem; color: #ffffff;"></i>
            </div>
            <h3 style="color: #ffffff; font-size: 1.45rem; margin: 0 0 8px 0; font-weight: 800;">
                ¡Horario No Disponible!
            </h3>
            <p id="alertaAzulTextoCli" style="color: #e0f2fe; font-size: 1.05rem; line-height: 1.5; margin: 0;">
                El horario ya no se encuentra disponible.
            </p>
            <p id="alertaAzulDetalleCli" style="color: #bae6fd; font-size: 0.88rem; margin-top: 10px; font-style: italic;">
            </p>
            <div style="margin-top: 1.8rem;">
                <button type="button" class="btn-blue-modal" onclick="closeAlertaAzulCli()">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Seleccionar Otro Horario
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts de Interacción del Portal -->
    <script>
        function switchTab(tabId, btn) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

            const targetTab = document.getElementById(tabId);
            if (targetTab) {
                targetTab.classList.add('active');
            }
            if (btn) {
                btn.classList.add('active');
            }
        }

        function actualizarPrecioServicioCliente() {
            const select = document.getElementById('cli_servicio');
            const box = document.getElementById('cli_servicio_info_box');
            const precioEl = document.getElementById('cli_servicio_precio');
            const duracionEl = document.getElementById('cli_servicio_duracion');
            const descEl = document.getElementById('cli_servicio_descripcion');

            if (!select || !box) return;

            const selectedOpt = select.options[select.selectedIndex];
            if (selectedOpt && selectedOpt.value && selectedOpt.getAttribute('data-precio-texto')) {
                const precioTexto = selectedOpt.getAttribute('data-precio-texto');
                const duracion = selectedOpt.getAttribute('data-duracion') || 'Consulta médica estándar';
                const desc = selectedOpt.getAttribute('data-descripcion') || '';
                const incluye = selectedOpt.getAttribute('data-incluye') || '';

                precioEl.textContent = precioTexto;
                duracionEl.textContent = 'Duración: ' + duracion;
                let descContent = desc;
                if (incluye) {
                    descContent += (descContent ? ' • ' : '') + 'Incluye: ' + incluye;
                }
                descEl.textContent = descContent;
                box.style.display = 'block';
            } else {
                box.style.display = 'none';
            }
        }

        function openAgendarModal() {
            document.getElementById('modalAgendarCliente').classList.add('active');
            actualizarPrecioServicioCliente();
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

        function agendarParaMascota(idMascota) {
            const selectMascota = document.getElementById('cli_id_mascota');
            if (selectMascota) {
                selectMascota.value = idMascota;
            }
            openAgendarModal();
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

        @if (session('horario_no_disponible_alerta'))
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
