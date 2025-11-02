<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (!isset($_GET['id'])) {
    header('Location: ../controlador/cargoLista.php');
    exit();
}

$id = intval($_GET['id']);
$api = new ApiClient();
$response = $api->delete("/cargo/{$id}");

if ($response['success']) {
    ?>
    <script type="text/javascript">
        alert("Cargo eliminado con éxito");
        location.href = '../controlador/cargoLista.php';
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("Error al eliminar: <?php echo addslashes($response['error']); ?>");
        location.href = '../controlador/cargoLista.php';
    </script>
    <?php
}
?>