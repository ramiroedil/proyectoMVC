<?php
    include ("../modelo/cargoClase.php");
    $car = new Cargo("","");
    $res = $car->lista();
    include("../vista/cargoLista.php");
?>