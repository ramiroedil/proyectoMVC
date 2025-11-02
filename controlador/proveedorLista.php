<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();
$response = $api->get('/proveedor/active');

if ($response['success']) {
    $proveedores = $response['data'];
} else {
    $proveedores = [];
    $error_message = $response['error'];
}

include("../vista/proveedorLista.php");
?>