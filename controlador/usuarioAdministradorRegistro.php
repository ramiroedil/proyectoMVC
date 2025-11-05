<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $paterno = trim($_POST['paterno']);
    $materno = trim($_POST['materno']);
    $ci = trim($_POST['ci']);
    $username = trim($_POST['usuario']);
    $password = $_POST['pasword'];
    $fecha_nacimiento = $_POST['fechanacimiento'];
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $genero = $_POST['genero'] ?? null;
    $cargo_id = $_POST['cargo'];
    $estado_laboral = $_POST['estadoLaboral'];
    
    $api = new ApiClient();
    // Usar el endpoint: POST /usuario/register
    $response = $api->post('/usuario/register', [
        'usuario' => $username,
        'password' => $password,
        'nombre' => $nombre,
        'apellido_paterno' => $paterno,
        'apellido_materno' => $materno,
        'ci' => $ci,
        'fecha_nacimiento' => $fecha_nacimiento,
        'email' => $email,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'genero' => $genero,
        'id_cargo' => $cargo_id,
        'estadoLaboral' => $estado_laboral
    ]);
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Administrador registrado correctamente");
            location.href = '../controlador/usuarioLista.php';
        </script>
        <?php
        exit();
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al registrar: <?php echo addslashes($response['error']); ?>");
            history.back();
        </script>
        <?php
    }
}

include("../vista/usuarioAdmRegistro.php");
?>