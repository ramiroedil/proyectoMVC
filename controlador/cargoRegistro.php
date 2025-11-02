<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (isset($_POST['registrarCargo'])) {
    $cargo = trim($_POST['cargo']);
    
    if (empty($cargo)) {
        ?>
        <script type="text/javascript">
            alert("El campo cargo es obligatorio");
            location.href = '../controlador/cargoRegistro.php';
        </script>
        <?php
        exit();
    }

    $api = new ApiClient();
    $response = $api->post('/cargo', [
        'cargo' => $cargo
    ]);

    if ($response['success']) {
        ?>
        <script type="text/javascript">
            alert("Cargo registrado con éxito");
            location.href = '../controlador/cargoLista.php';
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

include("../vista/cargoRegistrov.php");
?>