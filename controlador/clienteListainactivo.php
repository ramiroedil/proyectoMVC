<?php
    include ("../modelo/clienteClase.php");
    $cli = new clientes("","","","");
    $res = $cli->inactivos();
    include("../vista/clienteLista_Inactivos.php");
?>