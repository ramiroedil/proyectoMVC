<?php
ob_start();
include_once("../modelo/usuario.php");
include("../vista/usuarioCajRegistro.php");
if($_SERVER['REQUEST_METHOD']==='POST'){
    
    $nombreUsuario = $_POST['usuario'];
    if (Cajero::existeNombreUsuario($nombreUsuario)) {
        echo "<script>alert('El nombre de usuario ya está en uso. Elige otro.'); window.history.back();</script>";
        exit;
    }
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['paterno'];
    $apellidoMaterno = $_POST['materno'];
    $ci = $_POST['ci'];
    $fechaNacimiento = $_POST['fechanacimiento'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $contraseña = password_hash($password, PASSWORD_DEFAULT);
    $usuario = new Cajero(
        "",
        $nombre,
        $apellidoPaterno,
        $apellidoMaterno,
        $ci,
        $nombreUsuario,
        $contraseña,
        $fechaNacimiento,
        "cajero",
        $email,
        "",
        "activo"
    );

    $resultado = $usuario->registrarAdministrador();

    if ($resultado) {
        header("Location: ../controlador/usuarioLista.php");
    }
}

ob_end_flush();
?>
