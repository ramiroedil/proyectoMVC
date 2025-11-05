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
    
    // Actualizar datos de empleado
    if (isset($_POST['cargoId'])) {
        // Primero obtener el empleado actual
        $responseEmpleado = $api->get("/empleado/usuario/{$id}");
        
        $empleadoData = [
            'id_cargo' => intval($_POST['cargoId']),
            'salario' => floatval($_POST['salario'] ?? 0),
            'estadoLaboral' => $_POST['estadoLaboral'] ?? 'ACTIVO'
        ];
        
        if ($responseEmpleado['success'] && isset($responseEmpleado['data']['id_empleado'])) {
            // Actualizar empleado existente
            $empleadoId = $responseEmpleado['data']['id_empleado'];
            $updateEmpleado = $api->put("/empleado/{$empleadoId}", $empleadoData);
        } else {
            // Crear nuevo empleado si no existe
            $empleadoData['id_usuario'] = $id;
            $updateEmpleado = $api->post("/empleado", $empleadoData);
        }
    }
    
    ?>
    <script>
        alert('Empleado actualizado correctamente');
        location.href = '../controlador/empleadoLista.php';
    </script>
    <?php
    exit();
    
} elseif (isset($_GET['id'])) {
    // Cargar datos para editar
    $id = intval($_GET['id']);
    $response = $api->get("/usuario/search/{$id}");
    
    if ($response['success'] && $response['data']) {
        $usuario = $response['data'];
        
        // Verificar que sea un empleado
        if ($usuario['tipo_usuario'] !== 'empleado') {
            ?>
            <script>
                alert('Este usuario no es un empleado');
                location.href = '../controlador/empleadoLista.php';
            </script>
            <?php
            exit();
        }
        
        // Obtener cargos
        $responseCargos = $api->get('/cargo/active');
        $cargos = $responseCargos['success'] ? $responseCargos['data'] : [];
        
        // Cargar la vista
        include("../vista/empleadoEditar.php");
    } else {
        ?>
        <script>
            alert('Empleado no encontrado');
            location.href = '../controlador/empleadoLista.php';
        </script>
        <?php
        exit();
    }
} else {
    header('Location: ../controlador/empleadoLista.php');
    exit();
}
?>