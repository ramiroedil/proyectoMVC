<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (!isset($_GET['id'])) {
    header('Location: ../controlador/cargoLista.php');
    exit();
}

$id = intval($_GET['id']);
$api = new ApiClient();

// Procesar actualización
if (isset($_GET['act'])) {
    $cargo = trim($_GET['cargo']);
    
    if (empty($cargo)) {
        ?>
        <script type="text/javascript">
            alert("El campo cargo es obligatorio");
            window.history.back();
        </script>
        <?php
        exit();
    }

    $response = $api->patch("/cargo/{$id}", [
        'cargo' => $cargo
    ]);

    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cargo actualizado con éxito");
            location.href = '../controlador/cargoLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al actualizar: <?php echo addslashes($response['error']); ?>");
        </script>
        <?php
    }
}

// Obtener datos del cargo
$response = $api->get("/cargo/{$id}");

if ($response['success']) {
    $r = $response['data'];
    include("../vista/cargoEditar.php");
} else {
    ?>
    <script type="text/javascript">
        alert("Cargo no encontrado");
        location.href = '../controlador/cargoLista.php';
    </script>
    <?php
}
?><?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (!isset($_GET['id'])) {
    header('Location: ../controlador/cargoLista.php');
    exit();
}

$id = intval($_GET['id']);
$api = new ApiClient();

// Procesar actualización
if (isset($_GET['act'])) {
    $cargo = trim($_GET['cargo']);
    
    if (empty($cargo)) {
        ?>
        <script type="text/javascript">
            alert("El campo cargo es obligatorio");
            window.history.back();
        </script>
        <?php
        exit();
    }

    $response = $api->patch("/cargo/{$id}", [
        'cargo' => $cargo
    ]);

    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cargo actualizado con éxito");
            location.href = '../controlador/cargoLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al actualizar: <?php echo addslashes($response['error']); ?>");
        </script>
        <?php
    }
}

// Obtener datos del cargo
$response = $api->get("/cargo/{$id}");

if ($response['success']) {
    $r = $response['data'];
    include("../vista/cargoEditar.php");
} else {
    ?>
    <script type="text/javascript">
        alert("Cargo no encontrado");
        location.href = '../controlador/cargoLista.php';
    </script>
    <?php
}
?>