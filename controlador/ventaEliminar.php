<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Verificar que el usuario tenga permisos de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipousuario'] !== 'administrador') {
    ?>
    <script type="text/javascript">
        alert("No tiene permisos para realizar esta acción");
        location.href = 'ventaLista.php';
    </script>
    <?php
    exit();
}

$id_venta = $_GET['id'];

include("../modelo/ventaClase.php");

$venta = new Venta($id_venta, "", "", "");
$r = $venta->eliminarVenta();

if ($r) {
    ?>
    <script type="text/javascript">
        alert("Venta eliminada correctamente. El stock de los productos ha sido restaurado.");
        location.href = '../controlador/ventaLista.php';
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("No se pudo eliminar la venta. Inténtelo nuevamente.");
        location.href = '../controlador/ventaLista.php';
    </script>
    <?php
}
?>