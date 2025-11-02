<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (isset($_POST['registrarCliente'])) {
    $razonsocial = trim($_POST['razonsocial']);
    $nit_ci = trim($_POST['nit_ci']);
    
    if (empty($razonsocial) || empty($nit_ci)) {
        ?>
        <script type="text/javascript">
            alert("Todos los campos son obligatorios");
            location.href = '../controlador/clienteRegistroCo.php';
        </script>
        <?php
        exit();
    }

    $api = new ApiClient();
    $response = $api->post('/cliente', [
        'razon_social' => $razonsocial,
        'nit_ci' => $nit_ci
    ]);

    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cliente registrado con éxito");
            location.href = '../controlador/clienteLista.php';
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

include("../vista/clienteRegistro.php");
?>