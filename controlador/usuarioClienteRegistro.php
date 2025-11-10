<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../modelo/ApiClient.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar inputs
    $nombre = trim($_POST['nombre'] ?? '');
    $paterno = trim($_POST['paterno'] ?? '');
    $materno = trim($_POST['materno'] ?? '');
    $ci = trim($_POST['ci'] ?? '');
    $username = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $fecha_nacimiento = $_POST['fechanacimiento'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $tipo_usuario = 'cliente'; // Siempre es cliente

    // Validaciones básicas del servidor (importante!)
    $errores = [];

    if (empty($nombre)) $errores[] = 'El nombre es requerido';
    if (empty($paterno)) $errores[] = 'El apellido paterno es requerido';
    if (empty($ci)) $errores[] = 'La CI es requerida';
    if (empty($username)) $errores[] = 'El usuario es requerido';
    if (empty($password)) $errores[] = 'La contraseña es requerida';
    if (empty($email)) $errores[] = 'El email es requerido';
    if (empty($fecha_nacimiento)) $errores[] = 'La fecha de nacimiento es requerida';

    // Validar formato de email
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El formato del email no es válido';
    }

    // Validar longitud de usuario
    if (strlen($username) < 3 || strlen($username) > 20) {
        $errores[] = 'El usuario debe tener entre 3 y 20 caracteres';
    }

    // Validar coincidencia de contraseñas
    if ($password !== $password_confirm) {
        $errores[] = 'Las contraseñas no coinciden';
    }

    // Validar fortaleza de contraseña
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $password)) {
        $errores[] = 'La contraseña debe tener: mín. 8 caracteres, una mayúscula, un número y un carácter especial';
    }

    // Validar edad (debe ser mayor de 13 años)
    $fecha = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha)->y;
    if ($edad < 13) {
        $errores[] = 'Debes tener al menos 13 años para registrarte';
    }

    // Si hay errores, mostrarlos
    if (!empty($errores)) {
        ?>
        <script type="text/javascript">
            alert("Por favor corrige los siguientes errores:\n\n<?php echo implode('\n', $errores); ?>");
            history.back();
        </script>
        <?php
        exit();
    }

    try {
        $api = new ApiClient();
        
        // Llamar con autoRedirect = false para registro (no debe redirigir si falla 401)
        $response = $api->post('/usuario/register', [
            'username' => $username,
            'password' => $password,
            'nombre' => $nombre,
            'paterno' => $paterno,
            'materno' => $materno,
            'ci' => $ci,
            'fecha_nacimiento' => $fecha_nacimiento,
            'email' => $email,
            'tipo_usuario' => $tipo_usuario
        ], [], false);  // false = no redirigir automáticamente

        if ($response['success']) {
            // Registro exitoso
            
            // Verificar si hay sesión activa (si está logueado como admin/empleado registrando clientes)
            if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
                // Usuario logueado registrando clientes - ir a lista de usuarios
                ?>
                <script type="text/javascript">
                    alert("Cliente registrado correctamente");
                    location.href = '../controlador/usuarioLista.php';
                </script>
                <?php
            } else {
                // Cliente nuevo auto-registrándose - ir al login
                ?>
                <script type="text/javascript">
                    alert("¡Bienvenido! Cuenta creada correctamente.\nPor favor inicia sesión para comenzar a comprar.");
                    location.href = '../../index.php?sw=0';
                </script>
                <?php
            }
            exit();
        } else {
            // Error en la respuesta de la API
            $errorMsg = $response['error'] ?? 'Error desconocido al registrar';
            
            // Mensajes personalizados según el error
            if (strpos($errorMsg, 'usuario') !== false || strpos($errorMsg, 'username') !== false) {
                $errorMsg = 'El usuario ya existe. Por favor elige otro.';
            } elseif (strpos($errorMsg, 'email') !== false) {
                $errorMsg = 'El email ya está registrado. ¿Olvidaste tu contraseña?';
            } elseif (strpos($errorMsg, 'ci') !== false) {
                $errorMsg = 'La CI ya está registrada en el sistema.';
            }
            
            ?>
            <script type="text/javascript">
                alert("Error al registrar:\n\n<?php echo addslashes($errorMsg); ?>");
                history.back();
            </script>
            <?php
            exit();
        }
    } catch (Exception $e) {
        // Error de conexión o excepción
        ?>
        <script type="text/javascript">
            alert("Error de conexión:\n\n<?php echo addslashes($e->getMessage()); ?>\n\nPor favor intenta más tarde.");
            history.back();
        </script>
        <?php
        exit();
    }
} else {
    // GET - mostrar formulario
    include("../vista/usuarioCliRegistro.php");
}
?>