<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

// Obtener lista de cargos
$response_cargos = $api->get('/cargo');
$cargos = $response_cargos['success'] ? $response_cargos['data'] : [];

if (!isset($_GET['id'])) {
    header('Location: ../controlador/empleadoLista.php');
    exit();
}

$id = intval($_GET['id']);

// Procesar modificación
if (isset($_GET['modificarEmpleado'])) {
    $cargo_id = intval($_GET['id_cargo']);
    $ci = trim($_GET['ci']);
    $nombre = trim($_GET['nombre']);
    $paterno = trim($_GET['paterno']);
    $materno = trim($_GET['materno']);
    $direccion = trim($_GET['direccion']);
    $telefono = trim($_GET['telefono']);
    $fecha_nacimiento = $_GET['fechanacimiento'];
    $genero = $_GET['genero'];
    $intereses = trim($_GET['intereses']);
    
    $response = $api->patch("/empleado/{$id}", [
        'cargo_id' => $cargo_id,
        'ci' => $ci,
        'nombre' => $nombre,
        'paterno' => $paterno,
        'materno' => $materno,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'fecha_nacimiento' => $fecha_nacimiento,
        'genero' => $genero,
        'intereses' => $intereses
    ]);
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Empleado modificado correctamente");
            location.href = '../controlador/empleadoLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al modificar: <?php echo addslashes($response['error']); ?>");
        </script>
        <?php
    }
}

// Obtener datos del empleado
$response_empleado = $api->get("/empleado/{$id}");

if ($response_empleado['success']) {
    $r = $response_empleado['data'];
    include("../vista/empleadoModificar.php");
} else {
    ?>
    <script type="text/javascript">
        alert("Empleado no encontrado");
        location.href = '../controlador/empleadoLista.php';
    </script>
    <?php
}
?>