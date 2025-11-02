<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (!isset($_GET['id'])) {
    header('Location: ../controlador/clienteLista.php');
    exit();
}

$id = intval($_GET['id']);
$api = new ApiClient();
$response = $api->delete("/cliente/{$id}");

if ($response['success']) {
    ?>
    <script type="text/javascript">
        alert("Cliente eliminado con éxito");
        location.href = '../controlador/clienteLista.php';
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("Error al eliminar: <?php echo addslashes($response['error']); ?>");
        location.href = '../controlador/clienteLista.php';
    </script>
    <?php
}
?>