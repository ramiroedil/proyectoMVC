<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

Session::start();
if (!Session::has('usuario') || !Session::has('token')) {
    header('Location: ../index.php?sw=2');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $api = new ApiClient();
    $response = $api->delete("/usuario/{$id}");
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Usuario eliminado correctamente");
            location.href = '../controlador/usuarioLista.php';
        </script>
        <?php
    } else {
        $error_message = $response['message'] ?? $response['error'] ?? 'Error al eliminar';
        ?>
        <script type="text/javascript">
            alert("Error al eliminar: <?= addslashes($error_message) ?>");
            history.back();
        </script>
        <?php
    }
} else {
    header('Location: ../controlador/usuarioLista.php');
}
?>