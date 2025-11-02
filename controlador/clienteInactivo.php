<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == "desactivar") {
    $id = intval($_GET['id']);
    $api = new ApiClient();
    
    $response = $api->patch("/cliente/{$id}/desactivar");
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cliente desactivado con éxito");
            location.href = '../controlador/clienteLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al desactivar: <?php echo addslashes($response['error']); ?>");
            location.href = '../controlador/clienteLista.php';
        </script>
        <?php
    }
}
?>