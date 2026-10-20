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
        }

        /* =====================================================================
           CATÁLOGO & TABLA ESTÉTICA DE PRODUCTOS EN LANDING PAGE
           ===================================================================== */
        #productos {
            background: #ffffff;
            border-top: 1px solid var(--slate-200);
            border-bottom: 1px solid var(--slate-200);
            padding: 5rem 1.5rem;
        }

        .catalog-table-wrapper {
            max-width: 1280px;
            margin: 0 auto;
        }

        /* Barra de herramientas de la tabla */
        .catalog-table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
            background: #f8fafc;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        .catalog-toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 280px;
            flex-wrap: wrap;
        }

        .catalog-search-box {
            position: relative;
            flex: 1;
            min-width: 240px;
            max-width: 440px;
        }

        .catalog-search-box input {
            width: 100%;
            padding: 0.65rem 2.2rem 0.65rem 2.5rem;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            font-size: 0.88rem;
            color: #1e293b;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .catalog-search-box input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .catalog-search-box .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .catalog-search-box .clear-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 0.85rem;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .catalog-search-box .clear-btn:hover {
            color: #1e293b;
        }

        .catalog-category-select {
            padding: 0.65rem 1rem;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            font-size: 0.88rem;
            font-weight: 500;
            color: #334155;
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .catalog-category-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .catalog-toolbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .catalog-items-counter {
            font-size: 0.88rem;
            font-weight: 600;
            color: #64748b;
        }

        .btn-cart-toolbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: #ffffff;
            border: none;
            padding: 0.65rem 1.25rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-cart-toolbar:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.38);
        }

        .cart-pill-badge {
            background: #ef4444;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 9999px;
            min-width: 18px;
            text-align: center;
        }

        .cart-total-badge {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Estructura estética de la tabla */
        .landing-table-container {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .landing-catalog-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.92rem;
        }

        .landing-catalog-table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 1.1rem 1.25rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .landing-catalog-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s ease;
        }

        .landing-catalog-table tbody tr:hover {
            background: #f8fafc;
        }

        .landing-catalog-table td {
            padding: 1.1rem 1.25rem;
            vertical-align: middle;
        }

        .product-cell-flex {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .product-mini-thumb {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            font-size: 1.35rem;
            background: #f8fafc;
        }

        .product-mini-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-cell-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.96rem;
            margin-bottom: 3px;
            cursor: pointer;
            transition: color 0.15s;
        }

        .product-cell-name:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .product-cell-desc {
            color: #64748b;
            font-size: 0.82rem;
            line-height: 1.35;
            max-width: 360px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-cat-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            white-space: nowrap;
        }

        .product-cat-tag.theme-general { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .product-cat-tag.theme-alimentos { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .product-cat-tag.theme-accesorios { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
        .product-cat-tag.theme-higiene { background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; }
        .product-cat-tag.theme-farmacia { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }

        .product-price-cell strong {
            font-size: 1.1rem;
            font-weight: 800;
            color: #059669;
        }

        .product-price-cell small {
            font-size: 0.75rem;
            font-weight: 700;
            color: #10b981;
            margin-left: 2px;
        }

        .stock-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .stock-pill.in-stock { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .stock-pill.low-stock { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .stock-pill.out-stock { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        .product-table-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .btn-action-info {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #334155;
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .btn-action-info:hover {
            border-color: #2563eb;
            color: #2563eb;
            background: #eff6ff;
        }

        .btn-action-add {
            background: #2563eb;
            border: 1.5px solid #2563eb;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
            white-space: nowrap;
        }

        .btn-action-add:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        .btn-action-wa {
            background: #10b981;
            border: 1.5px solid #10b981;
            color: #ffffff !important;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            font-size: 0.88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }

        .btn-action-wa:hover {
            background: #059669;
            border-color: #059669;
            transform: translateY(-1px);
        }

        /* Botón Flotante del Carrito (FAB) */
        .floating-cart-fab {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 999;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
            cursor: pointer;
            font-weight: 700;
            font-size: 0.92rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .floating-cart-fab:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 14px 30px rgba(37, 99, 235, 0.5);
        }

        /* Toast Notificación */
        .toast-catalog-feedback {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #0f172a;
            color: #ffffff;
            padding: 12px 22px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
        }

        .toast-catalog-feedback.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
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
                <li><a href="#productos">Productos</a></li>
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
            <a href="#productos" onclick="toggleMobileMenu()"><i class="fa-solid fa-boxes-packing"></i> Catálogo de Productos</a>
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
         CATÁLOGO DE PRODUCTOS & FARMACIA VETERINARIA
         ===================================================================== -->
    <section class="section-wrapper" id="productos">
        <div class="catalog-table-wrapper">
            <div class="section-header" style="margin-bottom: 2rem;">
                <span class="section-tag" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                    <i class="fa-solid fa-boxes-packing"></i> Catálogo Oficial VETecNM
                </span>
                <h2 class="section-title">Productos, Alimentos y Cuidados Veterinarios</h2>
                <p class="section-subtitle">
                    Alimentos de prescripción médica, suplementos nutricionales, productos de higiene dermatológica y accesorios certificados. Consulta su información o agrégalos a tu carrito de consulta médica.
                </p>
            </div>

            <!-- Barra de Controles y Filtros de la Tabla -->
            <div class="catalog-table-toolbar">
                <div class="catalog-toolbar-left">
                    <div class="catalog-search-box">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="inputBusquedaProductosLanding" placeholder="Buscar por producto, marca o indicación..." oninput="filtrarTablaProductosLanding()">
                        <button type="button" id="btn_clear_catalog_search" class="clear-btn" onclick="clearCatalogSearchLanding()" style="display: none;" title="Limpiar búsqueda">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <select id="selectCategoriaProductosLanding" class="catalog-category-select" onchange="cambiarFiltroCategoriaSelect(this.value)">
                        <option value="todas">Todas las categorías ({{ $productosLanding->count() }})</option>
                        @foreach ($categoriasProductos as $cat)
                            <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }} ({{ $cat->total_productos }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="catalog-toolbar-right">
                    <span id="landing_prods_count" class="catalog-items-counter">
                        {{ $productosLanding->count() }} producto(s)
                    </span>

                    <button type="button" class="btn-cart-toolbar" onclick="openCartModalLanding()" title="Ver carrito de consulta y cotización">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Carrito de Consulta</span>
                        <span id="cartCountBadge" class="cart-pill-badge">0</span>
                        <span id="cartTotalSummary" class="cart-total-badge">$0.00 MXN</span>
                    </button>
                </div>
            </div>

            <!-- Tabla Estética de Productos -->
            <div class="landing-table-container">
                <table class="landing-catalog-table" id="tablaProductosLanding">
                    <thead>
                        <tr>
                            <th style="min-width: 290px;">Producto & Descripción</th>
                            <th style="min-width: 140px;">Categoría</th>
                            <th style="min-width: 130px;">Precio</th>
                            <th style="min-width: 150px;">Disponibilidad</th>
                            <th style="min-width: 200px; text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productosLanding as $prod)
                            @php
                                $catLower = strtolower($prod->categoria_nombre ?? '');
                                $prodIcon = 'fa-box-open';
                                $iconColor = '#2563eb';
                                $themeClass = 'theme-general';
                                $gradientBg = 'linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%)';
                                if (str_contains($catLower, 'alimento') || str_contains($catLower, 'comida')) {
                                    $prodIcon = 'fa-bowl-food';
                                    $iconColor = '#d97706';
                                    $themeClass = 'theme-alimentos';
                                    $gradientBg = 'linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%)';
                                } elseif (str_contains($catLower, 'accesorio') || str_contains($catLower, 'correa') || str_contains($catLower, 'collar')) {
                                    $prodIcon = 'fa-vest-patches';
                                    $iconColor = '#0284c7';
                                    $themeClass = 'theme-accesorios';
                                    $gradientBg = 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)';
                                } elseif (str_contains($catLower, 'higiene') || str_contains($catLower, 'baño') || str_contains($catLower, 'champu')) {
                                    $prodIcon = 'fa-soap';
                                    $iconColor = '#0d9488';
                                    $themeClass = 'theme-higiene';
                                    $gradientBg = 'linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%)';
                                } elseif (str_contains($catLower, 'medicamento') || str_contains($catLower, 'farmacia')) {
                                    $prodIcon = 'fa-pills';
                                    $iconColor = '#7c3aed';
                                    $themeClass = 'theme-farmacia';
                                    $gradientBg = 'linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%)';
                                }
                            @endphp
                            <tr class="row-product-item"
                                data-categoria="{{ $prod->id_categoria ?? 'general' }}"
                                data-nombre="{{ strtolower($prod->nombre) }}"
                                data-desc="{{ strtolower($prod->descripcion ?? '') }}">
                                <td>
                                    <div class="product-cell-flex">
                                        <div class="product-mini-thumb" style="background: {{ $gradientBg }};">
                                            @if (!empty($prod->imagen_url))
                                                <img src="{{ $prod->imagen_url }}" alt="{{ $prod->nombre }}">
                                            @else
                                                <i class="fa-solid {{ $prodIcon }}" style="color: {{ $iconColor }};"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="product-cell-name" onclick='openProductDetailLanding(@json($prod))' title="Ver información del producto">
                                                {{ $prod->nombre }}
                                            </div>
                                            <div class="product-cell-desc">
                                                {{ Str::limit($prod->descripcion ?? 'Producto de calidad profesional veterinaria certificado por VETecNM.', 85) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="product-cat-tag {{ $themeClass }}">
                                        <i class="fa-solid {{ $prodIcon }}"></i> {{ $prod->categoria_nombre ?? 'General' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="product-price-cell">
                                        <strong>${{ number_format($prod->precio, 2) }}</strong>
                                        <small>MXN</small>
                                    </div>
                                </td>
                                <td>
                                    @if ($prod->stock > 5)
                                        <span class="stock-pill in-stock" title="{{ $prod->stock }} unidades disponibles">
                                            <i class="fa-solid fa-circle-check"></i> Disponible ({{ $prod->stock }})
                                        </span>
                                    @elseif ($prod->stock > 0)
                                        <span class="stock-pill low-stock" title="Solo quedan {{ $prod->stock }} unidades">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Pocas piezas ({{ $prod->stock }})
                                        </span>
                                    @else
                                        <span class="stock-pill out-stock">
                                            <i class="fa-solid fa-circle-xmark"></i> Agotado
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <div class="product-table-actions">
                                        <button type="button" class="btn-action-info" onclick='openProductDetailLanding(@json($prod))' title="Ver información detallada">
                                            <i class="fa-regular fa-eye"></i> Info
                                        </button>
                                        <button type="button" class="btn-action-add" onclick='agregarAlCarritoLanding(@json($prod))' title="Agregar a mi consulta">
                                            <i class="fa-solid fa-cart-plus"></i> Agregar
                                        </button>
                                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $clinicaInfo['whatsapp']) }}?text={{ urlencode('Hola VETecNM, me gustaría consultar la disponibilidad del producto: ' . $prod->nombre . ' (Código #' . $prod->id_producto . ')') }}"
                                            target="_blank" class="btn-action-wa" title="Consultar por WhatsApp">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                                    <i class="fa-solid fa-boxes-packing" style="font-size: 2.2rem; color: #cbd5e1; margin-bottom: 0.6rem; display: block;"></i>
                                    <h4 style="color: #64748b; font-weight: 700; margin: 0 0 4px 0;">Catálogo en Actualización</h4>
                                    <p style="margin: 0; font-size: 0.88rem;">Pronto tendremos nuevos productos disponibles en nuestra farmacia y tienda.</p>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="landing_prods_no_results_row" style="display: none;">
                            <td colspan="5" style="text-align: center; padding: 3rem 1.5rem; color: #94a3b8;">
                                <i class="fa-solid fa-magnifying-glass" style="font-size: 2rem; color: #cbd5e1; margin-bottom: 0.8rem; display: block;"></i>
                                <h4 style="color: #0f172a; font-weight: 700; margin: 0 0 6px 0; font-size: 1.05rem;">No se encontraron productos coincidentes</h4>
                                <p style="margin: 0 0 1rem 0; font-size: 0.88rem; color: #64748b;">Prueba con otra palabra clave o selecciona otra categoría.</p>
                                <button type="button" class="btn-action-info" onclick="resetProductSearchLanding()">
                                    <i class="fa-solid fa-arrow-rotate-left"></i> Restablecer Filtros
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                    <li><a href="#productos">Catálogo de Productos & Farmacia</a></li>
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
                            onchange="sincronizarCategoriaDesdeServicio(); actualizarPrecioLanding(); filtrarProfesionalesLanding(); cargarHorariosLanding();">
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
                                <option value="{{ $p['nombre'] }}" data-tipo="{{ $p['tipo'] ?? 'salud' }}">{{ $p['nombre'] }} ({{ $p['especialidad'] }})
                                </option>
                            @endforeach
                        </select>
                        <!-- Indicador de médico fijado cuando se agenda con un especialista específico -->
                        <div id="doctor_lock_indicator" style="display: none; align-items: center; justify-content: space-between; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 0.5rem 0.75rem; margin-top: 0.45rem;">
                            <div style="display: flex; align-items: center; gap: 7px; font-size: 0.78rem; color: #1e40af; font-weight: 600;">
                                <i class="fa-solid fa-lock" style="color: #2563eb;"></i>
                                <span>Especialista fijado: <strong id="locked_doctor_name"></strong></span>
                            </div>
                            <button type="button" onclick="unlockDoctorSchedule()" style="background: #dbeafe; border: 1px solid #bfdbfe; color: #1d4ed8; font-size: 0.73rem; font-weight: 600; cursor: pointer; border-radius: 4px; padding: 2px 7px; display: inline-flex; align-items: center; gap: 4px;" title="Permitir seleccionar otro profesional">
                                <i class="fa-solid fa-unlock"></i> Cambiar
                            </button>
                        </div>
                        <small id="profesional_hint_landing" style="color: #64748b; font-size: 0.74rem; display: block; margin-top: 3px;">
                            Filtra la disponibilidad según el especialista seleccionado.
                        </small>
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

        const landingProfesionalesList = @json($profesionalesList);
        const landingMapaServiciosProfesionales = @json($mapaServiciosProfesionales ?? []);
        let lockedDoctorLanding = null;

        function filtrarProfesionalesLanding() {
            const servicioSelect = document.getElementById('servicio');
            const profSelect = document.getElementById('profesional');
            const hint = document.getElementById('profesional_hint_landing');
            if (!servicioSelect || !profSelect) return;

            // Si el médico está bloqueado/fijado, no sobreescribir la selección
            if (lockedDoctorLanding) {
                profSelect.value = lockedDoctorLanding;
                if (hint) {
                    hint.innerHTML = `<span style="color: #2563eb; font-weight: 600;"><i class="fa-solid fa-lock"></i> Especialista fijado: ${lockedDoctorLanding}.</span>`;
                }
                return;
            }

            const selectedServicio = servicioSelect.value.trim();
            const prevSelectedProf = profSelect.value;

            let aptos = [];
            if (!selectedServicio) {
                aptos = landingProfesionalesList;
            } else if (landingMapaServiciosProfesionales && landingMapaServiciosProfesionales[selectedServicio]) {
                const nombresAptos = landingMapaServiciosProfesionales[selectedServicio];
                aptos = landingProfesionalesList.filter(p => nombresAptos.includes(p.nombre));
            } else {
                const srvLower = selectedServicio.toLowerCase();
                const optSelected = servicioSelect.options[servicioSelect.selectedIndex];
                const catGroup = optSelected ? (optSelected.getAttribute('data-categoria') || '') : '';

                if (catGroup.toLowerCase().includes('estética') || srvLower.includes('baño') || srvLower.includes('corte') || srvLower.includes('estilismo') || srvLower.includes('profilaxis')) {
                    aptos = landingProfesionalesList.filter(p => p.tipo === 'estetica');
                } else if (srvLower.includes('cirug') || srvLower.includes('esteril') || srvLower.includes('castra') || srvLower.includes('trauma')) {
                    aptos = landingProfesionalesList.filter(p => p.id === 'dra-valenzuela' || p.tipo === 'salud');
                } else if (srvLower.includes('rayos') || srvLower.includes('imagen') || srvLower.includes('ultrasonido')) {
                    aptos = landingProfesionalesList.filter(p => p.id === 'dr-gomez' || p.tipo === 'salud');
                } else {
                    aptos = landingProfesionalesList.filter(p => p.tipo === 'salud');
                }
            }

            if (aptos.length === 0) {
                aptos = landingProfesionalesList;
            }

            profSelect.innerHTML = '<option value="">-- Cualquier Profesional Disponible --</option>';
            let preserve = false;
            aptos.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.nombre;
                opt.textContent = `${p.nombre} (${p.especialidad})`;
                if (p.nombre === prevSelectedProf) {
                    opt.selected = true;
                    preserve = true;
                }
                profSelect.appendChild(opt);
            });

            if (!preserve && prevSelectedProf) {
                profSelect.value = '';
            }

            if (hint) {
                if (selectedServicio) {
                    hint.innerHTML = `<span style="color: #059669; font-weight: 600;"><i class="fa-solid fa-user-check"></i> ${aptos.length} especialista(s) calificado(s) para este servicio.</span>`;
                } else {
                    hint.innerHTML = 'Filtra la disponibilidad según el especialista seleccionado.';
                }
            }
        }

        function filtrarServiciosPorCategoria() {
            const catFiltro = document.getElementById('categoria_filtro').value;
            const servicioSelect = document.getElementById('servicio');
            if (!servicioSelect) return;

            const optgroups = servicioSelect.querySelectorAll('optgroup');
            optgroups.forEach(group => {
                const groupCat = group.getAttribute('data-categoria-group') || '';
                if (catFiltro === 'todas' || groupCat === catFiltro) {
                    group.style.display = '';
                } else {
                    group.style.display = 'none';
                }
            });

            const currentSelected = servicioSelect.options[servicioSelect.selectedIndex];
            if (currentSelected && currentSelected.value) {
                const currentCat = currentSelected.getAttribute('data-categoria') || '';
                if (catFiltro !== 'todas' && currentCat !== catFiltro) {
                    servicioSelect.value = '';
                }
            }

            actualizarPrecioLanding();
            filtrarProfesionalesLanding();
            cargarHorariosLanding();
        }

        function sincronizarCategoriaDesdeServicio() {
            const servicioSelect = document.getElementById('servicio');
            const catFiltro = document.getElementById('categoria_filtro');
            if (!servicioSelect || !catFiltro) return;

            const selectedOpt = servicioSelect.options[servicioSelect.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                const cat = selectedOpt.getAttribute('data-categoria');
                if (cat) {
                    for (let i = 0; i < catFiltro.options.length; i++) {
                        if (catFiltro.options[i].value === cat) {
                            catFiltro.selectedIndex = i;
                            break;
                        }
                    }
                }
            }
        }

        // Modal de Agendamiento (RF-05, R-30, R-31, R-32)
        function openScheduleModal(fromDoctor = false) {
            if (!fromDoctor && !lockedDoctorLanding) {
                unlockDoctorSchedule();
            }
            document.getElementById('modalSchedule').classList.add('active');
            actualizarPrecioLanding();
            filtrarProfesionalesLanding();
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
            unlockDoctorSchedule();
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
            // Resolver nombre canónico del doctor
            const docObj = landingProfesionalesList.find(p => p.nombre === doctorName || (p.nombre && p.nombre.includes(doctorName)));
            const resolvedName = docObj ? docObj.nombre : doctorName;

            lockedDoctorLanding = resolvedName;

            const docSelect = document.getElementById('profesional');
            if (docSelect) {
                let found = false;
                for (let i = 0; i < docSelect.options.length; i++) {
                    if (docSelect.options[i].value === resolvedName || docSelect.options[i].text.includes(resolvedName)) {
                        docSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    const opt = document.createElement('option');
                    opt.value = resolvedName;
                    opt.textContent = `${resolvedName} (${docObj?.especialidad ?? 'Especialista'})`;
                    opt.selected = true;
                    docSelect.appendChild(opt);
                }
                docSelect.value = resolvedName;
                // Bloquear visual y funcionalmente el selector para que no se pueda cambiar
                docSelect.style.pointerEvents = 'none';
                docSelect.style.backgroundColor = '#f1f5f9';
                docSelect.style.borderColor = '#93c5fd';
                docSelect.style.color = '#1e3a8a';
                docSelect.style.fontWeight = '600';
                docSelect.style.cursor = 'not-allowed';
                docSelect.setAttribute('tabindex', '-1');
            }

            // Mostrar el banner visual de fijación con botón de desbloqueo explícito
            const lockIndicator = document.getElementById('doctor_lock_indicator');
            const lockedNameEl = document.getElementById('locked_doctor_name');
            if (lockIndicator && lockedNameEl) {
                lockedNameEl.textContent = resolvedName;
                lockIndicator.style.display = 'flex';
            }

            const hint = document.getElementById('profesional_hint_landing');
            if (hint) {
                hint.innerHTML = `<span style="color: #2563eb; font-weight: 600;"><i class="fa-solid fa-lock"></i> Especialista fijado: ${resolvedName}.</span>`;
            }

            // Filtrar servicios para mostrar los que este doctor atiende
            filtrarServiciosPorDoctor(resolvedName);

            const motivoInput = document.getElementById('motivo');
            if (motivoInput) {
                motivoInput.value = 'Solicito consulta con: ' + resolvedName + '. ';
            }

            openScheduleModal(true);
        }

        function unlockDoctorSchedule() {
            lockedDoctorLanding = null;
            const docSelect = document.getElementById('profesional');
            if (docSelect) {
                docSelect.style.pointerEvents = '';
                docSelect.style.backgroundColor = '';
                docSelect.style.borderColor = '';
                docSelect.style.color = '';
                docSelect.style.fontWeight = '';
                docSelect.style.cursor = '';
                docSelect.removeAttribute('tabindex');
            }

            const lockIndicator = document.getElementById('doctor_lock_indicator');
            if (lockIndicator) {
                lockIndicator.style.display = 'none';
            }

            restaurarServiciosLanding();
            filtrarProfesionalesLanding();
            cargarHorariosLanding();
        }

        function filtrarServiciosPorDoctor(doctorName) {
            const servicioSelect = document.getElementById('servicio');
            if (!servicioSelect) return;

            const docObj = landingProfesionalesList.find(p => p.nombre === doctorName || (p.nombre && p.nombre.includes(doctorName)));
            const serviciosPermitidos = docObj?.servicios || [];

            let primerServicioValido = null;
            let currentValido = false;

            const options = servicioSelect.querySelectorAll('option');
            options.forEach(opt => {
                if (!opt.value) return;
                const nombreServicio = opt.value;
                const enMapa = landingMapaServiciosProfesionales[nombreServicio] && landingMapaServiciosProfesionales[nombreServicio].includes(doctorName);
                const enLista = serviciosPermitidos.some(s => s.toLowerCase() === nombreServicio.toLowerCase() || nombreServicio.toLowerCase().includes(s.toLowerCase()));

                if (enMapa || enLista || serviciosPermitidos.length === 0) {
                    opt.style.display = '';
                    opt.disabled = false;
                    if (!primerServicioValido) primerServicioValido = opt.value;
                    if (servicioSelect.value === opt.value) currentValido = true;
                } else {
                    opt.style.display = 'none';
                    opt.disabled = true;
                }
            });

            servicioSelect.querySelectorAll('optgroup').forEach(grp => {
                const visibleOpts = Array.from(grp.querySelectorAll('option')).filter(o => o.style.display !== 'none');
                grp.style.display = visibleOpts.length > 0 ? '' : 'none';
            });

            if (!currentValido && primerServicioValido) {
                servicioSelect.value = primerServicioValido;
                sincronizarCategoriaDesdeServicio();
                actualizarPrecioLanding();
            }
        }

        function restaurarServiciosLanding() {
            const servicioSelect = document.getElementById('servicio');
            if (!servicioSelect) return;

            servicioSelect.querySelectorAll('option').forEach(opt => {
                opt.style.display = '';
                opt.disabled = false;
            });
            servicioSelect.querySelectorAll('optgroup').forEach(grp => {
                grp.style.display = '';
            });
            filtrarServiciosPorCategoria();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const profSelect = document.getElementById('profesional');
            if (profSelect) {
                profSelect.addEventListener('change', function(e) {
                    if (lockedDoctorLanding && profSelect.value !== lockedDoctorLanding) {
                        profSelect.value = lockedDoctorLanding;
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            }
        });

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

        // =====================================================================
        // CATÁLOGO DE PRODUCTOS: TABLA, FILTROS Y CARRITO DE CONSULTA
        // =====================================================================
        let currentProductCatLanding = 'todas';
        let carritoLanding = JSON.parse(localStorage.getItem('vetecnm_cart') || '[]');
        let productoSeleccionadoModal = null;

        function guardarCarritoLanding() {
            localStorage.setItem('vetecnm_cart', JSON.stringify(carritoLanding));
            actualizarBadgesCarritoLanding();
        }

        function actualizarBadgesCarritoLanding() {
            const totalItems = carritoLanding.reduce((acc, item) => acc + (item.cantidad || 1), 0);
            const totalMxn = carritoLanding.reduce((acc, item) => acc + ((item.precio || 0) * (item.cantidad || 1)), 0);

            const badgeCount = document.getElementById('cartCountBadge');
            if (badgeCount) badgeCount.textContent = totalItems;

            const summaryTotal = document.getElementById('cartTotalSummary');
            if (summaryTotal) summaryTotal.textContent = '$' + totalMxn.toFixed(2) + ' MXN';

            const fab = document.getElementById('floatingCartFab');
            const fabCount = document.getElementById('floatingCartCount');
            if (fabCount) fabCount.textContent = totalItems;
            if (fab) fab.style.display = totalItems > 0 ? 'flex' : 'none';
        }

        function agregarAlCarritoLanding(prod) {
            const existe = carritoLanding.find(item => item.id_producto == prod.id_producto);
            if (existe) {
                existe.cantidad = (existe.cantidad || 1) + 1;
            } else {
                carritoLanding.push({
                    id_producto: prod.id_producto,
                    nombre: prod.nombre,
                    categoria_nombre: prod.categoria_nombre || 'General',
                    precio: parseFloat(prod.precio) || 0,
                    stock: prod.stock,
                    cantidad: 1
                });
            }
            guardarCarritoLanding();
            mostrarToastCatalog(`"${prod.nombre}" agregado al carrito de consulta.`);
        }

        function mostrarToastCatalog(msg) {
            const toast = document.getElementById('toastCatalogFeedback');
            const msgEl = document.getElementById('toastCatalogMessage');
            if (toast && msgEl) {
                msgEl.textContent = msg;
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2600);
            }
        }

        function openCartModalLanding() {
            renderizarContenidoCarritoLanding();
            const modal = document.getElementById('modalCartLanding');
            if (modal) {
                modal.classList.add('active');
                modal.style.display = 'flex';
            }
        }

        function closeCartModalLanding() {
            const modal = document.getElementById('modalCartLanding');
            if (modal) {
                modal.classList.remove('active');
                modal.style.display = 'none';
            }
        }

        function renderizarContenidoCarritoLanding() {
            const container = document.getElementById('cartItemsContainerLanding');
            const footer = document.getElementById('cartSummaryFooterLanding');
            const totalEl = document.getElementById('cartModalTotalAmount');
            const btnWa = document.getElementById('btnCartSendWhatsApp');
            if (!container) return;

            if (carritoLanding.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 2.8rem 1rem; color: #94a3b8;">
                        <i class="fa-solid fa-cart-arrow-down" style="font-size: 2.8rem; color: #cbd5e1; margin-bottom: 0.8rem; display: block;"></i>
                        <h4 style="color: #64748b; font-weight: 700; margin: 0 0 6px 0;">Tu carrito de consulta está vacío</h4>
                        <p style="font-size: 0.88rem; margin: 0;">Selecciona productos en la tabla para cotizarlos o integrarlos a tu cita médica.</p>
                    </div>
                `;
                if (footer) footer.style.display = 'none';
                return;
            }

            if (footer) footer.style.display = 'block';

            let total = 0;
            let html = '<div style="display: flex; flex-direction: column; gap: 10px;">';

            carritoLanding.forEach((item, idx) => {
                const subtotal = item.precio * item.cantidad;
                total += subtotal;

                html += `
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; gap: 10px;">
                        <div style="flex: 1; min-width: 140px;">
                            <strong style="color: #0f172a; font-size: 0.92rem; display: block;">${item.nombre}</strong>
                            <span style="font-size: 0.75rem; color: #64748b;">${item.categoria_nombre} • $${item.precio.toFixed(2)} c/u</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <button type="button" onclick="cambiarCantidadCarrito(${idx}, -1)" style="width: 26px; height: 26px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; cursor: pointer; font-weight: bold; line-height: 1;">-</button>
                            <span style="font-weight: 700; font-size: 0.88rem; min-width: 20px; text-align: center;">${item.cantidad}</span>
                            <button type="button" onclick="cambiarCantidadCarrito(${idx}, 1)" style="width: 26px; height: 26px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; cursor: pointer; font-weight: bold; line-height: 1;">+</button>
                        </div>
                        <div style="text-align: right; min-width: 80px;">
                            <strong style="color: #059669; font-size: 0.92rem;">$${subtotal.toFixed(2)}</strong>
                        </div>
                        <div>
                            <button type="button" onclick="eliminarDelCarrito(${idx})" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px;" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                `;
            });
            html += '</div>';

            container.innerHTML = html;
            if (totalEl) totalEl.textContent = '$' + total.toFixed(2) + ' MXN';

            if (btnWa) {
                const rawPhone = @json(preg_replace('/\D/', '', $clinicaInfo['whatsapp']));
                let msg = 'Hola VETecNM! Me interesa consultar la disponibilidad y cotización de estos productos de su catálogo:\n\n';
                carritoLanding.forEach(it => {
                    msg += `• ${it.cantidad}x ${it.nombre} ($${(it.precio * it.cantidad).toFixed(2)} MXN)\n`;
                });
                msg += `\nTotal Estimado: $${total.toFixed(2)} MXN\n¿Puedo apartarlos o recogerlos en mostrador?`;
                btnWa.href = `https://wa.me/${rawPhone}?text=${encodeURIComponent(msg)}`;
            }
        }

        function cambiarCantidadCarrito(idx, delta) {
            if (!carritoLanding[idx]) return;
            carritoLanding[idx].cantidad = (carritoLanding[idx].cantidad || 1) + delta;
            if (carritoLanding[idx].cantidad <= 0) {
                carritoLanding.splice(idx, 1);
            }
            guardarCarritoLanding();
            renderizarContenidoCarritoLanding();
        }

        function eliminarDelCarrito(idx) {
            carritoLanding.splice(idx, 1);
            guardarCarritoLanding();
            renderizarContenidoCarritoLanding();
        }

        function vaciarCarritoLanding() {
            if (confirm('¿Deseas vaciar todos los productos del carrito de consulta?')) {
                carritoLanding = [];
                guardarCarritoLanding();
                renderizarContenidoCarritoLanding();
            }
        }

        function incluirCarritoEnCitaMedica() {
            if (carritoLanding.length === 0) return;

            let resumenProds = 'Deseo adquirir/consultar en mi cita: ';
            resumenProds += carritoLanding.map(it => `${it.cantidad}x ${it.nombre}`).join(', ');

            closeCartModalLanding();

            const motivoField = document.getElementById('motivo');
            if (motivoField) {
                if (motivoField.value && !motivoField.value.includes('Deseo adquirir')) {
                    motivoField.value += ' | ' + resumenProds;
                } else if (!motivoField.value) {
                    motivoField.value = resumenProds;
                }
            }

            const seccionCita = document.getElementById('agendar-cita') || document.getElementById('calendario');
            if (seccionCita) {
                seccionCita.scrollIntoView({ behavior: 'smooth' });
            }

            mostrarToastCatalog('Productos integrados en tu solicitud de cita médica.');
        }

        function cambiarFiltroCategoriaSelect(catId) {
            currentProductCatLanding = String(catId);
            filtrarTablaProductosLanding();
        }

        function clearCatalogSearchLanding() {
            const input = document.getElementById('inputBusquedaProductosLanding');
            if (input) {
                input.value = '';
                input.focus();
            }
            const clearBtn = document.getElementById('btn_clear_catalog_search');
            if (clearBtn) clearBtn.style.display = 'none';
            filtrarTablaProductosLanding();
        }

        function resetProductSearchLanding() {
            const input = document.getElementById('inputBusquedaProductosLanding');
            if (input) input.value = '';
            const clearBtn = document.getElementById('btn_clear_catalog_search');
            if (clearBtn) clearBtn.style.display = 'none';

            const sel = document.getElementById('selectCategoriaProductosLanding');
            if (sel) sel.value = 'todas';
            currentProductCatLanding = 'todas';

            filtrarTablaProductosLanding();
        }

        function filtrarTablaProductosLanding() {
            const input = document.getElementById('inputBusquedaProductosLanding');
            const query = (input?.value || '').toLowerCase().trim();
            const clearBtn = document.getElementById('btn_clear_catalog_search');
            if (clearBtn) {
                clearBtn.style.display = query.length > 0 ? 'flex' : 'none';
            }

            const sel = document.getElementById('selectCategoriaProductosLanding');
            if (sel && sel.value !== currentProductCatLanding) {
                currentProductCatLanding = sel.value;
            }

            const rows = document.querySelectorAll('#tablaProductosLanding tbody .row-product-item');
            const counter = document.getElementById('landing_prods_count');
            const noResultsRow = document.getElementById('landing_prods_no_results_row');

            let visibleCount = 0;

            rows.forEach(row => {
                const cat = String(row.getAttribute('data-categoria') || '');
                const name = (row.getAttribute('data-nombre') || '').toLowerCase();
                const desc = (row.getAttribute('data-desc') || '').toLowerCase();

                const matchCat = (currentProductCatLanding === 'todas' || cat === currentProductCatLanding);
                const matchQuery = (!query || name.includes(query) || desc.includes(query));

                if (matchCat && matchQuery) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (counter) {
                counter.textContent = `${visibleCount} producto(s)`;
            }

            if (noResultsRow) {
                noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        }

        function openProductDetailLanding(prod) {
            productoSeleccionadoModal = prod;
            const modal = document.getElementById('modalProductDetailLanding');
            if (!modal) return;

            document.getElementById('modalProdTitle').innerText = prod.nombre;
            const catEl = document.getElementById('modalProdCategory');
            if (catEl) catEl.innerText = prod.categoria_nombre || 'General';
            document.getElementById('modalProdPrice').innerText = '$' + parseFloat(prod.precio).toFixed(2) + ' MXN';
            document.getElementById('modalProdDescription').innerText = prod.descripcion || 'Producto certificado de grado veterinario para el cuidado de mascotas en clínica VETecNM.';

            const stockEl = document.getElementById('modalProdStock');
            if (stockEl) {
                if (prod.stock > 5) {
                    stockEl.innerHTML = `<span class="stock-pill in-stock"><i class="fa-solid fa-circle-check"></i> Disponible (${prod.stock} u.)</span>`;
                } else if (prod.stock > 0) {
                    stockEl.innerHTML = `<span class="stock-pill low-stock"><i class="fa-solid fa-triangle-exclamation"></i> Últimas ${prod.stock} pzas</span>`;
                } else {
                    stockEl.innerHTML = `<span class="stock-pill out-stock"><i class="fa-solid fa-circle-xmark"></i> Agotado</span>`;
                }
            }

            const waBtn = document.getElementById('btnWhatsappProductModal');
            if (waBtn) {
                const rawPhone = @json(preg_replace('/\D/', '', $clinicaInfo['whatsapp']));
                const text = encodeURIComponent(`Hola VETecNM, me gustaría consultar la disponibilidad del producto: ${prod.nombre} (Código #${prod.id_producto})`);
                waBtn.href = `https://wa.me/${rawPhone}?text=${text}`;
            }

            modal.classList.add('active');
            modal.style.display = 'flex';
        }

        function agregarProductoActualDesdeModal() {
            if (productoSeleccionadoModal) {
                agregarAlCarritoLanding(productoSeleccionadoModal);
                closeProductDetailLanding();
            }
        }

        function closeProductDetailLanding() {
            const modal = document.getElementById('modalProductDetailLanding');
            if (modal) {
                modal.classList.remove('active');
                modal.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            actualizarBadgesCarritoLanding();
        });

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

    <!-- =====================================================================
         MODAL: CARRITO DE CONSULTA & COMPRA DE PRODUCTOS
         ===================================================================== -->
    <div id="modalCartLanding" class="modal-overlay" style="display: none;">
        <div class="modal-box-lg" style="max-width: 640px; margin: auto;">
            <div class="modal-box-header">
                <div>
                    <h3 style="color: #0f172a; font-size: 1.35rem; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-cart-shopping" style="color: #2563eb;"></i> Carrito de Consulta de Productos
                    </h3>
                    <p style="margin: 4px 0 0; font-size: 0.85rem; color: #64748b;">
                        Revisa los productos seleccionados para consultar existencias o integrarlos a tu cita médica.
                    </p>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeCartModalLanding()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div id="cartItemsContainerLanding" style="max-height: 380px; overflow-y: auto; padding-right: 4px;">
                <!-- Rellenado por JS -->
            </div>

            <div id="cartSummaryFooterLanding" style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1.5px solid #e2e8f0;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1.25rem;">
                    <span style="font-size: 0.95rem; font-weight: 600; color: #475569;">Total Estimado de Productos:</span>
                    <span id="cartModalTotalAmount" style="font-size: 1.4rem; font-weight: 800; color: #059669;">$0.00 MXN</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a id="btnCartSendWhatsApp" href="#" target="_blank"
                       style="background: #10b981; color: white; padding: 0.85rem 1.25rem; border-radius: 10px; font-weight: 700; font-size: 0.95rem; text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center; gap: 9px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                        <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i> Enviar Lista y Consultar por WhatsApp
                    </a>

                    <button type="button" onclick="incluirCarritoEnCitaMedica()"
                            style="background: #2563eb; color: white; border: none; padding: 0.85rem 1.25rem; border-radius: 10px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 9px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                        <i class="fa-solid fa-calendar-plus" style="font-size: 1.05rem;"></i> Incluir Productos en mi Cita Médica
                    </button>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                        <button type="button" onclick="vaciarCarritoLanding()" style="background: none; border: none; color: #ef4444; font-size: 0.82rem; cursor: pointer; font-weight: 600;">
                            <i class="fa-solid fa-trash"></i> Vaciar Carrito
                        </button>
                        <button type="button" onclick="closeCartModalLanding()" style="background: none; border: none; color: #64748b; font-size: 0.82rem; cursor: pointer;">
                            Seguir explorando
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         MODAL: INFORMACIÓN Y FICHA DEL PRODUCTO
         ===================================================================== -->
    <div id="modalProductDetailLanding" class="modal-overlay" style="display: none;">
        <div class="modal-box-lg" style="max-width: 540px; margin: auto;">
            <div class="modal-box-header">
                <div>
                    <span id="modalProdCategory" class="product-cat-tag theme-general" style="margin-bottom: 6px; display: inline-block;">General</span>
                    <h3 id="modalProdTitle" style="color: #0f172a; font-size: 1.35rem; font-weight: 800; margin: 0;">Nombre Producto</h3>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeProductDetailLanding()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; background: #f8fafc; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; display: block;">Precio Oficial</span>
                        <strong id="modalProdPrice" style="font-size: 1.3rem; color: #059669; font-weight: 800;">$0.00 MXN</strong>
                    </div>
                    <div id="modalProdStock">
                        <!-- Stock pill -->
                    </div>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <h5 style="font-size: 0.82rem; text-transform: uppercase; color: #475569; font-weight: 700; margin: 0 0 6px 0;">Descripción e Indicaciones:</h5>
                    <p id="modalProdDescription" style="font-size: 0.92rem; color: #334155; line-height: 1.6; margin: 0; background: #ffffff; padding: 0.75rem 0;"></p>
                </div>

                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.84rem; color: #1e40af; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-shield-halved" style="color: #2563eb; font-size: 1.1rem;"></i>
                    <span>Producto original y certificado para venta en mostrador de la clínica VETecNM.</span>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 1.5rem; flex-wrap: wrap;">
                <button type="button" id="btnAddToCartFromModal" onclick="agregarProductoActualDesdeModal()"
                        style="flex: 1; min-width: 170px; background: #2563eb; color: white; border: none; padding: 0.75rem 1.2rem; border-radius: 9px; font-weight: 700; font-size: 0.92rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                    <i class="fa-solid fa-cart-plus"></i> Agregar al Carrito
                </button>
                <a id="btnWhatsappProductModal" href="#" target="_blank"
                   style="flex: 1; min-width: 170px; background: #10b981; color: white; padding: 0.75rem 1.2rem; border-radius: 9px; font-weight: 700; font-size: 0.92rem; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                    <i class="fa-brands fa-whatsapp"></i> Consultar WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Botón Flotante de Carrito de Consulta -->
    <button type="button" id="floatingCartFab" class="floating-cart-fab" onclick="openCartModalLanding()" title="Ver Carrito de Consulta">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Consulta (<span id="floatingCartCount">0</span>)</span>
    </button>

    <!-- Toast de Notificación -->
    <div id="toastCatalogFeedback" class="toast-catalog-feedback">
        <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 1.1rem;"></i>
        <span id="toastCatalogMessage">¡Producto agregado al carrito!</span>
    </div>
</body>

</html>
