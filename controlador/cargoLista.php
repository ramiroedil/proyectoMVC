<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();
$response = $api->get('/cargo');

if ($response['success']) {
    $cargos = $response['data'];
} else {
    $cargos = [];
    $error_message = $response['error'];
}

include("../vista/cargoLista.php");
?>