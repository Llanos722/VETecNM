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
        }
        .navbar {
            background-color: var(--primary-color);
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
            color: var(--primary-color);
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
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fa-solid fa-dog"></i>
            <span>VETecNM</span>
        </div>
        <div class="user-menu">
            <span><i class="fa-regular fa-user"></i> {{ session('user_nombre', 'Usuario') }} ({{ session('user_rol', 'cliente') }})</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h2>Bienvenido al Sistema VETecNM, {{ session('user_nombre') }} 👋</h2>
            <p style="color: var(--text-muted);">Gestión veterinaria integral (Base de datos MySQL conectada en Laragon).</p>

            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-paw"></i></div>
                    <div class="stat-info">
                        <h3>{{ $totalMascotas }}</h3>
                        <p>Mascotas Registradas</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="stat-info">
                        <h3>{{ $totalCitas }}</h3>
                        <p>Citas Agendadas</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-box-open"></i></div>
                    <div class="stat-info">
                        <h3>{{ $totalProductos }}</h3>
                        <p>Productos en Catálogo</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                    <div class="stat-info">
                        <h3>{{ $totalUsuarios }}</h3>
                        <p>Usuarios Registrados</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="welcome-card">
            <h3><i class="fa-solid fa-calendar-days"></i> Próximas Citas Veterinarias</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Mascota</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($citas as $c)
                        <tr>
                            <td>#{{ $c->id_cita }}</td>
                            <td><strong>{{ $c->mascota_nombre }}</strong> ({{ $c->especie }})</td>
                            <td>{{ $c->fecha }}</td>
                            <td>{{ $c->hora }}</td>
                            <td>{{ $c->motivo }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($c->estado) }}">{{ $c->estado }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay citas agendadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
