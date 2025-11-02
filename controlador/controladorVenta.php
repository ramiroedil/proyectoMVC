<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

$api = new ApiClient();
$response = $api->get('/producto/active');

if ($response['success']) {
    $productos = $response['data'];
} else {
    $productos = [];
    $error_message = $response['error'];
}

include("../vista/registroVenta.php");
?>