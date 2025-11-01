<?php
include("../modelo/clienteClase.php");
$cliente = new clientes("","","","");
$resul = $cliente->lista();
include("../vista/registroProcesarVenta.php");
?>