<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();
$response = $api->get('/empleado');

if ($response['success']) {
    $empleados = $response['data'];
} else {
    $empleados = [];
    $error_message = $response['error'];
}

include("../vista/empleadoLista.php");
?>