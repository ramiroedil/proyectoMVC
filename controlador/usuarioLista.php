<?php
    
    include_once ("../modelo/usuario.php");
    $car = new Usuario(""
    ,""
    ,""
    ,"","","","","","","","","");
    $resul = $car->lista();
    include("../vista/usuarioLista.php");
?>
