<?php
session_start();
if (isset($_SESSION['usuario']['id_usuario'])) {
    include_once("../modelo/conexion.php");
    $db = new Conexion();
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    $db->query("UPDATE usuarios SET token = NULL WHERE id_usuario = '$id_usuario'");
}
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
header("Location: ../index.php?sw=3");
exit();
?>
