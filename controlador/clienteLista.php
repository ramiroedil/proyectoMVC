<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

Session::start();
if (!Session::has('usuario') || !Session::has('token')) {
    header('Location: ../index.php?sw=2');
    exit();
}

$api = new ApiClient();
$response = $api->get('/usuario');

if ($response['success']) {
    // Filtrar solo clientes
    $usuarios = array_filter($response['data'], function($user) {
        return $user['tipo_usuario'] === 'cliente';
    });
} else {
    $usuarios = [];
    $error_message = $response['message'] ?? $response['error'] ?? 'Error al cargar clientes';
}

include("../vista/clienteLista.php");
?>