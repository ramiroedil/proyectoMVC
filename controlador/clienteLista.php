<?php
    include ("../modelo/clienteClase.php");
    $cli = new clientes("","","","");
    $res = $cli->lista();
    include("../vista/clienteLista.php");
?>