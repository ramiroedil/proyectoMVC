<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

// Procesar filtros si existen
$filtro_aplicado = false;
$ventas = [];

if ($_POST) {
    if (isset($_POST['filtrar_fecha']) && !empty($_POST['fecha_inicio']) && !empty($_POST['fecha_fin'])) {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        
        $response = $api->get('/venta/reporte', [
            'inicio' => $fecha_inicio,
            'fin' => $fecha_fin
        ]);
        
        if ($response['success']) {
            $ventas = $response['data'];
        }
        $filtro_aplicado = true;
    } elseif (isset($_POST['filtrar_cliente']) && !empty($_POST['id_cliente'])) {
        $id_cliente = intval($_POST['id_cliente']);
        
        $response = $api->get("/venta/cliente/{$id_cliente}");
        
        if ($response['success']) {
            $ventas = $response['data'];
        }
        $filtro_aplicado = true;
    }
}

// Si no hay filtro aplicado, mostrar todas las ventas
if (!$filtro_aplicado) {
    $response = $api->get('/venta');
    
    if ($response['success']) {
        $ventas = $response['data'];
    }
}

// Obtener lista de clientes para el filtro
$response_clientes = $api->get('/cliente/active');
$clientes_lista = $response_clientes['success'] ? $response_clientes['data'] : [];

include("../vista/ventaLista.php");
?>