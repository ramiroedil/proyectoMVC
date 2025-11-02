<?php
$usuario = $_GET["usuario"] ?? null;

if ($usuario === "cliente") {
    include("usuarioClienteRegistro.php");
} elseif ($usuario === "cajero") {
    include("usuarioCajeroRegistro.php");
} elseif ($usuario === "administrador") {
    include("usuarioAdministradorRegistro.php");
} else {
    include_once("../vista/usuarioRegistro.php");
}
?>