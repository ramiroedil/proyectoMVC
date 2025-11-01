<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../modelo/empleadosClase.php");
include ("../modelo/cargoClase.php");
$car=new Cargo("","");
  $res=$car->lista();
if(isset($_POST['registrarEmpleado'])){
  $id_c=$_POST['id_cargo']; 
  $ci=$_POST['ci'];
  $no=$_POST['nombre'];
  $pa=$_POST['paterno'];
  $ma=$_POST['materno'];
  $di=$_POST['direccion'];
  $te=$_POST['telefono'];
  $fnac=$_POST['fechanacimiento'];
  $ge=$_POST['genero'];
  $in=$_POST['intereses'];
  //cargamos los datos al objeto emp utilizando el constructor de la clase empleado
  $emp=new Empleado("",$id_c,$ci,$no,$pa,$ma,$di,$te,$fnac,$ge,$in);
  //procedemos a registrar al empleado del objeto emp a la base de datos mediante la funcion de la clase empleado
  $r=$emp->grabarEmpleado();
  if ($r) {//si el registro es verdadero o exitoso
?>
<script type="text/javascript">
alert("Se registro correctamente");
location.href = 'empleadoLista.php';
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
include ("../vista/empleadoRegistro.php");

?>