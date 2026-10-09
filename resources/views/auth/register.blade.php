<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VETecNM - Crear Cuenta</title>
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

    @if (session('error') || (isset($errors) && $errors->any()))
        <div id="global-alert" class="alert error-message">
            <span>
                ❌ {{ session('error') ?? $errors->first() }}
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
            <p>Crea tu cuenta para comenzar</p>
        </div>
        
        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <!-- Campo de Nombre -->
            <div class="input-wrapper">
                <i class="fa-regular fa-user icon-left"></i>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre completo" required autofocus>
            </div>

            <!-- Campo de Correo Electrónico -->
            <div class="input-wrapper">
                <i class="fa-regular fa-envelope icon-left"></i>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required>
            </div>
            
            <!-- Campo de Contraseña -->
            <div class="input-wrapper">
                <i class="fa-solid fa-lock icon-left"></i>
                <input type="password" id="password" name="password" placeholder="Contraseña (mínimo 6 caracteres)" required>
                <i class="fa-regular fa-eye icon-right" id="toggle-password"></i>
            </div>

            <!-- Campo de Confirmar Contraseña -->
            <div class="input-wrapper">
                <i class="fa-solid fa-shield-halved icon-left"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar contraseña" required>
                <i class="fa-regular fa-eye icon-right" id="toggle-password-confirm"></i>
            </div>
            
            <!-- Botón de registro -->
            <button type="submit" class="btn-primary">Registrarse</button>
            
            <!-- Enlace para volver a Iniciar Sesión -->
            <div class="form-links">
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">¿Ya tienes una cuenta?</p>
                <a href="{{ route('login') }}" class="btn-secondary">Iniciar sesión</a>
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#toggle-password');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        const togglePasswordConfirm = document.querySelector('#toggle-password-confirm');
        const passwordConfirmInput = document.querySelector('#password_confirmation');

        togglePasswordConfirm.addEventListener('click', function () {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
