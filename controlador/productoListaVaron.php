<?php
  include ("../modelo/productoClase.php");
  $pro=new Producto("","","","","","","","","");
  $ros=$pro->hombre();
  $ro=$pro->hombre();
  include("../vista/productoLista_varon.php");
?>