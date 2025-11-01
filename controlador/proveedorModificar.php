<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  include("../modelo/proveedorClase.php");
  if (isset($_GET['modificarProveedor'])) {
    $em = $_GET['empresa'];
    $co = $_GET['contacto'];
    $ma = $_GET['mail'];
    $te = $_GET['telefono'];
    $di = $_GET['direccion'];
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
      //$foto = $_FILES['foto']['name'];
      $lo=$_FILES['logo']['name'];
      $origen = $_FILES['logo']['tmp_name'];
    } else {
      echo "No se ha seleccionado ninguna imagen";
    }
    $pr = new Proveedor($id, $em, $co, $ma, $te, $di, "$lo");
    $re = $pr->ediProveedor();
    if ($re) {
      @copy($origen,'imagenes/'.$lo);
?>
<script type="text/javascript">
alert("Se modifico correctamente");
location.href = '../controlador/proveedorLista.php';
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
    $pro = new Proveedor($id, "", "", "", "", "", "");
    $r1 = $pro->obtenerProveedor();
    $r = mysqli_fetch_array($r1);
    include("../vista/proveedorModificar.php");
  }
} else {
  echo "Error";
}
?>