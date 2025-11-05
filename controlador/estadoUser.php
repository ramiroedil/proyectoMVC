<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

Session::start();
if (!Session::has('usuario') || !Session::has('token')) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = intval($_POST['id_usuario']);
    $estado = $_POST['estado'];
    
    $api = new ApiClient();
    
    if ($estado === 'activo') {
        $response = $api->patch("/usuario/activate/{$id_usuario}");
    } else {
        $response = $api->patch("/usuario/deactivate/{$id_usuario}");
    }
    
    if ($response['success']) {
        echo json_encode(['success' => true]);
    } else {
        $error = $response['message'] ?? $response['error'] ?? 'Error al cambiar estado';
        echo json_encode(['success' => false, 'error' => $error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>