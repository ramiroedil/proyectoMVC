<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

// Validar ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: proveedorLista.php?error=1');
    exit();
}

$id = intval($_GET['id']);

if ($id <= 0) {
    header('Location: proveedorLista.php?error=1');
    exit();
}

// Enviar DELETE a la API
$response = $api->delete("/proveedor/{$id}");

if ($response['success']) {
    header('Location: proveedorLista.php?success=1');
    exit();
} else {
    header('Location: proveedorLista.php?error=1');
    exit();
}
?>