<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VETecNM - Iniciar Sesión</title>
    <!-- Fuente Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <!-- Iconos FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <!-- Huellas de fondo (Watermarks) -->
    <div class="bg-paw paw-top-right"><i class="fa-solid fa-paw"></i></div>
    <div class="bg-paw paw-bottom-left"><i class="fa-solid fa-paw"></i></div>

    @if (session('success'))
        <div id="global-alert" class="alert success-message">
            <span>
                @if (session('success') === 'logout_ok')
                    👋 Sesión cerrada correctamente.
                @elseif (session('success') === 'password_reset_ok')
                    ✅ Contraseña restablecida con éxito.
                @else
                    {{ session('success') }}
                @endif
            </span>
            <button class="alert-button" onclick="document.getElementById('global-alert').style.display='none'">Cerrar</button>
        </div>
    @endif

    @if (session('error') || (isset($errors) && $errors->any()))
        <div id="global-alert" class="alert error-message">
            <span>
                @if (session('error') === 'login_fail' || (isset($errors) && $errors->has('login-user')))
                    ❌ Error de credenciales. Revisa tu usuario y contraseña.
                @elseif (session('error') === 'acceso_denegado')
                    ❌ Acceso denegado. Debes iniciar sesión.
                @else
                    {{ session('error') ?? $errors->first() }}
                @endif
            </span>
            <button class="alert-button" onclick="document.getElementById('global-alert').style.display='none'">Cerrar</button>
        </div>
    @endif

    <div class="login-container">
        <div class="form-header">
            <div class="logo">
                <i class="fa-solid fa-dog" style="font-size: 3.5rem; color: var(--primary-color);"></i>
                <i class="fa-solid fa-cat" style="font-size: 2rem; color: var(--primary-color); margin-left: -15px;"></i>
                <i class="fa-solid fa-plus" style="font-size: 1.5rem; color: var(--primary-color); position: relative; top: -20px;"></i>
            </div>
            <h2>VETecNM</h2>
            <p>Cuidamos a quienes te acompañan</p>
        </div>
        
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <!-- Campo de Usuario / Email -->
            <div class="input-wrapper">
                <i class="fa-regular fa-user icon-left"></i>
                <input type="text" id="login-user" name="login-user" value="{{ old('login-user') }}" placeholder="Usuario o Correo" required autofocus>
            </div>
            
            <!-- Campo de Contraseña -->
            <div class="input-wrapper">
                <i class="fa-solid fa-lock icon-left"></i>
                <input type="password" id="login-password" name="login-password" placeholder="Contraseña" required>
                <i class="fa-regular fa-eye icon-right" id="toggle-password"></i>
            </div>
            
            <!-- Botón -->
            <button type="submit" class="btn-primary">Iniciar sesión</button>
            
            <!-- Enlace de recuperación -->
            <div class="form-links">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#toggle-password');
        const passwordInput = document.querySelector('#login-password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
