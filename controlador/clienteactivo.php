<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == "activar") {
    $id = intval($_GET['id']);
    $api = new ApiClient();
    
    $response = $api->patch("/cliente/{$id}/activar");
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cliente activado con éxito");
            location.href = '../controlador/clienteLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al activar: <?php echo addslashes($response['error']); ?>");
            location.href = '../controlador/clienteLista.php';
        </script>
        <?php
    }
}
?>