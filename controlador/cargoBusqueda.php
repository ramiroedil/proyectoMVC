<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$datos = [];

if (isset($_GET["Buscar"])) {
    $nombreCargo = trim($_GET["cargo"]);
    
    if (!empty($nombreCargo)) {
        $api = new ApiClient();
        $response = $api->get('/cargo/search', ['query' => $nombreCargo]);
        
        if ($response['success']) {
            $datos = $response['data'];
        }
    }
}

include("../vista/cargoBuscar.php");
?>