<?php
  include ("../modelo/productoClase.php");
  $pro=new Producto("","","","","","","","","");
  $ros=$pro->mujer();
  $ro=$pro->mujer();
  include("../vista/productoLista_Mujer.php");
?>