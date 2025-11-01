<?php
include("../modelo/clienteClase.php");

$datos = []; // Inicializa la variable para evitar errores en la vista

if (isset($_GET["Buscar"])) {
    $nombreCliente = $_GET["cliente"]; // Variable corregida
    $cliente = new clientes("", "", "", ""); // Asegúrate de que la clase existe
    $resultados = $cliente->buscarCliente($nombreCliente); // Pasar parámetro
        while ($fila = mysqli_fetch_array($resultados)) {
        $datos[] = $fila;
    }
}

// Cargar la vista con los datos obtenidos (si hay búsqueda) o vacía
include("../vista/clienteBuscar.php");
?>

