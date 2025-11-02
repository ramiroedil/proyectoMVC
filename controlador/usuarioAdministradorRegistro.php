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
    $cargo_id = $_POST['cargo'];  // Cargo seleccionado
    $estado_laboral = $_POST['estadoLaboral'];  // Estado laboral seleccionado
    
    $api = new ApiClient();
    $response = $api->post('/usuario/register', [
        'usuario' => $username,
        'password' => $password,
        'nombre' => $nombre,
        'apellido_paterno' => $paterno,
        'apellido_materno' => $materno,
        'ci' => $ci,
        'fecha_nacimiento' => $fecha_nacimiento,
        'email' => $email,
        'id_cargo' => $cargo_id,  // Cargo ID
        'estadoLaboral' => $estado_laboral  // Estado laboral
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
        </script>
        <?php
    }
}

include("../vista/usuarioAdmRegistro.php");
?>