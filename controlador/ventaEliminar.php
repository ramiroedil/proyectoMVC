<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

Session::start();

// Verificar permisos de administrador
if (!Session::hasRole('administrador')) {
    ?>
    <script type="text/javascript">
        alert("No tiene permisos para realizar esta acción");
        location.href = '../controlador/ventaLista.php';
    </script>
    <?php
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../controlador/ventaLista.php');
    exit();
}

$id_venta = intval($_GET['id']);
$api = new ApiClient();
$response = $api->post("/venta/cancelar/{$id_venta}");

if ($response['success']) {
    ?>
    <script type="text/javascript">
        alert("Venta cancelada correctamente. El stock ha sido restaurado.");
        location.href = '../controlador/ventaLista.php';
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("No se pudo cancelar la venta: <?php echo addslashes($response['error']); ?>");
        location.href = '../controlador/ventaLista.php';
    </script>
    <?php
}
?>