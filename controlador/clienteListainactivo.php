<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();
$response = $api->get('/cliente/inactive');

if ($response['success']) {
    $clientes = $response['data'];
} else {
    $clientes = [];
    $error_message = $response['error'];
}

include("../vista/clienteLista_Inactivos.php");
?>