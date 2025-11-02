<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $paterno = trim($_POST['paterno']);
    $materno = trim($_POST['materno']);
    $ci = trim($_POST['ci']);
    $username = trim($_POST['usuario']);
    $password = $_POST['password'];
    $fecha_nacimiento = $_POST['fechanacimiento'];
    $email = trim($_POST['email']);
    
    $api = new ApiClient();
    $response = $api->post('/usuario/register', [
        'username' => $username,
        'password' => $password,
        'nombre' => $nombre,
        'paterno' => $paterno,
        'materno' => $materno,
        'ci' => $ci,
        'fecha_nacimiento' => $fecha_nacimiento,
        'email' => $email,
        'tipo_usuario' => 'cajero'
    ]);
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cajero registrado correctamente");
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

include("../vista/usuarioCajRegistro.php");
?>