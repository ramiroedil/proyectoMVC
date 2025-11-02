<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

// Obtener lista de cargos
$response_cargos = $api->get('/cargo');
$cargos = $response_cargos['success'] ? $response_cargos['data'] : [];

if (isset($_POST['registrarEmpleado'])) {
    $id_cargo = intval($_POST['id_cargo']);
    $ci = trim($_POST['ci']);
    $nombre = trim($_POST['nombre']);
    $paterno = trim($_POST['paterno']);
    $materno = trim($_POST['materno']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $fechanacimiento = $_POST['fechanacimiento'];
    $genero = $_POST['genero'];
    $intereses = trim($_POST['intereses']);

    $response = $api->post('/empleado', [
        'cargo_id' => $id_cargo,
        'ci' => $ci,
        'nombre' => $nombre,
        'paterno' => $paterno,
        'materno' => $materno,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'fecha_nacimiento' => $fechanacimiento,
        'genero' => $genero,
        'intereses' => $intereses
    ]);

    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Empleado registrado con éxito");
            location.href = '../controlador/empleadoLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al registrar: <?php echo addslashes($response['error']); ?>");
        </script>
        <?php
    }
}

include("../vista/empleadoRegistro.php");
?>