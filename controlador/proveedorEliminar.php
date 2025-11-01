<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'];
#`id_empleado`,`id_cargo`, `ci`, `nombre`, `paterno`, `materno`, `direccion`, `telefono`, `fechanacimiento`, `genero`
include("../modelo/proveedorClase.php");
$emp = new Proveedor($id, "", "", "", "", "", "");
$r = $emp->elimProveedor();
if ($r) {
?>
<script type="text/javascript">
alert("Se elimino correctamente");
location.href = 'proveedorLista.php';
</script>
<?php
} else {
?>
<script type="text/javascript">
alert("Eliminacion incorrecta");
</script>
<?php
}
?>