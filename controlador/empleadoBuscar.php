<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$empleados = [];

if (isset($_GET["Buscar"])) {
    $nombre = trim($_GET["empleado"]);
    
    if (!empty($nombre)) {
        $api = new ApiClient();
        $response = $api->get('/empleado/search', ['query' => $nombre]);
        
        if ($response['success']) {
            $empleados = $response['data'];
        }
    }
}

include("../vista/empleadoBuscar.php");
?>