<?php
include("../modelo/cargoClase.php");

if (isset($_GET["Buscar"])) {
    $nombreCargo = $_GET["cargo"];
    $cargo = new Cargo("","");
    $resultados = $cargo->buscarCargo($nombreCargo);

    // Guardar los resultados para usarlos en la vista
    $datos = [];
    while ($fila = mysqli_fetch_array($resultados)) {
        $datos[] = $fila;
    }


    // Cargar la vista con los datos obtenidos
    include("../vista/cargoBuscar.php");
} else {
    // Si no hay búsqueda, solo cargamos la vista vacía
    include("../vista/cargoBuscar.php");
}
?>
