<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../modelo/usuario.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $ci = $_POST['ci'];
    $usuario = $_POST['usuario'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $email = $_POST['email'];
    $estado = $_POST['estado'];

    $u = new Usuario(
        "",
        $nombre,
        $paterno,
        $materno,
        $ci,
        $usuario,
        "",  
        $fecha,
        $tipo,
        $email,
        $id,
        $estado
    );

    $res = $u->editarUsuario();

    if ($res) {
        echo "<script>alert('Se modificó correctamente'); location.href='../controlador/usuarioLista.php';</script>";
    } else {
        echo "<script>alert('Modificación incorrecta');</script>";
    }

} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexion = new Conexion();
    $sql = $conexion->query("SELECT * FROM usuarios WHERE id_usuario = '$id'");
    $datos = mysqli_fetch_array($sql);
    include("../vista/usuarioEditar.php");

} else {
    echo "Error: ID de usuario no proporcionado.";
}
?>
