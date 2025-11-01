<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../modelo/proveedorClase.php");
if(isset($_POST['registrarProveedor'])){
  $id_p=$_POST['id_proveedor']; 
  $em=$_POST['empresa'];
  $con=$_POST['contacto'];
  $ma=$_POST['mail'];
  $te=$_POST['telefono'];
  $di=$_POST['direccion'];
  $l=$_FILES['logo']['name'];
  $lo=$_FILES['logo']['tmp_name'];
  $log=$_FILES['logo']['size'];
  //cargamos los datos al objeto emp utilizando el constructor de la clase empleado
  $emp=new Proveedor($id_p,$em,$con,$ma,$te,$di,"$l");
  //procedemos a registrar al empleado del objeto emp a la base de datos mediante la funcion de la clase empleado
  $r=$emp->grabarProveedor();
  if ($r) {//si el registro es verdadero o exitoso
    @copy($lo,'imagenes/'.$l);
?>
<script type="text/javascript">
alert("Se registro correctamente");
location.href = 'proveedorLista.php';
</script>
<?php
  }else{//si es falso o ocurrio un error
    echo "<script>alert('Error: " . mysqli_error($conexion) . "');</script>";
    ?>
<script type="text/javascript">
alert("Registro Incorrecto, revise sus datos por favor");
</script>
<?php
  }
  
}
include ("../vista/proveedorRegistro.php");

?>