<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (!isset($_GET['id'])) {
    header('Location: ../controlador/proveedorLista.php');
    exit();
}

$id = intval($_GET['id']);
$api = new ApiClient();
$response = $api->delete("/proveedor/{$id}");

if ($response['success']) {
    ?>
    <script type="text/javascript">
        alert("Proveedor eliminado correctamente");
        location.href = '../controlador/proveedorLista.php';
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("Error al eliminar: <?php echo addslashes($response['error']); ?>");
        location.href = '../controlador/proveedorLista.php';
    </script>
    <?php
}
?>