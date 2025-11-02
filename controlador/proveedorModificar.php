<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

if (!isset($_GET['id'])) {
    header('Location: ../controlador/proveedorLista.php');
    exit();
}

$id = intval($_GET['id']);

// Procesar modificación
if (isset($_GET['modificarProveedor'])) {
    $empresa = trim($_GET['empresa']);
    $contacto = trim($_GET['contacto']);
    $mail = trim($_GET['mail']);
    $telefono = trim($_GET['telefono']);
    $direccion = trim($_GET['direccion']);
    
    $files = [];
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
        $files['logo'] = $_FILES['logo'];
    }
    
    $data = [
        'empresa' => $empresa,
        'contacto' => $contacto,
        'mail' => $mail,
        'telefono' => $telefono,
        'direccion' => $direccion
    ];
    
    $response = $api->post("/proveedor/{$id}", $data, $files); // Usar POST con archivos
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Proveedor modificado correctamente");
            location.href = '../controlador/proveedorLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al modificar: <?php echo addslashes($response['error']); ?>");
        </script>
        <?php
    }
}

// Obtener datos del proveedor
$response_proveedor = $api->get("/proveedor/{$id}");

if ($response_proveedor['success']) {
    $r = $response_proveedor['data'];
    include("../vista/proveedorModificar.php");
} else {
    ?>
    <script type="text/javascript">
        alert("Proveedor no encontrado");
        location.href = '../controlador/proveedorLista.php';
    </script>
    <?php
}
?>