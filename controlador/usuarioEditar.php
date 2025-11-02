<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $paterno = trim($_POST['paterno']);
    $materno = trim($_POST['materno']);
    $ci = trim($_POST['ci']);
    $username = trim($_POST['usuario']);
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $email = trim($_POST['email']);
    $estado = $_POST['estado'];
    
    $response = $api->patch("/usuario/{$id}", [
        'nombre' => $nombre,
        'paterno' => $paterno,
        'materno' => $materno,
        'ci' => $ci,
        'username' => $username,
        'fecha_nacimiento' => $fecha,
        'tipo_usuario' => $tipo,
        'email' => $email,
        'estado' => $estado
    ]);
    
    if ($response['success']) {
        ?>
        <script>
            alert('Usuario modificado correctamente');
            location.href='../controlador/usuarioLista.php';
        </script>
        <?php
    } else {
        ?>
        <script>
            alert('Error al modificar: <?php echo addslashes($response['error']); ?>');
        </script>
        <?php
    }
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $response = $api->get("/usuario/{$id}");
    
    if ($response['success']) {
        $datos = $response['data'];
        include("../vista/usuarioEditar.php");
    } else {
        ?>
        <script>
            alert('Usuario no encontrado');
            location.href='../controlador/usuarioLista.php';
        </script>
        <?php
    }
} else {
    echo "Error: ID de usuario no proporcionado.";
}
?>