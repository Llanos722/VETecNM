<?php
// index.php
// Sistema de login - Veterinaria (VETecNM)

$message = '';

if (isset($_GET['success']) || isset($_GET['error'])) {
    $is_success = isset($_GET['success']);
    $type = $is_success ? 'success-message' : 'error-message';
    $message_text = '';
    $action_button = '<button class="alert-button" onclick="document.getElementById(\'global-alert\').style.display=\'none\'">Cerrar</button>';

    if ($is_success) {
        $message_text = match($_GET['success']) {
            'logout_ok' => '👋 Sesión cerrada correctamente.',
            'password_reset_ok' => '✅ Contraseña restablecida con éxito.',
            default => '✅ Operación exitosa.',
        };
    } else {
        $error_msg_code = $_GET['error'];
        $message_text = match($error_msg_code) {
            'login_fail' => '❌ Error de credenciales. Revisa tu usuario y contraseña.',
            'acceso_denegado' => '❌ Acceso denegado. Debes iniciar sesión.',
            default => '❌ Ha ocurrido un error.',
        };
    }
    
    $message = '<div id="global-alert" class="alert ' . $type . '">';
    $message .= '<span>' . $message_text . '</span>';
    $message .= $action_button;
    $message .= '</div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VETecNM</title>
    <!-- Fuente Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <!-- Iconos FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Huellas de fondo (Watermarks) -->
    <div class="bg-paw paw-top-right"><i class="fa-solid fa-paw"></i></div>
    <div class="bg-paw paw-bottom-left"><i class="fa-solid fa-paw"></i></div>

    <?php echo $message; ?>

    <div class="login-container">
        <div class="form-header">
            <!-- Icono principal representativo de veterinaria -->
            <div class="logo">
                <i class="fa-solid fa-dog" style="font-size: 3.5rem; color: var(--primary-color);"></i>
                <i class="fa-solid fa-cat" style="font-size: 2rem; color: var(--primary-color); margin-left: -15px;"></i>
                <i class="fa-solid fa-plus" style="font-size: 1.5rem; color: var(--primary-color); position: relative; top: -20px;"></i>
            </div>
            <h2>VETecNM</h2>
            <p>Cuidamos a quienes te acompañan</p>
        </div>
        
        <form action="login.php" method="POST">
            <!-- Campo de Usuario -->
            <div class="input-wrapper">
                <i class="fa-regular fa-user icon-left"></i>
                <input type="text" id="login-user" name="login-user" placeholder="Usuario" required>
            </div>
            
            <!-- Campo de Contraseña -->
            <div class="input-wrapper">
                <i class="fa-solid fa-lock icon-left"></i>
                <input type="password" id="login-password" name="login-password" placeholder="Contraseña" required>
                <!-- Ojo para mostrar/ocultar contraseña -->
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
        // Funcionalidad para mostrar/ocultar la contraseña
        const togglePassword = document.querySelector('#toggle-password');
        const passwordInput = document.querySelector('#login-password');

        togglePassword.addEventListener('click', function () {
            // Alternar el tipo de input entre 'password' y 'text'
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Alternar el icono del ojito (tachado / normal)
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>