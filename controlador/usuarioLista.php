<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();
$response = $api->get('/usuario');

if ($response['success']) {
    $usuarios = $response['data'];
} else {
    $usuarios = [];
    $error_message = $response['error'];
}

include("../vista/usuarioLista.php");
?>