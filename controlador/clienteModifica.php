<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (!isset($_GET['id_cliente'])) {
    header('Location: ../controlador/clienteLista.php');
    exit();
}

$id = intval($_GET['id_cliente']);
$api = new ApiClient();

// Procesar actualización
if (isset($_GET['modificarCliente'])) {
    $razonsocial = trim($_GET['razonsocial']);
    $nit_ci = trim($_GET['nit_ci']);
    
    if (empty($razonsocial) || empty($nit_ci)) {
        ?>
        <script type="text/javascript">
            alert("Todos los campos son obligatorios");
            window.history.back();
        </script>
        <?php
        exit();
    }

    $response = $api->patch("/cliente/{$id}", [
        'razon_social' => $razonsocial,
        'nit_ci' => $nit_ci
    ]);

    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cliente actualizado con éxito");
            location.href = '../controlador/clienteLista.php';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Error al actualizar: <?php echo addslashes($response['error']); ?>");
        </script>
        <?php
    }
}

// Obtener datos del cliente
$response = $api->get("/cliente/{$id}");

if ($response['success']) {
    $r = $response['data'];
    include("../vista/clienteEditar.php");
} else {
    ?>
    <script type="text/javascript">
        alert("Cliente no encontrado");
        location.href = '../controlador/clienteLista.php';
    </script>
    <?php
}
?>