<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

$id = intval($_POST['id']);
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

// Validar que las contraseñas coincidan
if ($new_password !== $confirm_new_password) {
    header("Location: ../vista/pass_edit.php?id=$id&error=contrasena_no_coincide");
    exit();
}

$api = new ApiClient();

// Cambiar contraseña
$response = $api->patch("/usuario/{$id}/password", [
    'current_password' => $current_password,
    'new_password' => $new_password
]);

if ($response['success']) {
    // Cerrar sesión después de cambiar contraseña
    Session::destroy();
    header("Location: ../index.php?sw=3");
    exit();
} else {
    $error = 'fallo_actualizacion';
    
    if (strpos($response['error'], 'actual') !== false || strpos($response['error'], 'current') !== false) {
        $error = 'contraseña_incorrecta';
    }
    
    header("Location: ../vista/pass_edit.php?id=$id&error=$error");
    exit();
}
?>