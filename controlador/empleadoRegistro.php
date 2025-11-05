<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

// Verificar autenticación y permisos
Session::start();
if (!Session::has('usuario') || !Session::has('token')) {
    header('Location: ../index.php?sw=2');
    exit();
}

// Solo administradores y gerentes pueden crear empleados
$usuario = Session::get('usuario');
$permisos = $usuario['permisos'] ?? [];
if (!in_array('all', $permisos) && !in_array('gestionar_empleados', $permisos)) {
    header('Location: ../inicio.php?sw=5');
    exit();
}

$api = new ApiClient();

// Obtener lista de cargos activos para el select
$responseCargos = $api->get('/cargo/active');
$cargos = $responseCargos['success'] ? $responseCargos['data'] : [];

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
    
    // Datos específicos de empleado
    $cargoId = intval($_POST['cargoId']);
    $salario = floatval($_POST['salario'] ?? 0);
    $estadoLaboral = $_POST['estadoLaboral'] ?? 'ACTIVO';
    
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
        'tipo_usuario' => 'empleado',
        // Datos específicos de empleado
        'cargoId' => $cargoId,
        'salario' => $salario,
        'estadoLaboral' => $estadoLaboral
    ]);
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Empleado registrado correctamente");
            location.href = '../controlador/empleadoLista.php';
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

include("../vista/empleadoRegistro.php");
?>