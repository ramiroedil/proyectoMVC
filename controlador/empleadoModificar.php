<?php
include_once("../modelo/cargoClase.php");
$cargo = new Cargo("", "");
$res = $cargo->lista();
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  #`id_empleado`,`id_cargo`, `ci`, `nombre`, `paterno`, `materno`, `direccion`, `telefono`, `fechanacimiento`, `genero`
  include("../modelo/empleadosClase.php");
  if (isset($_GET['modificarEmpleado'])) {
    $idC = $_GET['id_cargo'];
    $ci = $_GET['ci'];
    $no = $_GET['nombre'];
    $pa = $_GET['paterno'];
    $ma = $_GET['materno'];
    $di = $_GET['direccion'];
    $te = $_GET['telefono'];
    $fn = $_GET['fechanacimiento'];
    $ge = $_GET['genero'];
    $e = new Empleado($id, $idC, $ci, $no, $pa, $ma, $di, $te, $fn, $ge, $in);
    $re = $e->editEmpleado();
    if ($re) {
?>
<script type="text/javascript">
alert("Se modifico correctamente");
location.href = '../controlador/empleadoLista.php';
</script>
<?php
    } else {
    ?>
<script type="text/javascript">
alert("Modificacion incorrecta");
</script>
<?php
    }
  } else {
    $emp = new Empleado($id, "", "", "", "", "", "", "", "", "", "");
    $r1 = $emp->obtenerEmpleado();
    $r = mysqli_fetch_array($r1);
    include("../vista/empleadoModificar.php");
  }
} else {
  echo "Error";
}
?>