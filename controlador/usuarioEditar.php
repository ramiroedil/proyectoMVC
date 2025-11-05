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
    $tipo_usuario = $_POST['tipo_usuario_original'] ?? 'usuario';
    
    // Datos comunes del usuario
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
    
    // Manejar el estado correctamente
    if (isset($_POST['estado'])) {
        $dataUpdate['estado'] = $_POST['estado'] == '1' || $_POST['estado'] == 'true' ? true : false;
    }
    
    // Si se proporciona nueva contraseña
    if (!empty($_POST['password'])) {
        $dataUpdate['password'] = $_POST['password'];
    }
    
    // Actualizar usuario base
    $response = $api->put("/usuario/update/{$id}", $dataUpdate);
    
    if (!$response['success']) {
        $error_msg = $response['message'] ?? $response['error'] ?? 'Error desconocido';
        ?>
        <script>
            alert('Error al modificar usuario: <?= addslashes($error_msg) ?>');
            history.back();
        </script>
        <?php
        exit();
    }
    
    // Actualizar datos específicos según tipo de usuario
    $redirectUrl = '../controlador/usuarioLista.php';
    $mensajeExito = 'Usuario actualizado correctamente';
    
    if ($tipo_usuario === 'empleado') {
        $redirectUrl = '../controlador/empleadoLista.php';
        
        // IMPORTANTE: Los nombres CORRECTOS para el DTO son:
        // - cargoId (NO id_cargo)
        // - usuarioId (NO id_usuario)
        
        if (isset($_POST['cargoId']) && !empty($_POST['cargoId'])) {
            
            // Preparar datos del empleado CON LOS NOMBRES CORRECTOS
            $empleadoData = [];
            
            // Usar EXACTAMENTE los nombres que espera el DTO
            $empleadoData['cargoId'] = intval($_POST['cargoId']);
            
            if (isset($_POST['salario']) && $_POST['salario'] !== '') {
                $empleadoData['salario'] = floatval($_POST['salario']);
            }
            
            if (isset($_POST['estadoLaboral']) && !empty($_POST['estadoLaboral'])) {
                $empleadoData['estadoLaboral'] = $_POST['estadoLaboral'];
            }
            
            // Obtener empleado existente
            $empleadoResponse = $api->get("/empleado/usuario/{$id}");
            
            if ($empleadoResponse['success'] && isset($empleadoResponse['data'])) {
                $empleadoData_Resp = $empleadoResponse['data'];
                
                // Determinar el ID del empleado
                $empleadoId = null;
                
                if (is_array($empleadoData_Resp)) {
                    // Si es array, buscar el ID
                    if (isset($empleadoData_Resp['id'])) {
                        $empleadoId = $empleadoData_Resp['id'];
                    } elseif (isset($empleadoData_Resp['id_empleado'])) {
                        $empleadoId = $empleadoData_Resp['id_empleado'];
                    } elseif (is_array($empleadoData_Resp) && count($empleadoData_Resp) > 0) {
                        // Array de empleados, tomar el primero
                        $empleadoId = $empleadoData_Resp[0]['id'] ?? $empleadoData_Resp[0]['id_empleado'] ?? null;
                    }
                }
                
                if ($empleadoId && count($empleadoData) > 0) {
                    // Actualizar empleado existente
                    $responseEmpleado = $api->put("/empleado/update/{$empleadoId}", $empleadoData);
                    
                    if (!$responseEmpleado['success']) {
                        // Si falla, reportar el error específico
                        $errorMsg = $responseEmpleado['error'] ?? $responseEmpleado['message'] ?? 'Error desconocido';
                        
                        // Si es error de validación, extraer detalles
                        if (is_array($errorMsg)) {
                            $errorMsg = implode(', ', $errorMsg);
                        }
                        
                        $mensajeExito = 'Usuario actualizado. Nota: ' . $errorMsg;
                    }
                } else {
                    $mensajeExito = 'Usuario actualizado. Nota: No se pudo obtener el ID del empleado.';
                }
            } else {
                // Crear nuevo empleado si no existe
                if (count($empleadoData) > 0) {
                    $empleadoData['usuarioId'] = $id;  // ← NOMBRE CORRECTO
                    $responseEmpleado = $api->post("/empleado", $empleadoData);
                    
                    if (!$responseEmpleado['success']) {
                        $errorMsg = $responseEmpleado['error'] ?? $responseEmpleado['message'] ?? 'Error desconocido';
                        if (is_array($errorMsg)) {
                            $errorMsg = implode(', ', $errorMsg);
                        }
                        $mensajeExito = 'Usuario actualizado. Nota: ' . $errorMsg;
                    }
                }
            }
        }
        
    } elseif ($tipo_usuario === 'cliente') {
        $redirectUrl = '../controlador/clienteLista.php';
        
        // Actualizar cliente
        if (isset($_POST['nit_ci'])) {
            $clienteData = [
                'nit_ci' => trim($_POST['nit_ci']),
                'razon_social' => trim($_POST['razon_social'] ?? ''),
                'tipo_cliente' => $_POST['tipo_cliente'] ?? 'PERSONA',
                'estado_cliente' => $_POST['estado_cliente'] ?? 'ACTIVO'
            ];
            
            // Obtener cliente existente
            $clienteResponse = $api->get("/cliente/usuario/{$id}");
            
            if ($clienteResponse['success'] && isset($clienteResponse['data'])) {
                $clienteData_Resp = $clienteResponse['data'];
                
                // Determinar el ID del cliente
                $clienteId = null;
                
                if (isset($clienteData_Resp['id'])) {
                    $clienteId = $clienteData_Resp['id'];
                } elseif (is_array($clienteData_Resp) && count($clienteData_Resp) > 0) {
                    $clienteId = $clienteData_Resp[0]['id'] ?? null;
                }
                
                if ($clienteId) {
                    // Actualizar cliente existente
                    $responseCliente = $api->put("/cliente/{$clienteId}", $clienteData);
                    
                    if (!$responseCliente['success']) {
                        $errorMsg = $responseCliente['error'] ?? $responseCliente['message'] ?? 'Error desconocido';
                        if (is_array($errorMsg)) {
                            $errorMsg = implode(', ', $errorMsg);
                        }
                        $mensajeExito = 'Usuario actualizado. Nota: ' . $errorMsg;
                    }
                } else {
                    $mensajeExito = 'Usuario actualizado. Nota: No se pudo obtener el ID del cliente.';
                }
            } else {
                // Crear nuevo cliente
                $clienteData['usuarioId'] = $id;
                $responseCliente = $api->post("/cliente", $clienteData);
                
                if (!$responseCliente['success']) {
                    $errorMsg = $responseCliente['error'] ?? $responseCliente['message'] ?? 'Error desconocido';
                    if (is_array($errorMsg)) {
                        $errorMsg = implode(', ', $errorMsg);
                    }
                    $mensajeExito = 'Usuario actualizado. Nota: ' . $errorMsg;
                }
            }
        }
    }
    
    // Redirigir siempre al actualizar usuario
    ?>
    <script>
        alert('<?= addslashes($mensajeExito) ?>');
        location.href = '<?= $redirectUrl ?>';
    </script>
    <?php
    exit();
    
} elseif (isset($_GET['id'])) {
    // Modo edición - cargar datos del usuario
    $id = intval($_GET['id']);
    $response = $api->get("/usuario/search/{$id}");
    
    if ($response['success']) {
        $usuarioEditar = $response['data'];
        
        // Determinar qué vista cargar según el tipo de usuario
        if ($usuarioEditar['tipo_usuario'] === 'empleado') {
            // Obtener lista de cargos activos
            $responseCargos = $api->get('/cargo/active');
            $cargos = $responseCargos['success'] ? $responseCargos['data'] : [];
            
            // Cargar vista de edición de empleado
            include("../vista/empleadoEditar.php");
            
        } elseif ($usuarioEditar['tipo_usuario'] === 'cliente') {
            // Cargar vista de edición de cliente
            include("../vista/clienteEditar.php");
            
        } else {
            // Por defecto, cargar vista de edición de usuario genérico
            include("../vista/usuarioEditar.php");
        }
    } else {
        ?>
        <script>
            alert('Usuario no encontrado');
            location.href = '../controlador/usuarioLista.php';
        </script>
        <?php
        exit();
    }
} else {
    // Sin ID proporcionado
    ?>
    <script>
        alert('Error: ID de usuario no proporcionado');
        location.href = '../controlador/usuarioLista.php';
    </script>
    <?php
    exit();
}
?>