<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

header('Content-Type: application/json');

if (isset($_POST['id_usuario']) && isset($_POST['estado'])) {
    $id = intval($_POST['id_usuario']);
    $nuevoEstado = $_POST['estado'];
    
    $api = new ApiClient();
    $response = $api->patch("/usuario/{$id}/estado", [
        'estado' => $nuevoEstado
    ]);
    
    if ($response['success']) {
        echo json_encode(["success" => true, "estado" => $nuevoEstado]);
    } else {
        echo json_encode(["success" => false, "error" => $response['error']]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Datos incompletos."]);
}
?>