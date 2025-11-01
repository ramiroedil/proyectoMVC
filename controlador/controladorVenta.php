<?php
include("../modelo/productoClase.php");
$producto = new Producto("","","","","",
"","","","");
$res = $producto->lista();
include("../vista/registroVenta.php");
?>