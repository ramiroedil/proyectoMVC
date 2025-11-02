<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$datos = [];

if (isset($_GET["Buscar"])) {
    $nombreCliente = trim($_GET["cliente"]);
    
    if (!empty($nombreCliente)) {
        $api = new ApiClient();
        $response = $api->get('/cliente/search', ['query' => $nombreCliente]);
        
        if ($response['success']) {
            $datos = $response['data'];
        }
    }
}

include("../vista/clienteBuscar.php");
?>