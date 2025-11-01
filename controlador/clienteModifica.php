<?php
if (isset($_GET['id_cliente'])) {
    $cid = $_GET['id_cliente'];
    include("../modelo/clienteClase.php");
    include("../modelo/conexion.php"); // Asegurar la conexión
    $db = new Conexion();
    $result = $db->query("SELECT * FROM cliente WHERE id_cliente = '$cid'");
    $r = mysqli_fetch_array($result); // Obtener los datos del cliente
    include("../vista/clienteEditar.php");
    if (isset($_GET['modificarCliente'])) {
        $razonsocial = $_GET['razonsocial'];
        $nit_ci = $_GET['nit_ci'];
        $estado = $_GET['estado'];
        $cli = new clientes($cid, $razonsocial, $nit_ci, $estado);
        $resultado = $cli->editarCliente();
        if ($resultado) {
            ?>
            <script type="text/javascript">
                alert("Cliente registrado con exito");
                location.href = '../controlador/clienteLista.php';
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                alert("Cliente NO registrado con exito");
            </script>
            <?php
        }
    }
}
?>
