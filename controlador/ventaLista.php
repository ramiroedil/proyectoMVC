<?php
/**
 * Controlador de Venta - Listar Ventas
 * Obtiene ventas del backend con filtros opcionales
 */

require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

$api = new ApiClient();

// Variables de estado
$ventas = [];
$clientes_lista = [];
$filtro_aplicado = false;

// Obtener lista de clientes para filtro
try {
    $response_clientes = $api->get('/cliente/active');
    if ($response_clientes['success']) {
        $clientes_lista = $response_clientes['data'] ?? [];
    }
} catch (Exception $e) {
    error_log("Error al obtener clientes: " . $e->getMessage());
}

/**
 * PROCESAR FILTROS
 */

// Filtro por rango de fechas
if (isset($_POST['filtrar_fecha'])) {
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin = $_POST['fecha_fin'] ?? null;

    if ($fecha_inicio && $fecha_fin) {
        try {
            // Convertir fechas al formato correcto
            $fecha_inicio_ts = strtotime($fecha_inicio . ' 00:00:00');
            $fecha_fin_ts = strtotime($fecha_fin . ' 23:59:59');

            $response = $api->get('/venta/reporte', [
                'inicio' => date('c', $fecha_inicio_ts),
                'fin' => date('c', $fecha_fin_ts)
            ]);

            if ($response['success']) {
                // El endpoint reporte devuelve un objeto con resumen
                // Necesitamos obtener todas las ventas de ese rango directamente
                $response_fechas = $api->get('/venta/fechas', [
                    'inicio' => date('c', $fecha_inicio_ts),
                    'fin' => date('c', $fecha_fin_ts)
                ]);

                if ($response_fechas['success']) {
                    $ventas = $response_fechas['data'] ?? [];
                }
            }
            $filtro_aplicado = true;
        } catch (Exception $e) {
            error_log("Error al filtrar por fecha: " . $e->getMessage());
        }
    }
}
// Filtro por cliente
elseif (isset($_POST['filtrar_cliente'])) {
    $id_cliente = intval($_POST['id_cliente'] ?? 0);

    if ($id_cliente > 0) {
        try {
            $response = $api->get("/venta/cliente/{$id_cliente}");

            if ($response['success']) {
                $ventas = $response['data'] ?? [];
            }
            $filtro_aplicado = true;
        } catch (Exception $e) {
            error_log("Error al filtrar por cliente: " . $e->getMessage());
        }
    }
}

// Si no hay filtro aplicado, obtener todas las ventas
if (!$filtro_aplicado) {
    try {
        $response = $api->get('/venta');

        if ($response['success']) {
            $ventas = $response['data'] ?? [];
        }
    } catch (Exception $e) {
        error_log("Error al obtener ventas: " . $e->getMessage());
    }
}

// Incluir vista
include("../vista/ventaLista.php");
?>