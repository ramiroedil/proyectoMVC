<?php
include("../modelo/ventaClase.php");

// Crear instancia de Venta para listar
$venta = new Venta("", "", "", "");

// Procesar filtros si existen
$filtro_aplicado = false;
$ventas_resultado = null;

if ($_POST) {
    if (isset($_POST['filtrar_fecha']) && !empty($_POST['fecha_inicio']) && !empty($_POST['fecha_fin'])) {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $ventas_resultado = $venta->buscarVentasPorFecha($fecha_inicio, $fecha_fin);
        $filtro_aplicado = true;
    } elseif (isset($_POST['filtrar_cliente']) && !empty($_POST['id_cliente'])) {
        $id_cliente = $_POST['id_cliente'];
        $ventas_resultado = $venta->buscarVentasPorCliente($id_cliente);
        $filtro_aplicado = true;
    }
}

// Si no hay filtro aplicado, mostrar todas las ventas
if (!$filtro_aplicado) {
    $ventas_resultado = $venta->listarVentas();
}

// Obtener lista de clientes para el filtro
include_once("../modelo/clienteClase.php");
$cliente_obj = new clientes("", "", "", "");
$clientes_lista = $cliente_obj->lista();

include("../vista/ventaLista.php");
?>