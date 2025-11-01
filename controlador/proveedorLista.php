<?php
  include ("../modelo/proveedorClase.php");
  $emp=new Proveedor("","","","","","","");
  $res=$emp->lista();
  $rs=$emp->lista();
  include("../vista/proveedorLista.php");
?>