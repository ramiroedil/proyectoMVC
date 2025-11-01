<?php
  include ("../modelo/empleadosClase.php");
  $emp=new Empleado("","","","","","","","","","","");
  $res=$emp->lista();
  include("../vista/empleadoLista.php");
?>