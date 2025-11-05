<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

Session::start();
if (!Session::has('usuario') || !Session::has('token')) {
    header('Location: ../index.php?sw=2');
    exit();
}

$api = new ApiClient();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    
    // Datos del usuario
    $dataUpdate = [
        'nombre' => trim($_POST['nombre']),
        'apellido_paterno' => trim($_POST['paterno']),
        'apellido_materno' => trim($_POST['materno'] ?? ''),
        'ci' => trim($_POST['ci']),
        'usuario' => trim($_POST['usuario']),
        'email' => trim($_POST['email']),
        'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
        'telefono' => trim($_POST['telefono'] ?? ''),
        'direccion' => trim($_POST['direccion'] ?? ''),
        'genero' => $_POST['genero'] ?? null
    ];
    
    // Estado del usuario
    if (isset($_POST['estado'])) {
        $dataUpdate['estado'] = $_POST['estado'] == '1' ? true : false;
    }
    
    // Si hay nueva contraseña
    if (!empty($_POST['password'])) {
        $dataUpdate['password'] = $_POST['password'];
    }
    
    // Actualizar usuario
    $response = $api->put("/usuario/update/{$id}", $dataUpdate);
    
    if (!$response['success']) {
        $error_msg = $response['message'] ?? 'Error desconocido';
        ?>
        <script>
            alert('Error al modificar usuario: <?= addslashes($error_msg) ?>');
            history.back();
        </script>
        <?php
        exit();
    }
    
    // Actualizar datos de cliente
    if (isset($_POST['nit_ci'])) {
        // Primero obtener el cliente actual
        $responseCliente = $api->get("/cliente/usuario/{$id}");
        
        $clienteData = [
            'nit_ci' => trim($_POST['nit_ci']),
            'razon_social' => trim($_POST['razon_social'] ?? ''),
            'tipo_cliente' => $_POST['tipo_cliente'] ?? 'PERSONA',
            'estado_cliente' => $_POST['estado_cliente'] ?? 'ACTIVO'
        ];
        
        if ($responseCliente['success'] && isset($responseCliente['data']['id'])) {
            // Actualizar cliente existente
            $clienteId = $responseCliente['data']['id'];
            $updateCliente = $api->put("/cliente/{$clienteId}", $clienteData);
        } else {
            // Crear nuevo cliente si no existe
            $clienteData['usuarioId'] = $id;
            $updateCliente = $api->post("/cliente", $clienteData);
        }
    }
    
    ?>
    <script>
        alert('Cliente actualizado correctamente');
        location.href = '../controlador/clienteLista.php';
    </script>
    <?php
    exit();
    
} elseif (isset($_GET['id'])) {
    // Cargar datos para editar
    $id = intval($_GET['id']);
    $response = $api->get("/usuario/search/{$id}");
    
    if ($response['success'] && $response['data']) {
        // Variable renombrada para evitar conflicto con el usuario de sesión
        $usuarioCliente = $response['data'];
        
        // Verificar que sea un cliente
        if ($usuarioCliente['tipo_usuario'] !== 'cliente') {
            ?>
            <script>
                alert('Este usuario no es un cliente');
                location.href = '../controlador/clienteLista.php';
            </script>
            <?php
            exit();
        }
        
        // Cargar la vista
        include("../vista/clienteEditar.php");
    } else {
        ?>
        <script>
            alert('Cliente no encontrado');
            location.href = '../controlador/clienteLista.php';
        </script>
        <?php
        exit();
    }
} else {
    header('Location: ../controlador/clienteLista.php');
    exit();
}
?>