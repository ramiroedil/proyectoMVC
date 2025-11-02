<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (isset($_POST['registrarProveedor'])) {
    $empresa = trim($_POST['empresa']);
    $contacto = trim($_POST['contacto']);
    $mail = trim($_POST['mail']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    
    $api = new ApiClient();
    
    // Si hay logo
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
    
    $response = $api->post('/proveedor', $data, $files);
    
    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Proveedor registrado correctamente");
            location.href = '../controlador/proveedorLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al registrar: <?php echo addslashes($response['error']); ?>");
        </script>
        <?php
    }
}

include("../vista/proveedorRegistro.php");
?>