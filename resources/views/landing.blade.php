<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VETecNM - Clínica Veterinaria & Cuidado Integral</title>
    <!-- Google Fonts Poppins & Inter -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap">
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos base -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
        :root {
            --brand-primary: #1e3a8a;
            /* Azul naval elegante */
            --brand-primary-dark: #172554;
            --brand-accent: #0284c7;
            /* Azul cielo brillante */
            --brand-emerald: #059669;
            /* Verde salud */
            --brand-amber: #d97706;
            /* Ámbar */
            --brand-rose: #e11d48;
            /* Rosa/Rojo */
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        body {
            display: block;
            background-color: var(--slate-50);
            color: var(--slate-800);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* --- TOP BAR --- */
        .topbar {
            background-color: var(--brand-primary-dark);
            color: #93c5fd;
            font-size: 0.84rem;
            padding: 0.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .topbar-info {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .topbar-info span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-info a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .topbar-info a:hover {
            color: #ffffff;
        }

        .emergency-pill {
            background: #ef4444;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* --- NAVBAR PRINCIPAL RESPONSIVE --- */
        .landing-nav {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid var(--slate-200);
            width: 100%;
        }

        .nav-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--brand-primary);
            flex-shrink: 0;
        }

        .nav-brand-logo {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);
            flex-shrink: 0;
        }

        .nav-brand-text h1 {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.1;
            margin: 0;
            color: var(--brand-primary-dark);
            white-space: nowrap;
        }

        .nav-brand-text span {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--brand-accent);
            font-weight: 600;
            white-space: nowrap;
        }

        /* Menú de Navegación Central */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 1.2rem;
            align-items: center;
            margin: 0;
            padding: 0;
            flex-shrink: 1;
        }

        .nav-menu li {
            list-style: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--slate-700);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.45rem 0.7rem;
            border-radius: 8px;
            white-space: nowrap;
            transition: all 0.2s;
            display: inline-block;
        }

        .nav-menu a:hover {
            color: var(--brand-accent);
            background: #f1f5f9;
        }

        /* Botones de Acción a la Derecha */
        .nav-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-shrink: 0;
        }

        .btn-nav-login {
            border: 1.5px solid #cbd5e1;
            color: #1e293b;
            background: #ffffff;
            padding: 0.55rem 1.15rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            line-height: 1;
            box-sizing: border-box;
            transition: all 0.2s;
        }

        .btn-nav-login:hover {
            background: #f8fafc;
            border-color: #0284c7;
            color: #0284c7;
        }

        .btn-nav-register {
            border: 1.5px solid #0284c7;
            background: #e0f2fe;
            color: #0369a1;
            padding: 0.55rem 1.15rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            line-height: 1;
            box-sizing: border-box;
            transition: all 0.2s;
        }

        .btn-nav-register:hover {
            background: #0284c7;
            color: #ffffff;
        }

        .btn-schedule-nav {
            background: linear-gradient(135deg, #059669, #047857);
            color: white !important;
            border: none;
            padding: 0.55rem 1.35rem;
            border-radius: 8px;
            font-weight: 700 !important;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            line-height: 1;
            box-sizing: border-box;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
            transition: transform 0.2s, box-shadow 0.2s !important;
            cursor: pointer;
        }

        .btn-schedule-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        }

        /* Botón de Menú Móvil */
        .nav-mobile-toggle {
            display: none;
            background: #f8fafc;
            border: 1.5px solid var(--slate-200);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 1.2rem;
            color: var(--slate-700);
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        /* Menú Desplegable Móvil */
        .nav-mobile-dropdown {
            display: none;
            background: white;
            padding: 1.2rem 1.5rem;
            border-top: 1px solid var(--slate-200);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            flex-direction: column;
            gap: 0.75rem;
        }

        .nav-mobile-dropdown.active {
            display: flex;
        }

        .nav-mobile-dropdown a {
            text-decoration: none;
            color: var(--slate-700);
            font-size: 0.95rem;
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Adaptabilidad de la Barra en Pantallas Pequeñas */
        @media (max-width: 1240px) {
            .nav-menu {
                gap: 0.65rem;
            }

            .nav-menu a {
                font-size: 0.84rem;
                padding: 0.35rem 0.5rem;
            }

            .btn-nav-login,
            .btn-nav-register,
            .btn-schedule-nav {
                padding: 0.5rem 0.9rem;
                font-size: 0.84rem;
            }
        }

        @media (max-width: 1040px) {
            .nav-menu {
                display: none;
            }

            .nav-mobile-toggle {
                display: flex;
            }
        }

        @media (max-width: 720px) {
            .btn-nav-register {
                display: none;
            }

            .btn-schedule-nav {
                padding: 0.5rem 0.9rem;
                font-size: 0.8rem;
            }

            .topbar {
                display: none;
            }
        }

        /* --- HERO BANNER --- */
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: white;
            padding: 5rem 1.5rem 6rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-container {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 3.5rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 1.2rem;
            color: #38bdf8;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 1.2rem;
        }

        .hero-title span {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 1.08rem;
            line-height: 1.7;
            color: #cbd5e1;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #0284c7, #2563eb);
            color: white;
            padding: 0.85rem 1.8rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(2, 132, 199, 0.4);
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(2, 132, 199, 0.5);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 0.85rem 1.8rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: white;
        }

        .hero-card-stat {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }

        .stat-banner-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .hero-quick-stat {
            background: rgba(15, 23, 42, 0.4);
            border-radius: 14px;
            padding: 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .hero-quick-stat i {
            font-size: 1.8rem;
            color: #38bdf8;
            margin-bottom: 0.5rem;
        }

        .hero-quick-stat h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .hero-quick-stat p {
            font-size: 0.8rem;
            color: #94a3b8;
            margin: 0;
        }

        /* --- CONTENEDOR DE SECCIONES --- */
        .section-wrapper {
            max-width: 1240px;
            margin: 0 auto;
            padding: 5rem 1.5rem;
        }

        .section-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 3.5rem;
        }

        .section-tag {
            display: inline-block;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 0.8rem;
        }

        .section-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.5px;
            margin-bottom: 0.8rem;
        }

        .section-subtitle {
            font-size: 1rem;
            color: var(--slate-600);
            line-height: 1.6;
            margin: 0;
        }

        /* --- RF-02: INFORMACIÓN DE CLÍNICA, HORARIOS & PROTOCOLOS --- */
        .clinic-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .clinic-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--slate-200);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .clinic-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .card-title-icon {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid var(--slate-100);
        }

        .card-title-icon i {
            font-size: 1.4rem;
            color: var(--brand-accent);
            background: #e0f2fe;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title-icon h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: var(--slate-900);
        }

        .hours-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px dashed var(--slate-200);
            font-size: 0.92rem;
        }

        .hours-item strong {
            color: var(--slate-800);
        }

        .hours-item span {
            color: var(--brand-primary);
            font-weight: 600;
        }

        .holidays-badge-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .holiday-badge {
            background: #f8fafc;
            border: 1px solid var(--slate-200);
            border-left: 4px solid var(--brand-rose);
            padding: 0.75rem 0.9rem;
            border-radius: 8px;
            font-size: 0.83rem;
        }

        .holiday-badge strong {
            display: block;
            color: var(--brand-rose);
            margin-bottom: 2px;
        }

        .holiday-badge span {
            color: var(--slate-600);
        }

        /* Protocolos de acceso */
        .protocols-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .protocol-box {
            background: #ffffff;
            border-radius: 14px;
            padding: 1.5rem;
            border: 1.5px solid var(--slate-200);
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            transition: border-color 0.2s;
        }

        .protocol-box:hover {
            border-color: var(--brand-accent);
        }

        .protocol-icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #f0f9ff;
            color: #0284c7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .protocol-box h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 0.5rem;
        }

        .protocol-box p {
            font-size: 0.88rem;
            color: var(--slate-600);
            line-height: 1.55;
            margin: 0;
        }

        /* --- RF-03: PRESENTACIÓN DE SERVICIOS POR CATEGORÍAS --- */
        .services-nav-tabs {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }

        .service-tab-btn {
            background: white;
            border: 1.5px solid var(--slate-200);
            color: var(--slate-700);
            padding: 0.75rem 1.4rem;
            border-radius: 30px;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .service-tab-btn i {
            color: var(--brand-accent);
        }

        .service-tab-btn.active,
        .service-tab-btn:hover {
            background: var(--brand-primary);
            border-color: var(--brand-primary);
            color: white;
            box-shadow: 0 6px 18px rgba(30, 58, 138, 0.25);
        }

        .service-tab-btn.active i,
        .service-tab-btn:hover i {
            color: #38bdf8;
        }

        .services-category-panel {
            display: none;
        }

        .services-category-panel.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .services-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.8rem;
        }

        .service-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--slate-200);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease;
            position: relative;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border-color: #bae6fd;
        }

        .service-badge-duration {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 12px;
        }

        .service-card h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--slate-900);
            margin: 0.5rem 0 0.8rem;
            padding-right: 5rem;
            line-height: 1.3;
        }

        .service-card-short {
            font-size: 0.88rem;
            color: var(--slate-600);
            line-height: 1.5;
            margin-bottom: 1.2rem;
            flex-grow: 1;
        }

        .service-card-meta {
            background: #f8fafc;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            margin-bottom: 1.4rem;
            font-size: 0.82rem;
        }

        .service-meta-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .service-meta-row:last-child {
            margin-bottom: 0;
        }

        .service-price-tag {
            color: var(--brand-emerald);
            font-weight: 700;
        }

        .service-card-actions {
            display: flex;
            gap: 0.6rem;
        }

        .btn-service-info {
            background: white;
            border: 1.5px solid var(--slate-200);
            color: var(--slate-700);
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-service-info:hover {
            background: #f8fafc;
            border-color: var(--slate-400);
        }

        .btn-service-book {
            background: var(--brand-primary);
            color: white;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            flex: 1.3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-service-book:hover {
            background: var(--brand-accent);
        }

        /* --- RF-04: PERSONAL MÉDICO Y TÉCNICO --- */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .team-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--slate-200);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .team-header-art {
            height: 120px;
            background: linear-gradient(135deg, #1e3a8a, #0284c7);
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .team-avatar-badge {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: white;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: var(--brand-primary);
            margin-bottom: -42px;
            position: relative;
            z-index: 2;
        }

        .team-body {
            padding: 3.5rem 1.5rem 1.5rem;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .team-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 2px;
        }

        .team-specialty {
            color: var(--brand-accent);
            font-weight: 600;
            font-size: 0.88rem;
            margin-bottom: 0.5rem;
        }

        .team-cedula {
            display: inline-block;
            background: #f1f5f9;
            color: #64748b;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .team-bio {
            font-size: 0.84rem;
            color: var(--slate-600);
            line-height: 1.5;
            margin-bottom: 1.2rem;
            text-align: left;
        }

        .team-services-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--slate-400);
            margin-bottom: 0.5rem;
            text-align: left;
        }

        .team-services-list {
            list-style: none;
            padding: 0;
            margin: 0 0 1.5rem;
            text-align: left;
            flex-grow: 1;
        }

        .team-services-list li {
            font-size: 0.82rem;
            color: var(--slate-700);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .team-services-list li i {
            color: var(--brand-emerald);
            font-size: 0.75rem;
        }

        .btn-team-schedule {
            background: #f8fafc;
            border: 1.5px solid var(--slate-200);
            color: var(--brand-primary);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-team-schedule:hover {
            background: var(--brand-primary);
            color: white;
            border-color: var(--brand-primary);
        }

        /* --- RF-05: INICIO DE AGENDAMIENTO & CALENDARIO SEMANAL --- */
        .calendar-section-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            border: 1px solid var(--slate-200);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }

        .calendar-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--slate-100);
        }

        .calendar-range-title h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--slate-900);
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .calendar-range-title p {
            font-size: 0.9rem;
            color: var(--slate-500);
            margin: 0;
        }

        .calendar-nav-controls {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .btn-week-nav {
            background: #f1f5f9;
            border: 1px solid var(--slate-200);
            color: var(--slate-700);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-week-nav:hover {
            background: var(--slate-200);
            color: var(--slate-900);
        }

        .btn-trigger-schedule {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-trigger-schedule:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        }

        /* Rejilla del Calendario Semanal */
        .calendar-week-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-day-column {
            background: #f8fafc;
            border-radius: 12px;
            border: 1.5px solid var(--slate-200);
            min-height: 280px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .calendar-day-column.today {
            border-color: var(--brand-accent);
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15);
        }

        .day-column-header {
            background: white;
            padding: 0.9rem 0.6rem;
            text-align: center;
            border-bottom: 1px solid var(--slate-200);
        }

        .calendar-day-column.today .day-column-header {
            background: #e0f2fe;
        }

        .day-header-name {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--slate-500);
        }

        .calendar-day-column.today .day-header-name {
            color: var(--brand-primary);
        }

        .day-header-num {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--slate-800);
            line-height: 1.1;
            margin-top: 2px;
        }

        .calendar-day-column.today .day-header-num {
            color: var(--brand-accent);
        }

        .day-column-body {
            padding: 0.6rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .appointment-slot-item {
            background: white;
            border-radius: 8px;
            padding: 0.55rem 0.65rem;
            border-left: 3.5px solid var(--brand-accent);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            font-size: 0.78rem;
            border: 1px solid #e2e8f0;
            border-left-width: 3.5px;
        }

        .appointment-slot-item.confirmada {
            border-left-color: var(--brand-emerald);
        }

        .appointment-slot-item.pendiente {
            border-left-color: var(--brand-amber);
        }

        .slot-time {
            font-weight: 700;
            color: var(--slate-800);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2px;
        }

        .slot-badge {
            font-size: 0.68rem;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .badge-conf {
            background: #dcfce7;
            color: #166534;
        }

        .badge-pend {
            background: #fef3c7;
            color: #92400e;
        }

        .slot-pet {
            font-weight: 600;
            color: var(--brand-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .slot-service {
            font-size: 0.72rem;
            color: var(--slate-500);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .empty-day-placeholder {
            text-align: center;
            color: #94a3b8;
            font-size: 0.78rem;
            padding: 2rem 0.5rem;
            margin: auto;
        }

        .day-book-quick-btn {
            margin-top: auto;
            background: transparent;
            border: 1px dashed var(--slate-300);
            color: var(--slate-600);
            padding: 6px;
            border-radius: 6px;
            font-size: 0.74rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .day-book-quick-btn:hover {
            background: white;
            border-color: var(--brand-accent);
            color: var(--brand-accent);
        }

        /* --- FOOTER MODERNO --- */
        .landing-footer {
            background: var(--slate-900);
            color: #94a3b8;
            padding: 4rem 1.5rem 2rem;
            border-top: 1px solid #1e293b;
        }

        .footer-grid {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 3rem;
            padding-bottom: 3rem;
            border-bottom: 1px solid #1e293b;
        }

        .footer-brand h4 {
            color: white;
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 0.8rem;
        }

        .footer-brand p {
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .footer-col h5 {
            color: white;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-col ul li {
            margin-bottom: 0.7rem;
            font-size: 0.88rem;
        }

        .footer-col ul li a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-col ul li a:hover {
            color: white;
        }

        .footer-bottom {
            max-width: 1240px;
            margin: 2rem auto 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* --- MODAL DE AGENDAMIENTO (RF-05, CON TELÉFONO Y TÉRMINOS) --- */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(5px);
            z-index: 2100;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            overflow-y: auto;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box-lg {
            background: white;
            border-radius: 20px;
            max-width: 680px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2.2rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--slate-200);
            margin-bottom: 1.5rem;
        }

        .modal-box-header h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--slate-900);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-box-header p {
            font-size: 0.85rem;
            color: var(--slate-500);
            margin: 4px 0 0;
        }

        .modal-close-btn {
            background: #f1f5f9;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 1.2rem;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .modal-close-btn:hover {
            background: #e2e8f0;
            color: var(--slate-900);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .input-group-modern {
            margin-bottom: 1.1rem;
        }

        .input-group-modern label {
            display: block;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--slate-700);
            margin-bottom: 6px;
        }

        .input-group-modern input,
        .input-group-modern select,
        .input-group-modern textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--slate-200);
            border-radius: 10px;
            font-size: 0.92rem;
            font-family: inherit;
            color: var(--slate-800);
            background: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .input-group-modern input:focus,
        .input-group-modern select:focus,
        .input-group-modern textarea:focus {
            outline: none;
            border-color: var(--brand-accent);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        /* Términos y condiciones container */
        .terms-acceptance-box {
            background: #f8fafc;
            border: 1.5px solid var(--slate-200);
            border-radius: 12px;
            padding: 1rem;
            margin: 1.3rem 0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .terms-acceptance-box input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--brand-primary);
            cursor: pointer;
            margin-top: 2px;
        }

        .terms-acceptance-box label {
            font-size: 0.85rem;
            color: var(--slate-700);
            line-height: 1.45;
            cursor: pointer;
        }

        .btn-view-terms {
            background: none;
            border: none;
            color: var(--brand-accent);
            font-weight: 700;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            font-size: inherit;
        }

        /* --- NOTIFICACIÓN DE ÉXITO FLOTANTE --- */
        .toast-success-banner {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            padding: 1.2rem 2rem;
            border-radius: 14px;
            max-width: 800px;
            margin: 1.5rem auto 0;
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.25);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        @media (max-width: 992px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .hero-title {
                font-size: 2.3rem;
            }

            .clinic-info-grid {
                grid-template-columns: 1fr;
            }

            .calendar-week-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                display: none;
            }

            .nav-links {
                display: none;
            }

            .calendar-week-grid {
                grid-template-columns: 1fr;
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- TOPBAR INFORMATIVO -->
    <div class="topbar">
        <div class="topbar-info">
            <span><i class="fa-solid fa-phone"></i> {{ $clinicaInfo['telefono'] }}</span>
            <span><i class="fa-brands fa-whatsapp"></i> {{ $clinicaInfo['whatsapp'] }}</span>
            <span><i class="fa-regular fa-envelope"></i> {{ $clinicaInfo['email'] }}</span>
        </div>
        <div class="topbar-info">
            <span class="emergency-pill"><i class="fa-solid fa-truck-medical"></i> Urgencias 24/7</span>
            <span>Sucursal Central Hospital Abierta</span>
        </div>
    </div>

    <!-- NAVBAR PRINCIPAL -->
    <nav class="landing-nav">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="nav-brand-logo">
                    <i class="fa-solid fa-paw"></i>
                </div>
                <div class="nav-brand-text">
                    <h1>VETecNM</h1>
                    <span>Clínica & Hospital</span>
                </div>
            </a>

            <!-- Links de Navegación Centrales -->
            <ul class="nav-menu">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#clinica-info">Clínica & Horarios</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#equipo-medico">Equipo Médico</a></li>
                <li><a href="#calendario">Calendario</a></li>
            </ul>

            <!-- Botones de Acción (Iniciar Sesión, Crear Cuenta, Agendar Cita) -->
            <div class="nav-actions">
                @if (session()->has('user_id'))
                    <a href="{{ route('dashboard') }}" class="btn-nav-login"
                        style="background: #2563eb; color: white; border-color: #2563eb;">
                        <i class="fa-solid fa-user-circle"></i> Mi Panel
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline; margin: 0;">
                        @csrf
                        <button type="submit" class="btn-nav-login"
                            style="border-color: #fecaca; color: #ef4444; background: #fef2f2; cursor: pointer;">
                            <i class="fa-solid fa-right-from-bracket"></i> Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-nav-login">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-nav-register">
                        <i class="fa-solid fa-user-plus"></i> Crear Cuenta
                    </a>
                @endif

                <button class="btn-schedule-nav" onclick="openScheduleModal()">
                    <i class="fa-regular fa-calendar-check"></i> Agendar Cita
                </button>

                <!-- Botón de Menú Móvil -->
                <button class="nav-mobile-toggle" onclick="toggleMobileMenu()" aria-label="Abrir Menú">
                    <i class="fa-solid fa-bars" id="menuToggleIcon"></i>
                </button>
            </div>
        </div>

        <!-- Menú Desplegable Móvil -->
        <div class="nav-mobile-dropdown" id="navMobileDropdown">
            <a href="#inicio" onclick="toggleMobileMenu()"><i class="fa-solid fa-house"></i> Inicio</a>
            <a href="#clinica-info" onclick="toggleMobileMenu()"><i class="fa-solid fa-hospital"></i> Clínica &
                Horarios</a>
            <a href="#servicios" onclick="toggleMobileMenu()"><i class="fa-solid fa-stethoscope"></i> Servicios</a>
            <a href="#equipo-medico" onclick="toggleMobileMenu()"><i class="fa-solid fa-user-doctor"></i> Equipo
                Médico</a>
            <a href="#calendario" onclick="toggleMobileMenu()"><i class="fa-solid fa-calendar-week"></i> Calendario</a>
            <hr style="border: none; border-top: 1px solid var(--slate-200); margin: 0.3rem 0;">
            @if (session()->has('user_id'))
                <a href="{{ route('dashboard') }}" style="color: #2563eb; font-weight: 600;"><i
                        class="fa-solid fa-user-circle"></i> Mi Panel</a>
            @else
                <a href="{{ route('login') }}" style="color: #1e293b; font-weight: 600;"><i
                        class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesión</a>
                <a href="{{ route('register') }}" style="color: #0369a1; font-weight: 600;"><i
                        class="fa-solid fa-user-plus"></i> Crear Cuenta</a>
            @endif
            <button class="btn-schedule-nav" onclick="toggleMobileMenu(); openScheduleModal();"
                style="width: 100%; justify-content: center; margin-top: 0.5rem;">
                <i class="fa-regular fa-calendar-check"></i> Agendar Cita
            </button>
        </div>
    </nav>

    <!-- NOTIFICACIÓN DE CITA AGENDADA CON ÉXITO -->
    @if (session('cita_agendada_ok'))
        @php $infoCita = session('cita_agendada_ok'); @endphp
        <div style="max-width: 1240px; margin: 1.5rem auto -2rem; padding: 0 1.5rem;">
            <div class="toast-success-banner">
                <div style="display:flex; align-items:center; gap: 15px;">
                    <div
                        style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 1.15rem; font-weight: 700;">¡Tu cita ha sido agendada con
                            éxito!</h4>
                        <p style="margin: 3px 0 0; font-size: 0.88rem; opacity: 0.95;">
                            Paciente: <strong>{{ $infoCita['paciente'] }}</strong> (Dueño: {{ $infoCita['dueno'] }}) |
                            Servicio: <strong>{{ $infoCita['servicio'] }}</strong> |
                            Precio: <strong style="color: #ffffff; background: rgba(0,0,0,0.18); padding: 2px 7px; border-radius: 4px;"><i class="fa-solid fa-tag"></i> ${{ number_format($infoCita['precio'] ?? 0, 2) }} MXN</strong> |
                            @if (!empty($infoCita['motivo']))
                                Motivo: <strong>{{ $infoCita['motivo'] }}</strong> |
                            @endif
                            Especialista: <strong>{{ $infoCita['profesional'] ?? 'Asignado por clínica' }}</strong> |
                            Fecha: <strong>{{ $infoCita['fecha'] }}</strong> a las
                            <strong>{{ $infoCita['hora'] }} hrs</strong>.
                            Te contactaremos al teléfono: <strong>{{ $infoCita['telefono'] }}</strong>.
                        </p>
                    </div>
                </div>
                <button onclick="this.parentElement.style.display='none'"
                    style="background:none; border:none; color:white; font-size:1.3rem; cursor:pointer;">&times;</button>
            </div>
        </div>
    @endif

    <!-- HERO SECTION -->
    <section class="hero-section" id="inicio">
        <div class="hero-container">
            <div>
                <div class="hero-badge">
                    <i class="fa-solid fa-award"></i> Hospital Veterinario Certificado & Bienestar Animal
                </div>
                <h2 class="hero-title">
                    Medicina de Vanguardia para tu <span>Mejor Amigo</span>
                </h2>
                <p class="hero-desc">
                    En <strong>VETecNM</strong> combinamos tecnología diagnóstica avanzada, cirugías con monitoreo
                    multiparamétrico y un trato afectuoso y libre de estrés para garantizar la salud y felicidad de tus
                    mascotas.
                </p>
                <div class="hero-actions">
                    <button class="btn-hero-primary" onclick="openScheduleModal()">
                        <i class="fa-regular fa-calendar-plus"></i> Agendar Cita Médica
                    </button>
                    <a href="#servicios" class="btn-hero-secondary">
                        <i class="fa-solid fa-list-check"></i> Explorar Servicios
                    </a>
                </div>
            </div>

            <!-- Tarjeta de Resumen / Estadísticas -->
            <div class="hero-card-stat">
                <div class="stat-banner-grid">
                    <div class="hero-quick-stat">
                        <i class="fa-solid fa-user-doctor"></i>
                        <h4>4 Especialistas</h4>
                        <p>Veterinarios certificados</p>
                    </div>
                    <div class="hero-quick-stat">
                        <i class="fa-solid fa-clock"></i>
                        <h4>24 / 7</h4>
                        <p>Hospital & Urgencias</p>
                    </div>
                    <div class="hero-quick-stat">
                        <i class="fa-solid fa-shield-dog"></i>
                        <h4>4 Categorías</h4>
                        <p>Servicios integrales</p>
                    </div>
                    <div class="hero-quick-stat">
                        <i class="fa-solid fa-hospital"></i>
                        <h4>2 Sucursales</h4>
                        <p>Central y Norte</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================================================================
         RF-02: INFORMACIÓN DE LA CLÍNICA / SUCURSALES / HORARIOS / PROTOCOLOS
         ===================================================================== -->
    <section class="section-wrapper" id="clinica-info">
        <div class="section-header">
            <span class="section-tag">RF-02 • Información Institucional</span>
            <h2 class="section-title">Clínica VETecNM & Sucursales</h2>
            <p class="section-subtitle">
                Conoce nuestras instalaciones, horarios regulares, modificaciones de fechas especiales y los protocolos
                obligatorios de acceso para cuidar la seguridad de todos.
            </p>
        </div>

        <div class="clinic-info-grid">
            <!-- Tarjeta 1: Sucursales y Horarios de Atención -->
            <div class="clinic-card">
                <div class="card-title-icon">
                    <i class="fa-solid fa-clock"></i>
                    <div>
                        <h3>Horarios de Atención</h3>
                        <span style="font-size: 0.82rem; color: #64748b;">Disponibilidad médica semanal y
                            hospitalización</span>
                    </div>
                </div>

                <ul class="hours-list">
                    <li class="hours-item">
                        <strong>Lunes a Viernes:</strong>
                        <span>{{ $clinicaInfo['horarios']['lunes_viernes'] }}</span>
                    </li>
                    <li class="hours-item">
                        <strong>Sábados:</strong>
                        <span>{{ $clinicaInfo['horarios']['sabados'] }}</span>
                    </li>
                    <li class="hours-item">
                        <strong>Domingos:</strong>
                        <span>{{ $clinicaInfo['horarios']['domingos'] }}</span>
                    </li>
                    <li class="hours-item"
                        style="border-bottom: none; background: #fef2f2; padding: 0.7rem 0.8rem; border-radius: 8px; margin-top: 8px;">
                        <strong style="color: #991b1b;"><i class="fa-solid fa-ambulance"></i> Servicio de
                            Urgencias:</strong>
                        <span style="color: #dc2626;">Atención Médica Activa las 24 Horas</span>
                    </li>
                </ul>

                <h4
                    style="margin: 1.5rem 0 0.8rem; font-size: 1rem; color: var(--slate-800); display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-map-location-dot" style="color: var(--brand-accent);"></i> Nuestras
                    Sucursales
                </h4>
                @foreach ($clinicaInfo['sucursales'] as $sucursal)
                    <div
                        style="background: #f8fafc; border: 1px solid var(--slate-200); border-radius: 10px; padding: 0.9rem; margin-bottom: 0.7rem;">
                        <strong
                            style="color: var(--brand-primary); font-size: 0.92rem; display: block;">{{ $sucursal['nombre'] }}</strong>
                        <span style="font-size: 0.84rem; color: #475569; display: block; margin: 2px 0;"><i
                                class="fa-solid fa-location-dot"></i> {{ $sucursal['direccion'] }}</span>
                        <div
                            style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-top: 4px; color: #64748b;">
                            <span><i class="fa-solid fa-phone"></i> {{ $sucursal['telefono'] }}</span>
                            <span class="badge"
                                style="background:#e0f2fe; color:#0369a1;">{{ $sucursal['tipo'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tarjeta 2: Días no laborables y Fechas Especiales -->
            <div class="clinic-card">
                <div class="card-title-icon">
                    <i class="fa-solid fa-calendar-xmark" style="background: #fee2e2; color: #dc2626;"></i>
                    <div>
                        <h3>Días No Laborables & Modificaciones</h3>
                        <span style="font-size: 0.82rem; color: #64748b;">Asuetos oficiales y ajustes de horario en
                            festividades</span>
                    </div>
                </div>

                <p style="font-size: 0.88rem; color: #475569; margin-bottom: 0.8rem;">
                    En los días no laborables oficiales, la clínica opera exclusivamente con <strong>médicos
                        veterinarios de guardia de urgencia 24/7</strong>:
                </p>

                <div class="holidays-badge-grid">
                    @foreach ($clinicaInfo['dias_no_laborables'] as $diaFeriado)
                        <div class="holiday-badge">
                            <strong>{{ $diaFeriado['fecha'] }}</strong>
                            <span>{{ $diaFeriado['motivo'] }}</span>
                        </div>
                    @endforeach
                </div>

                <h4 style="margin: 1.5rem 0 0.8rem; font-size: 1rem; color: var(--slate-800); display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-clock-rotate-left" style="color: var(--brand-amber);"></i> Modificaciones de Horario en Fechas Especiales
                </h4>
                <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 10px; padding: 0.8rem;">
                    @foreach ($clinicaInfo['fechas_especiales'] as $especial)
                        <div
                            style="display: flex; justify-content: space-between; padding: 0.45rem 0; font-size: 0.85rem; border-bottom: 1px dashed #fde68a;">
                            <strong style="color: #92400e;">{{ $especial['fecha'] }}</strong>
                            <span style="color: #b45309; font-weight: 600;">{{ $especial['horario'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Protocolos y Condiciones de Acceso (Uso de correa, transportadora, etc.) -->
        <div style="margin-top: 3.5rem;">
            <div style="text-align: center; margin-bottom: 1.8rem;">
                <span class="section-tag" style="background: #fef3c7; color: #92400e;">Seguridad & Bienestar</span>
                <h3 style="font-size: 1.6rem; font-weight: 800; color: var(--slate-900); margin: 0;">Protocolos y Condiciones de Acceso al Establecimiento</h3>
                <p style="font-size: 0.92rem; color: #64748b; margin-top: 4px;">Por el respeto y bienestar de todos los
                    pacientes y visitantes, es obligatorio cumplir:</p>
            </div>

            <div class="protocols-grid">
                @foreach ($clinicaInfo['protocolos_acceso'] as $protocolo)
                    <div class="protocol-box">
                        <div class="protocol-icon-circle">
                            <i class="fa-solid {{ $protocolo['icono'] }}"></i>
                        </div>
                        <h4>{{ $protocolo['titulo'] }}</h4>
                        <p>{{ $protocolo['descripcion'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- =====================================================================
         RF-03: PRESENTACIÓN DE SERVICIOS POR CATEGORÍAS
         ===================================================================== -->
    <section class="section-wrapper" id="servicios"
        style="background: white; border-top: 1px solid var(--slate-200); border-bottom: 1px solid var(--slate-200); max-width: 100%;">
        <div style="max-width: 1240px; margin: 0 auto;">
            <div class="section-header">
                <span class="section-tag">RF-03 • Catálogo de Servicios</span>
                <h2 class="section-title">Nuestros Servicios Médicos & Estéticos</h2>
                <p class="section-subtitle">
                    Organizados por categorías para tu comodidad. Haz clic en <strong>"Consultar Información"</strong>
                    para ver detalles, preparación requerida y costos aproximados, o agenda directamente tu cita.
                </p>
            </div>

            <!-- Pestañas de Categorías -->
            <div class="services-nav-tabs">
                @foreach ($categoriasServicios as $index => $cat)
                    <button class="service-tab-btn {{ $index === 0 ? 'active' : '' }}"
                        onclick="switchServiceCategory('{{ $cat['id'] }}', this)">
                        <i class="fa-solid {{ $cat['icono'] }}"></i> {{ $cat['nombre'] }}
                    </button>
                @endforeach
            </div>

            <!-- Contenido de las Categorías -->
            @foreach ($categoriasServicios as $index => $cat)
                <div id="cat-panel-{{ $cat['id'] }}"
                    class="services-category-panel {{ $index === 0 ? 'active' : '' }}">
                    <div style="text-align: center; margin-bottom: 2rem; color: #64748b; font-size: 0.95rem;">
                        <i class="fa-solid fa-circle-info" style="color: var(--brand-accent);"></i>
                        {{ $cat['descripcion'] }}
                    </div>

                    <div class="services-cards-grid">
                        @foreach ($cat['servicios'] as $srv)
                            <div class="service-card">
                                <div>
                                    <span class="service-badge-duration"><i class="fa-regular fa-clock"></i>
                                        {{ $srv['duracion'] }}</span>
                                    <h4>{{ $srv['nombre'] }}</h4>
                                    <p class="service-card-short">{{ $srv['descripcion_corta'] }}</p>

                                    <div class="service-card-meta">
                                        <div class="service-meta-row">
                                            <span>Inversión Estimada:</span>
                                            <span class="service-price-tag">{{ $srv['precio_aprox'] }}</span>
                                        </div>
                                        <div class="service-meta-row">
                                            <span>Categoría:</span>
                                            <strong style="color: var(--slate-700);">{{ $cat['nombre'] }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="service-card-actions">
                                    <button class="btn-service-info"
                                        onclick='openServiceDetailModal(@json($srv), "{{ $cat['nombre'] }}")'>
                                        <i class="fa-solid fa-circle-question"></i> Consultar
                                    </button>
                                    <button class="btn-service-book"
                                        onclick='prefillAndOpenSchedule("{{ $srv['nombre'] }}")'>
                                        <i class="fa-regular fa-calendar-check"></i> Agendar
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- =====================================================================
         RF-04: PRESENTACIÓN DE PERSONAL MÉDICO Y TÉCNICO
         ===================================================================== -->
    <section class="section-wrapper" id="equipo-medico">
        <div class="section-header">
            <span class="section-tag">RF-04 • Nuestro Equipo</span>
            <h2 class="section-title">Personal Veterinario & Técnico</h2>
            <p class="section-subtitle">
                Profesionales con amplia experiencia médica y vocación humanitaria para ofrecer el mejor diagnóstico y
                tratamiento a tu compañero.
            </p>
        </div>

        <div class="team-grid">
            @foreach ($personalMedico as $medico)
                <div class="team-card">
                    <div class="team-header-art">
                        <div class="team-avatar-badge">
                            <i class="fa-solid {{ $medico['avatar_icono'] }}"></i>
                        </div>
                    </div>
                    <div class="team-body">
                        <h4 class="team-name">{{ $medico['nombre'] }}</h4>
                        <div class="team-specialty">{{ $medico['especialidad'] }}</div>
                        <div>
                            <span class="team-cedula">{{ $medico['cedula'] }} • {{ $medico['experiencia'] }}</span>
                        </div>
                        <p class="team-bio">{{ $medico['descripcion'] }}</p>

                        <div class="team-services-title">Servicios que ofrece:</div>
                        <ul class="team-services-list">
                            @foreach ($medico['servicios_ofrecidos'] as $srvOfrecido)
                                <li><i class="fa-solid fa-check"></i> {{ $srvOfrecido }}</li>
                            @endforeach
                        </ul>

                        <button class="btn-team-schedule" onclick='prefillDoctorSchedule("{{ $medico['nombre'] }}")'>
                            <i class="fa-regular fa-calendar-plus"></i> Agendar con Especialista
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- =====================================================================
         RF-05: INICIO DE AGENDAMIENTO & CALENDARIO SEMANAL DE CITAS
         ===================================================================== -->
    <section class="section-wrapper" id="calendario"
        style="background: #f1f5f9; max-width: 100%; border-top: 1px solid var(--slate-200);">
        <div style="max-width: 1240px; margin: 0 auto;">
            <div class="section-header">
                <span class="section-tag">RF-05 • Agendamiento en Línea</span>
                <h2 class="section-title">Calendario Semanal & Citas Programadas</h2>
                <p class="section-subtitle">
                    Visualiza en tiempo real las citas médicas programadas de la semana (día, fecha y hora) para
                    consultar la disponibilidad y planificar tu visita con nuestro equipo.
                </p>
            </div>

            <div class="calendar-section-card">
                <!-- Barra superior de navegación de la semana -->
                <div class="calendar-topbar">
                    <div class="calendar-range-title">
                        <h3>
                            <i class="fa-solid fa-calendar-week" style="color: var(--brand-accent);"></i>
                            Semana: {{ $inicioSemana->format('d/m') }} al {{ $finSemana->format('d/m/Y') }}
                        </h3>
                        <p>Mostrando citas de la semana con fecha, hora, estado y disponibilidad en consultorios.</p>
                    </div>

                    <div class="calendar-nav-controls">
                        <a href="{{ route('home', ['offset' => $offsetSemana - 1, '#calendario']) }}"
                            class="btn-week-nav">
                            <i class="fa-solid fa-chevron-left"></i> Semana Anterior
                        </a>
                        @if ($offsetSemana !== 0)
                            <a href="{{ route('home', ['offset' => 0, '#calendario']) }}" class="btn-week-nav"
                                style="background: #e0f2fe; color: #0284c7;">
                                Hoy
                            </a>
                        @endif
                        <a href="{{ route('home', ['offset' => $offsetSemana + 1, '#calendario']) }}"
                            class="btn-week-nav">
                            Próxima Semana <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        <button class="btn-trigger-schedule" onclick="openScheduleModal()">
                            <i class="fa-solid fa-plus-circle"></i> Agendar Cita Ahora
                        </button>
                    </div>
                </div>

                <!-- Rejilla de los 7 días de la semana -->
                <div class="calendar-week-grid">
                    @foreach ($diasSemana as $dia)
                        @php
                            $citasDeEsteDia = $citasPorDia[$dia['fecha_iso']] ?? [];
                        @endphp
                        <div class="calendar-day-column {{ $dia['es_hoy'] ? 'today' : '' }}">
                            <div class="day-column-header">
                                <div class="day-header-name">{{ $dia['dia_nombre'] }}</div>
                                <div class="day-header-num">{{ $dia['dia_numero'] }} {{ $dia['mes_nombre'] }}</div>
                                @if ($dia['es_hoy'])
                                    <span class="badge"
                                        style="background: #0284c7; color: white; font-size: 0.65rem; margin-top: 3px;">HOY</span>
                                @endif
                            </div>

                            <div class="day-column-body">
                                @forelse($citasDeEsteDia as $cita)
                                    <div class="appointment-slot-item {{ strtolower($cita->estado) }}">
                                        <div class="slot-time">
                                            <span><i class="fa-regular fa-clock"></i>
                                                {{ substr($cita->hora, 0, 5) }}</span>
                                            <span
                                                class="slot-badge {{ $cita->estado === 'Confirmada' ? 'badge-conf' : 'badge-pend' }}">
                                                {{ $cita->estado }}
                                            </span>
                                        </div>
                                        <div class="slot-pet">
                                            <i class="fa-solid fa-paw"></i> {{ $cita->mascota_nombre }}
                                            ({{ $cita->mascota_especie }})
                                        </div>
                                        <div class="slot-service" title="{{ $cita->motivo }}">
                                            <i class="fa-solid fa-notes-medical" style="color: #0284c7; font-size: 0.72rem;"></i>
                                            {{ \Illuminate\Support\Str::limit($cita->motivo, 26) }}
                                        </div>
                                        <div class="slot-price" style="font-size: 0.75rem; font-weight: 700; color: #059669; margin-top: 3px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid fa-tag" style="font-size: 0.7rem;"></i>
                                            ${{ number_format($cita->precio ?? \App\Services\CitaService::getPrecioServicio($cita->servicio), 2) }} MXN
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-day-placeholder">
                                        <i class="fa-regular fa-calendar"
                                            style="font-size: 1.3rem; margin-bottom: 4px; display: block; opacity: 0.5;"></i>
                                        Sin citas registradas
                                    </div>
                                @endforelse

                                <button class="day-book-quick-btn"
                                    onclick='prefillDateSchedule("{{ $dia['fecha_iso'] }}")'>
                                    <i class="fa-solid fa-plus"></i> Reservar este día
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="landing-footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <h4><i class="fa-solid fa-paw" style="color: #38bdf8;"></i> VETecNM</h4>
                <p>
                    Comprometidos con la salud, protección y bienestar de tus mascotas. Atención médica ética,
                    tecnología hospitalaria y amor por los animales.
                </p>
                <div style="display: flex; gap: 12px; font-size: 1.2rem; margin-top: 1rem;">
                    <a href="#" style="color: #94a3b8;"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" style="color: #94a3b8;"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" style="color: #94a3b8;"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h5>Navegación Rápida</h5>
                <ul>
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#clinica-info">Información de la Clínica (RF-02)</a></li>
                    <li><a href="#servicios">Servicios por Categoría (RF-03)</a></li>
                    <li><a href="#equipo-medico">Personal Médico (RF-04)</a></li>
                    <li><a href="#calendario">Calendario de Citas (RF-05)</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Acceso al Sistema</h5>
                <ul>
                    <li><a href="{{ route('login') }}"><i class="fa-solid fa-lock"></i> Iniciar Sesión</a></li>
                    <li><a href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i> Registro de
                            Clientes</a></li>
                    <li><a href="{{ route('password.request') }}"><i class="fa-solid fa-key"></i> Recuperar
                            Contraseña</a></li>
                    <li><a href="#" onclick="openTermsModal()"><i class="fa-solid fa-file-contract"></i>
                            Términos y Protocolos</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Contacto Clínico</h5>
                <ul>
                    <li><i class="fa-solid fa-location-dot" style="color: #38bdf8;"></i> Av. Tecnológico #100, Ciudad
                        Guzmán</li>
                    <li><i class="fa-solid fa-phone" style="color: #38bdf8;"></i> {{ $clinicaInfo['telefono'] }}</li>
                    <li><i class="fa-brands fa-whatsapp" style="color: #22c55e;"></i> {{ $clinicaInfo['whatsapp'] }}
                    </li>
                    <li><i class="fa-solid fa-clock" style="color: #eab308;"></i> Urgencias 24 Horas</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; {{ date('Y') }} VETecNM - Plataforma Integral de Servicios Veterinarios. Todos los derechos
                reservados.</div>
            <div>Diseñado conforme a requerimientos de software de gestión médica veterinaria.</div>
        </div>
    </footer>

    <!-- =====================================================================
         MODAL 1: FORMULARIO DE AGENDAMIENTO (RF-05)
         Incluye: Teléfono del usuario + Botón de Aceptar Términos y Condiciones
         ===================================================================== -->
    <div id="modalSchedule" class="modal-overlay">
        <div class="modal-box-lg">
            <div class="modal-box-header">
                <div>
                    <h3><i class="fa-solid fa-calendar-plus" style="color: #0284c7;"></i> Agendar Cita Veterinaria
                    </h3>
                    <p>Completa tus datos de contacto y la información de tu mascota para confirmar tu espacio.</p>
                </div>
                <button class="modal-close-btn" onclick="closeScheduleModal()">&times;</button>
            </div>

            <form action="{{ route('citas.agendar') }}" method="POST" id="formScheduleLanding">
                @csrf

                @if ($errors->any())
                    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 0.75rem 1rem; margin-bottom: 1.2rem; color: #991b1b; font-size: 0.88rem;">
                        <strong style="display: block; margin-bottom: 4px;"><i class="fa-solid fa-triangle-exclamation"></i> Por favor revisa los siguientes campos:</strong>
                        <ul style="margin: 0; padding-left: 1.2rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-grid-2">
                    <!-- Punto 1: Nombre Completo (Permite solo letras y espacios) -->
                    <div class="input-group-modern">
                        <label for="nombre"><i class="fa-regular fa-user"></i> Tu Nombre Completo *</label>
                        <input type="text" id="nombre" name="nombre"
                            value="{{ $usuarioLogueado->nombre ?? old('nombre') }}" placeholder="Ej. Carlos Mendoza"
                            required
                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+"
                            title="Permite solo letras y espacios."
                            oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '')">
                        <small style="color: #64748b; font-size: 0.74rem;">Permite solo letras y espacios.</small>
                    </div>

                    <!-- Punto 2: Teléfono (Acepta estrictamente 10 dígitos numéricos y valida formato telefónico) -->
                    <div class="input-group-modern">
                        <label for="telefono"><i class="fa-solid fa-phone"></i> Teléfono / WhatsApp *</label>
                        <input type="tel" id="telefono" name="telefono"
                            value="{{ $usuarioLogueado->telefono ?? old('telefono') }}"
                            placeholder="Ej. 3411234567"
                            required
                            inputmode="numeric"
                            maxlength="10"
                            minlength="10"
                            pattern="[0-9]{10}"
                            title="Acepta estrictamente 10 dígitos numéricos"
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10)">
                        <small style="color: #64748b; font-size: 0.74rem;">Estrictamente 10 dígitos numéricos.</small>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Punto 3: Correo Electrónico (Valida estructura de e-mail válida: usuario@dominio.com) -->
                    <div class="input-group-modern">
                        <label for="email"><i class="fa-regular fa-envelope"></i> Correo Electrónico *</label>
                        <input type="email" id="email" name="email"
                            value="{{ $usuarioLogueado->email ?? old('email') }}" placeholder="usuario@dominio.com"
                            required
                            pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                            title="Ingresa una estructura válida de e-mail (usuario@dominio.com)">
                        <small style="color: #64748b; font-size: 0.74rem;">Estructura requerida: usuario@dominio.com</small>
                    </div>

                    <!-- Punto 4: Nombre de la Mascota (Campo de texto obligatorio) -->
                    <div class="input-group-modern">
                        <label for="mascota_nombre"><i class="fa-solid fa-paw"></i> Nombre de la Mascota *</label>
                        @if (isset($mascotasUsuario) && $mascotasUsuario->count() > 0)
                            <input list="listaMascotas" id="mascota_nombre" name="mascota_nombre"
                                placeholder="Nombre de tu mascota" required maxlength="100"
                                value="{{ old('mascota_nombre') ?? $mascotasUsuario->first()->nombre }}">
                            <datalist id="listaMascotas">
                                @foreach ($mascotasUsuario as $msc)
                                    <option value="{{ $msc->nombre }}">{{ $msc->especie }} -
                                        {{ $msc->raza ?? 'Mestizo' }}</option>
                                @endforeach
                            </datalist>
                        @else
                            <input type="text" id="mascota_nombre" name="mascota_nombre"
                                placeholder="Ej. Max, Luna, Bobby" required maxlength="100" value="{{ old('mascota_nombre') }}">
                        @endif
                        <small style="color: #64748b; font-size: 0.74rem;">Campo de texto obligatorio.</small>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Punto 5: Especie (Desplegable con opciones predeterminadas: Perro, Gato, etc.) -->
                    <div class="input-group-modern">
                        <label for="especie"><i class="fa-solid fa-shield-dog"></i> Especie *</label>
                        <select id="especie" name="especie" required>
                            <option value="" disabled {{ old('especie') ? '' : 'selected' }}>-- Seleccionar Especie --</option>
                            <option value="Perro" {{ old('especie', 'Perro') === 'Perro' ? 'selected' : '' }}>Perro (Canino)</option>
                            <option value="Gato" {{ old('especie') === 'Gato' ? 'selected' : '' }}>Gato (Felino)</option>
                            <option value="Ave" {{ old('especie') === 'Ave' ? 'selected' : '' }}>Ave</option>
                            <option value="Conejo" {{ old('especie') === 'Conejo' ? 'selected' : '' }}>Conejo</option>
                            <option value="Reptil" {{ old('especie') === 'Reptil' ? 'selected' : '' }}>Reptil</option>
                            <option value="Otro" {{ old('especie') === 'Otro' ? 'selected' : '' }}>Otro animal de compañía</option>
                        </select>
                        <small style="color: #64748b; font-size: 0.74rem;">Opciones predeterminadas (Perro, Gato, etc.).</small>
                    </div>

                    <!-- Punto 6: Especialidad o Categoría para el selector dinámico de servicios -->
                    <div class="input-group-modern">
                        <label for="categoria_filtro"><i class="fa-solid fa-layer-group"></i> Especialidad o Categoría *</label>
                        <select id="categoria_filtro" onchange="filtrarServiciosPorCategoria()">
                            <option value="todas">-- Todas las Especialidades y Categorías --</option>
                            @foreach ($categoriasServicios as $cat)
                                <option value="{{ $cat['nombre'] }}">{{ $cat['nombre'] }}</option>
                            @endforeach
                            <option value="Urgencias">Urgencias Médicas</option>
                        </select>
                        <small style="color: #64748b; font-size: 0.74rem;">Filtra el selector de servicios.</small>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Punto 6: Servicio Deseado (Selector dinámico dependiente de la especialidad o categoría elegida) -->
                    <div class="input-group-modern">
                        <label for="servicio"><i class="fa-solid fa-stethoscope"></i> Servicio Deseado *</label>
                        <select id="servicio" name="servicio" required
                            onchange="sincronizarCategoriaDesdeServicio(); actualizarPrecioLanding(); cargarHorariosLanding();">
                            <option value="">-- Seleccionar Servicio --</option>
                            @foreach ($categoriasServicios as $cat)
                                <optgroup label="{{ $cat['nombre'] }}" data-categoria-group="{{ $cat['nombre'] }}">
                                    @foreach ($cat['servicios'] as $srv)
                                        <option value="{{ $srv['nombre'] }}"
                                            data-categoria="{{ $cat['nombre'] }}"
                                            data-precio="{{ $srv['precio_aprox'] }}"
                                            data-duracion="{{ $srv['duracion'] ?? '' }}"
                                            data-descripcion="{{ $srv['descripcion_corta'] ?? '' }}">
                                            {{ $srv['nombre'] }} ({{ $srv['precio_aprox'] }})
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                            <optgroup label="Urgencias Médicas" data-categoria-group="Urgencias">
                                <option value="Urgencia Médica Inmediata" data-categoria="Urgencias" data-precio="Valoración Inmediata"
                                    data-duracion="Prioridad Alta">Urgencia Médica Inmediata</option>
                            </optgroup>
                            <optgroup label="Consultas Especiales" data-categoria-group="Consultas y Diagnóstico">
                                <option value="Revisión General de Rutina" data-categoria="Consultas y Diagnóstico" data-precio="$350 MXN"
                                    data-duracion="30 - 45 min">Revisión General de Rutina ($350 MXN)</option>
                            </optgroup>
                        </select>

                        <!-- Box de precio dinámico para landing -->
                        <div id="landing_servicio_info_box"
                            style="display: none; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 0.65rem 0.85rem; margin-top: 0.5rem;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-tag" style="color: #059669; font-size: 0.9rem;"></i>
                                    <span style="font-size: 0.78rem; color: #166534; font-weight: 600;">Tarifa
                                        Estimada:</span>
                                    <strong id="landing_servicio_precio"
                                        style="color: #15803d; font-size: 0.95rem;"></strong>
                                </div>
                                <span id="landing_servicio_duracion"
                                    style="font-size: 0.74rem; color: #166534; background: #dcfce7; padding: 2px 8px; border-radius: 12px; font-weight: 500;"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Punto 7: Profesional de Salud / Estética (Selector para filtrar la disponibilidad según el especialista) -->
                    <div class="input-group-modern">
                        <label for="profesional"><i class="fa-solid fa-user-doctor"></i> Profesional de Salud / Estética</label>
                        <select id="profesional" name="profesional" onchange="cargarHorariosLanding()">
                            <option value="">-- Cualquier Profesional Disponible --</option>
                            @foreach ($profesionalesList as $p)
                                <option value="{{ $p['nombre'] }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})
                                </option>
                            @endforeach
                        </select>
                        <small style="color: #64748b; font-size: 0.74rem;">Filtra la disponibilidad según el especialista seleccionado.</small>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Punto 8: Fecha de la Cita (Datepicker funcional que bloquea fechas pasadas o días no laborables) -->
                    <div class="input-group-modern">
                        <label for="fecha"><i class="fa-regular fa-calendar"></i> Fecha de la Cita *</label>
                        <input type="date" id="fecha" name="fecha" min="{{ date('Y-m-d') }}"
                            value="{{ date('Y-m-d') }}" required onchange="validarFechaYHorariosLanding()">
                        <small id="fecha_alerta_landing" style="color: #64748b; font-size: 0.74rem; display: block; margin-top: 2px;">
                            Bloquea fechas pasadas o días no laborables.
                        </small>
                    </div>

                    <!-- Punto 9: Horario Disponible (Carga dinámica de horarios con advertencia si no hay disponibilidad) -->
                    <div class="input-group-modern">
                        <label for="hora"><i class="fa-regular fa-clock"></i> Horario Disponible *</label>
                        <select id="hora" name="hora" required>
                            <option value="">-- Selecciona fecha y especialista --</option>
                        </select>
                        <small id="hora_info_landing"
                            style="color: #64748b; font-size: 0.76rem; display: block; margin-top: 4px;">
                            Muestra solo turnos hábiles sin empalmes ni horarios pasados.
                        </small>
                    </div>
                </div>

                <!-- Punto 10: Motivo de Consulta / Síntomas (Área de texto opcional para detalles breves de la solicitud) -->
                <div class="input-group-modern">
                    <label for="motivo"><i class="fa-solid fa-notes-medical"></i> Motivo de Consulta / Síntomas (Opcional)</label>
                    <textarea id="motivo" name="motivo" rows="2" maxlength="255"
                        placeholder="Describe brevemente si presenta algún síntoma, fecha de última vacuna o solicitud especial..."></textarea>
                    <small style="color: #64748b; font-size: 0.74rem;">Área de texto opcional para detalles breves de la solicitud (máx. 255 caracteres).</small>
                </div>

                <!-- Punto 11: Términos y Condiciones (Checkbox obligatorio para aceptar protocolos RF-02 antes de proceder) -->
                <div class="terms-acceptance-box">
                    <input type="checkbox" id="termsSchedule" name="terms" value="1" required>
                    <label for="termsSchedule">
                        Acepto los <button type="button" class="btn-view-terms" onclick="openTermsModal()">Términos,
                            Condiciones y Protocolos de Acceso (RF-02)</button> de la clínica VETecNM (incluyendo el ingreso
                        obligatorio de perros con correa y collar, y gatos en transportadora rígida).
                    </label>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" class="btn-week-nav" onclick="closeScheduleModal()">Cancelar</button>
                    <button type="submit" class="btn-hero-primary"
                        style="padding: 0.75rem 1.8rem; font-size: 0.95rem;">
                        <i class="fa-regular fa-calendar-check"></i> Confirmar y Agendar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- =====================================================================
         MODAL 2: CONSULTAR INFORMACIÓN DE SERVICIO (RF-03)
         ===================================================================== -->
    <div id="modalServiceDetail" class="modal-overlay">
        <div class="modal-box-lg" style="max-width: 600px;">
            <div class="modal-box-header">
                <div>
                    <span id="modalSrvCategory" class="badge"
                        style="background: #e0f2fe; color: #0369a1; margin-bottom: 4px; display: inline-block;">Categoría</span>
                    <h3 id="modalSrvTitle" style="color: var(--slate-900);">Nombre del Servicio</h3>
                </div>
                <button class="modal-close-btn" onclick="closeServiceDetailModal()">&times;</button>
            </div>

            <div style="color: var(--slate-700); font-size: 0.92rem; line-height: 1.6;">
                <p id="modalSrvDescription" style="margin-bottom: 1.2rem; color: #334155; font-size: 0.95rem;"></p>

                <div
                    style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; border: 1px solid var(--slate-200); margin-bottom: 1.2rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.8rem;">
                        <div>
                            <strong
                                style="color: var(--slate-500); font-size: 0.8rem; text-transform: uppercase; display: block;">Duración
                                Estimada:</strong>
                            <span id="modalSrvDuration" style="font-weight: 600; color: var(--slate-800);"></span>
                        </div>
                        <div>
                            <strong
                                style="color: var(--slate-500); font-size: 0.8rem; text-transform: uppercase; display: block;">Inversión
                                Aproximada:</strong>
                            <span id="modalSrvPrice" style="font-weight: 700; color: var(--brand-emerald);"></span>
                        </div>
                    </div>

                    <div style="margin-bottom: 0.8rem;">
                        <strong
                            style="color: var(--slate-500); font-size: 0.8rem; text-transform: uppercase; display: block;">¿Qué
                            incluye este servicio?:</strong>
                        <span id="modalSrvIncludes" style="color: var(--slate-700);"></span>
                    </div>

                    <div>
                        <strong
                            style="color: var(--slate-500); font-size: 0.8rem; text-transform: uppercase; display: block;">Requisitos
                            / Preparación Previa:</strong>
                        <span id="modalSrvRequirements" style="color: #b45309;"></span>
                    </div>
                </div>
            </div>

            <div
                style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem; border-top: 1px solid var(--slate-200); padding-top: 1.2rem;">
                <button type="button" class="btn-week-nav" onclick="closeServiceDetailModal()">Cerrar</button>
                <button type="button" id="btnBookFromModal" class="btn-hero-primary"
                    style="padding: 0.65rem 1.4rem; font-size: 0.9rem;">
                    <i class="fa-regular fa-calendar-check"></i> Agendar este Servicio
                </button>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         MODAL 3: TÉRMINOS, CONDICIONES & PROTOCOLOS DE ACCESO (RF-02)
         ===================================================================== -->
    <div id="modalTermsLanding" class="modal-overlay">
        <div class="modal-box-lg" style="max-width: 620px;">
            <div class="modal-box-header">
                <div>
                    <h3><i class="fa-solid fa-file-contract" style="color: var(--brand-primary);"></i> Términos,
                        Condiciones y Protocolos</h3>
                    <p>Clínica Veterinaria VETecNM • Políticas de Acceso y Servicios</p>
                </div>
                <button class="modal-close-btn" onclick="closeTermsModal()">&times;</button>
            </div>

            <div
                style="color: #334155; font-size: 0.9rem; line-height: 1.65; max-height: 60vh; overflow-y: auto; padding-right: 8px;">
                <h4 style="color: var(--brand-primary); margin-bottom: 0.4rem; font-size: 1rem;">1. Protocolos de
                    Acceso Seguro (RF-02)</h4>
                <p style="margin-bottom: 0.8rem;">
                    • <strong>Caninos:</strong> Todo perro que ingrese a las instalaciones debe portar correa y collar o
                    pechera resistente. En caso de ejemplares reactivos, asustadizos o con antecedentes de nerviosismo
                    ante otros animales, es obligatorio el uso de bozal preventivo.
                    <br>• <strong>Felinos y Pequeños Mamíferos:</strong> Los gatos, cuyos y conejos deben transportarse
                    estrictamente en transportadoras rígidas, ventiladas y aseguradas para evitar incidentes por estrés
                    o ruidos ajenos.
                </p>

                <h4 style="color: var(--brand-primary); margin-bottom: 0.4rem; font-size: 1rem;">2. Acompañamiento y
                    Cuidado en Consultorios</h4>
                <p style="margin-bottom: 0.8rem;">
                    Para mantener un ambiente tranquilo que facilite la exploración clínica, se admite como máximo a
                    <strong>un acompañante por paciente</strong> en el área de consultorios.
                </p>

                <h4 style="color: var(--brand-primary); margin-bottom: 0.4rem; font-size: 1rem;">3. Políticas de Citas,
                    Horarios y Puntualidad</h4>
                <p style="margin-bottom: 0.8rem;">
                    • Se solicita llegar con <strong>10 minutos de anticipación</strong> a la hora programada.
                    <br>• En caso de no poder asistir, agradecemos cancelar o reprogramar con al menos <strong>2 horas
                        de anticipación</strong> para liberar el espacio en el calendario a otros pacientes.
                </p>

                <h4 style="color: var(--brand-primary); margin-bottom: 0.4rem; font-size: 1rem;">4. Confidencialidad y
                    Uso del Teléfono de Contacto</h4>
                <p style="margin-bottom: 0.8rem;">
                    El teléfono proporcionado será utilizado únicamente por el equipo médico y de recepción de VETecNM
                    para confirmar citas, dar seguimiento postoperatorio y enviar recordatorios de salud veterinaria.
                </p>
            </div>

            <div
                style="margin-top: 1.5rem; text-align: right; border-top: 1px solid var(--slate-200); padding-top: 1rem;">
                <button type="button" onclick="acceptTermsAndCloseModal()" class="btn-hero-primary"
                    style="padding: 0.65rem 1.6rem; font-size: 0.9rem;">
                    Aceptar y Entendido
                </button>
            </div>
        </div>
    </div>

    <!-- SCRIPTS INTERACTIVOS -->
    <script>
        // Pestañas de Servicios (RF-03)
        function switchServiceCategory(catId, btnElement) {
            document.querySelectorAll('.service-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.services-category-panel').forEach(p => p.classList.remove('active'));

            btnElement.classList.add('active');
            const targetPanel = document.getElementById('cat-panel-' + catId);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        }

        function actualizarPrecioLanding() {
            const select = document.getElementById('servicio');
            const box = document.getElementById('landing_servicio_info_box');
            const precioEl = document.getElementById('landing_servicio_precio');
            const duracionEl = document.getElementById('landing_servicio_duracion');

            if (!select || !box) return;

            const selectedOpt = select.options[select.selectedIndex];
            if (selectedOpt && selectedOpt.value && selectedOpt.getAttribute('data-precio')) {
                const precio = selectedOpt.getAttribute('data-precio');
                const duracion = selectedOpt.getAttribute('data-duracion') || '';

                precioEl.textContent = precio;
                duracionEl.textContent = duracion ? 'Duración: ' + duracion : '';
                duracionEl.style.display = duracion ? 'inline-block' : 'none';
                box.style.display = 'block';
            } else {
                box.style.display = 'none';
            }
        }

        // Modal de Agendamiento (RF-05, R-30, R-31, R-32)
        function openScheduleModal() {
            document.getElementById('modalSchedule').classList.add('active');
            actualizarPrecioLanding();
            cargarHorariosLanding();
        }

        function closeScheduleModal() {
            document.getElementById('modalSchedule').classList.remove('active');
        }

        // Cargar horarios disponibles dinámicos (R-31)
        function cargarHorariosLanding() {
            const fecha = document.getElementById('fecha').value;
            const profesionalSelect = document.getElementById('profesional');
            const profesional = profesionalSelect ? profesionalSelect.value : '';
            const servicio = document.getElementById('servicio').value;
            const selectHora = document.getElementById('hora');
            const info = document.getElementById('hora_info_landing');

            if (!fecha) return;

            selectHora.innerHTML = '<option value="">Consultando disponibilidad...</option>';

            fetch(
                    `/api/citas/disponibilidad?fecha=${fecha}&profesional=${encodeURIComponent(profesional)}&servicio=${encodeURIComponent(servicio)}`)
                .then(res => res.json())
                .then(data => {
                    selectHora.innerHTML = '';
                    if (!data.disponible || !data.slots || data.slots.length === 0) {
                        selectHora.innerHTML = '<option value="">No hay horarios disponibles</option>';
                        if (info) info.textContent = data.motivo_cierre || 'No hay horarios disponibles en esta fecha.';
                        mostrarAlertaAzulLanding('El horario ya no se encuentra disponible.', data.motivo_cierre ||
                            'Por favor selecciona otra fecha o profesional.');
                    } else {
                        if (info) info.textContent =
                            `${data.slots.length} turnos disponibles respetando recesos y anticipación mínima.`;
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

        // Modal azul de alerta (R-32)
        function mostrarAlertaAzulLanding(mensaje, detalle = '') {
            const modal = document.getElementById('modalAlertaAzulLanding');
            if (modal) {
                document.getElementById('alertaAzulTextoLanding').innerText = mensaje ||
                    'El horario ya no se encuentra disponible.';
                document.getElementById('alertaAzulDetalleLanding').innerText = detalle || '';
                modal.style.display = 'flex';
                modal.classList.add('active');
            }
        }

        function closeAlertaAzulLanding() {
            const modal = document.getElementById('modalAlertaAzulLanding');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('active');
            }
        }

        function prefillAndOpenSchedule(serviceName) {
            const select = document.getElementById('servicio');
            if (select) {
                let found = false;
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value === serviceName) {
                        select.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    select.value = serviceName;
                }
            }
            openScheduleModal();
        }

        function prefillDateSchedule(dateIso) {
            const dateInput = document.getElementById('fecha');
            if (dateInput) {
                dateInput.value = dateIso;
            }
            openScheduleModal();
        }

        function prefillDoctorSchedule(doctorName) {
            const docSelect = document.getElementById('profesional');
            if (docSelect) {
                for (let i = 0; i < docSelect.options.length; i++) {
                    if (docSelect.options[i].value === doctorName || docSelect.options[i].text.includes(doctorName)) {
                        docSelect.selectedIndex = i;
                        break;
                    }
                }
            }

            const motivoInput = document.getElementById('motivo');
            if (motivoInput) {
                motivoInput.value = 'Solicito consulta con: ' + doctorName + '. ';
            }
            openScheduleModal();
        }

        // Modal de Información del Servicio (RF-03)
        function openServiceDetailModal(srv, categoryName) {
            document.getElementById('modalSrvCategory').innerText = categoryName;
            document.getElementById('modalSrvTitle').innerText = srv.nombre;
            document.getElementById('modalSrvDescription').innerText = srv.descripcion_larga;
            document.getElementById('modalSrvDuration').innerText = srv.duracion;
            document.getElementById('modalSrvPrice').innerText = srv.precio_aprox;
            document.getElementById('modalSrvIncludes').innerText = srv.incluye;
            document.getElementById('modalSrvRequirements').innerText = srv.requisitos;

            const bookBtn = document.getElementById('btnBookFromModal');
            bookBtn.onclick = function() {
                closeServiceDetailModal();
                prefillAndOpenSchedule(srv.nombre);
            };

            document.getElementById('modalServiceDetail').classList.add('active');
        }

        function closeServiceDetailModal() {
            document.getElementById('modalServiceDetail').classList.remove('active');
        }

        // Modal de Términos y Condiciones
        function openTermsModal() {
            document.getElementById('modalTermsLanding').classList.add('active');
        }

        function closeTermsModal() {
            document.getElementById('modalTermsLanding').classList.remove('active');
        }

        function acceptTermsAndCloseModal() {
            const chk = document.getElementById('termsSchedule');
            if (chk) chk.checked = true;
            closeTermsModal();
        }

        // Menú Móvil Toggle
        function toggleMobileMenu() {
            const dropdown = document.getElementById('navMobileDropdown');
            const icon = document.getElementById('menuToggleIcon');
            if (dropdown) {
                dropdown.classList.toggle('active');
                if (icon) {
                    if (dropdown.classList.contains('active')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-xmark');
                    } else {
                        icon.classList.remove('fa-xmark');
                        icon.classList.add('fa-bars');
                    }
                }
            }
        }

        // Cerrar modales con clic fuera del contenedor
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
                e.target.style.display = 'none';
            }
        });

        // Mostrar alerta azul si el backend notificó no disponibilidad (R-32)
        @if (session('horario_no_disponible_alerta'))
            window.addEventListener('DOMContentLoaded', function() {
                mostrarAlertaAzulLanding(
                    @json(session('horario_no_disponible_alerta')['mensaje']),
                    @json(session('horario_no_disponible_alerta')['detalle'] ?? '')
                );
            });
        @endif

        @if (session('alerta_error_general'))
            window.addEventListener('DOMContentLoaded', function() {
                alert(@json(session('alerta_error_general')));
            });
        @endif
    </script>

    <!-- =====================================================================
         R-32 REQUISITO VISUAL EXPLÍCITO:
         "emergerá una ventana de color azul con icono de alerta blanco notificando
         que el horario ya no se encuentra disponible."
         ===================================================================== -->
    <div id="modalAlertaAzulLanding" class="modal-overlay" style="z-index: 99999; display: none;">
        <div
            style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%); color: white; padding: 2.2rem 2.5rem; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(29, 78, 216, 0.5); max-width: 460px; width: 100%; border: 2px solid rgba(255, 255, 255, 0.2); text-align: center; margin: auto;">
            <div
                style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.2rem auto; border: 2px solid rgba(255,255,255,0.5);">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 3rem; color: #ffffff;"></i>
            </div>
            <h3 style="color: #ffffff; font-size: 1.5rem; margin: 0 0 8px 0; font-weight: 700;">
                ¡Horario No Disponible!
            </h3>
            <p id="alertaAzulTextoLanding" style="color: #e0f2fe; font-size: 1.05rem; line-height: 1.5; margin: 0;">
                El horario ya no se encuentra disponible.
            </p>
            <p id="alertaAzulDetalleLanding"
                style="color: #bae6fd; font-size: 0.88rem; margin-top: 10px; font-style: italic;">
            </p>
            <div style="margin-top: 1.5rem;">
                <button type="button" onclick="closeAlertaAzulLanding()"
                    style="background: #ffffff; color: #1d4ed8; border: none; padding: 0.8rem 1.8rem; font-size: 0.95rem; font-weight: 700; border-radius: 8px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Entendido, Elegir Otro Horario
                </button>
            </div>
        </div>
    </div>
</body>

</html>
