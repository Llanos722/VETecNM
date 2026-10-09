<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VETecNM - Panel de Administración')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        :root {
            --sidebar-width: 250px;
            --admin-primary: #1e293b;
            --admin-accent: #2563eb;
            --admin-hover: #334155;
            --bg-light: #f8fafc;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--bg-light);
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--admin-primary);
            color: #f1f5f9;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.35rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
        }

        .sidebar-brand i {
            color: #38bdf8;
            font-size: 1.6rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
            margin: 0;
            flex: 1;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1.5rem;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            color: white;
            background-color: var(--admin-hover);
            border-left: 4px solid var(--admin-accent);
        }

        .sidebar-menu li a i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .topbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .content-body {
            padding: 2rem;
            flex: 1;
        }

        /* UI Components */
        .card-custom {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .card-header-flex h3 {
            font-size: 1.15rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-add { background: #2563eb; color: white; }
        .btn-add:hover { background: #1d4ed8; }

        .btn-edit { background: #f59e0b; color: white; padding: 5px 10px; font-size: 0.8rem; border-radius: 6px; }
        .btn-edit:hover { background: #d97706; }

        .btn-delete { background: #ef4444; color: white; padding: 5px 10px; font-size: 0.8rem; border-radius: 6px; }
        .btn-delete:hover { background: #dc2626; }

        .btn-status { background: #64748b; color: white; padding: 4px 8px; font-size: 0.75rem; border-radius: 6px; }
        .btn-status:hover { background: #475569; }

        /* Tables */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.92rem;
        }

        .admin-table th, .admin-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .admin-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .admin-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* Status Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.78rem;
            font-weight: 600;
            display: inline-block;
        }
        .status-Pendiente { background: #fef9c3; color: #854d0e; }
        .status-Confirmada { background: #dcfce7; color: #166534; }
        .status-Finalizada { background: #e0f2fe; color: #075985; }
        .status-Cancelada { background: #fee2e2; color: #991b1b; }

        /* Flash Messages */
        .alert-toast {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 500;
        }
        .alert-toast-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-toast-error { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Modal Styles */
        .modal-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-backdrop.active {
            display: flex;
        }

        .modal-container {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 550px;
            padding: 1.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.75rem;
        }

        .modal-header h4 {
            font-size: 1.2rem;
            margin: 0;
            color: #0f172a;
        }

        .modal-close {
            background: transparent;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            font-size: 0.88rem;
            color: #334155;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.65rem 0.85rem;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            padding-top: 1rem;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="fa-solid fa-user-shield"></i>
            <span>VETecNM Admin</span>
        </a>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.citas.index') }}" class="{{ request()->routeIs('admin.citas.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i> Citas Médicas
                </a>
            </li>
            <li>
                <a href="{{ route('admin.mascotas.index') }}" class="{{ request()->routeIs('admin.mascotas.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-paw"></i> Mascotas
                </a>
            </li>
            <li>
                <a href="{{ route('admin.usuarios.index') }}" class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Usuarios
                </a>
            </li>
            <li>
                <a href="{{ route('admin.productos.index') }}" class="{{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-packing"></i> Catálogo & Productos
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-house"></i> Vista Cliente
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">@yield('header_title', 'Administración VETecNM')</div>
            <div class="topbar-user">
                <span class="admin-badge"><i class="fa-solid fa-shield"></i> Admin</span>
                <span><i class="fa-regular fa-user"></i> {{ session('user_nombre') }}</span>
            </div>
        </header>

        <main class="content-body">
            @if(session('success'))
                <div class="alert-toast alert-toast-success">
                    <span><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-toast alert-toast-error">
                    <span><i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-toast alert-toast-error" style="flex-direction: column; align-items: flex-start;">
                    <strong><i class="fa-solid fa-circle-exclamation"></i> Por favor revisa los siguientes errores:</strong>
                    <ul style="margin: 5px 0 0 20px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
