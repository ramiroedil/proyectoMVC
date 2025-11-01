<?php
  include ("../modelo/productoClase.php");
  $pro=new Producto("","","","","","","","","");
  $res=$pro->lista();
  $rs=$pro->lista();
  include("../vista/productoLista.php");
?>