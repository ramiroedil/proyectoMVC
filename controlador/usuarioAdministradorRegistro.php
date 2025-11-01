<?php
ob_start();
include_once("../modelo/usuario.php");
include("../vista/usuarioAdmRegistro.php");


if($_SERVER['REQUEST_METHOD']==='POST'){
    
    $nombreUsuario = $_POST['usuario'];
    if (Usuario::existeNombreUsuario($nombreUsuario)) {
        echo "<script>alert('El nombre de usuario ya está en uso. Elige otro.'); window.history.back();</script>";
        exit;
    }

    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['paterno'];
    $apellidoMaterno = $_POST['materno'];
    $ci = $_POST['ci'];
    $fechaNacimiento = $_POST['fechanacimiento'];
    $password = $_POST['pasword'];
    $email = $_POST['email'];
    $contraseña = password_hash($password, PASSWORD_DEFAULT);

    $usuario = new Usuario(
        "",
        $nombre,
        $apellidoPaterno,
        $apellidoMaterno,
        $ci,
        $nombreUsuario,
        $contraseña,
        $fechaNacimiento,
        "administrador",
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
