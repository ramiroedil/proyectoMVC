<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

// Verificar autenticación y permisos
Session::start();
if (!Session::has('usuario') || !Session::has('token')) {
    header('Location: ../index.php?sw=2');
    exit();
}

// Empleados con permisos de gestionar clientes
$usuario = Session::get('usuario');
$permisos = $usuario['permisos'] ?? [];
if (!in_array('all', $permisos) && !in_array('gestionar_clientes', $permisos)) {
    header('Location: ../inicio.php?sw=5');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $paterno = trim($_POST['paterno']);
    $materno = trim($_POST['materno'] ?? '');
    $ci = trim($_POST['ci']);
    $username = trim($_POST['usuario']);
    $password = $_POST['password'];
    $fecha_nacimiento = $_POST['fechanacimiento'];
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $genero = $_POST['genero'] ?? null;
    
    // Datos específicos de cliente
    $nit_ci = trim($_POST['nit_ci']);
    $razon_social = trim($_POST['razon_social'] ?? '');
    $tipo_cliente = $_POST['tipo_cliente'] ?? 'PERSONA';
    $estado_cliente = $_POST['estado_cliente'] ?? 'ACTIVO';
    
    $api = new ApiClient();
    $response = $api->post('/usuario', [
        'usuario' => $username,
        'password' => $password,
        'email' => $email,
        'nombre' => $nombre,
        'apellido_paterno' => $paterno,
        'apellido_materno' => $materno,
        'ci' => $ci,
        'fecha_nacimiento' => $fecha_nacimiento,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'genero' => $genero,
        'tipo_usuario' => 'cliente',
        // Datos específicos de cliente
        'nit_ci' => $nit_ci,
        'razon_social' => $razon_social,
        'tipo_cliente' => $tipo_cliente,
        'estado_cliente' => $estado_cliente
    ]);
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cliente registrado correctamente");
            location.href = '../controlador/clienteLista.php';
        </script>
        <?php
        exit();
    } else {
        $error_message = $response['message'] ?? 'Error desconocido';
        ?>
        <script type="text/javascript">
            alert("Error al registrar: <?= addslashes($error_message) ?>");
        </script>
        <?php
    }
}

include("../vista/clienteRegistro.php");
?>