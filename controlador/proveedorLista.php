<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();
$success_message = '';
$error_message = '';

if (isset($_GET['success'])) {
    $success_message = 'Operación realizada correctamente';
}
if (isset($_GET['error'])) {
    $error_message = 'Error en la operación';
}

$response = $api->get('/proveedor/active');

if ($response['success']) {
    $proveedores = is_array($response['data']) ? $response['data'] : [];
} else {
    $proveedores = [];
    $error_message = $response['error'] ?? 'Error al obtener proveedores';
}

include(__DIR__ . '/../vista/proveedorLista.php');
?>