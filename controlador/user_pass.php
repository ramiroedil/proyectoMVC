<?php
require_once("../modelo/conexion.php");
require_once("../modelo/usuario.php");

$conexion = new Conexion();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$usuario = $_POST['nombreusuario'];
$nivel = $_POST['tipousuario'];

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

$consulta = "SELECT pasword FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $hash_guardado = $fila['pasword'];
    if (!password_verify($current_password, $hash_guardado)) {
        header("Location: ../vista/pass_edit.php?id=$id&error=contraseña_incorrecta");
        exit();
    }

    if ($new_password !== $confirm_new_password) {
        header("Location: ../vista/pass_edit.php?id=$id&error=contrasena_no_coincide");
        exit();
    }

    $usuarioObj = new Usuario(null, null, null, null, null, null, null, null, null, null, null, null);
    $usuarioObj->setId($id);

    if ($usuarioObj->actualizarPassword($new_password)) {
        header("Location: ../componentes/logout.php");
        exit();
    } else {
        header("Location: ../vista/pass_edit.php?id=$id&error=fallo_actualizacion");
        exit();
    }
} else {
    header("Location: ../vista/pass_edit.php?id=$id&error=usuario_no_encontrado");
    exit();
}
