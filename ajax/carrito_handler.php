<?php
session_start();
require_once(__DIR__ . '/../helpers/Session.php');
require_once(__DIR__ . '/../modelo/ApiClient.php');

header('Content-Type: application/json');

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$action = $_POST['action'] ?? null;

switch ($action) {
    case 'transferir_carrito_autenticado':
        // Transferir carrito público al carrito de compras autenticado
        if (!Session::isAuthenticated()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
            exit();
        }

        $carritoPublico = $_SESSION['carrito_publico'] ?? [];
        
        if (empty($carritoPublico)) {
            echo json_encode(['success' => false, 'message' => 'Carrito vacío']);
            exit();
        }

        // Transferir al carrito de ventas
        Session::set('carrito_ventas1', $carritoPublico);
        unset($_SESSION['carrito_publico']);

        echo json_encode([
            'success' => true,
            'message' => 'Carrito transferido correctamente',
            'redirect' => 'vista/carrito_ventas.php'
        ]);
        break;

    case 'limpiar_carrito_publico':
        // Limpiar carrito después de compra exitosa
        unset($_SESSION['carrito_publico']);
        $_SESSION['carrito_publico'] = [];
        
        echo json_encode([
            'success' => true,
            'message' => 'Carrito limpiado'
        ]);
        break;

    case 'validar_y_transferir':
        // Validar credenciales y transferir carrito
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $carritoPublico = $_POST['carrito'] ? json_decode($_POST['carrito'], true) : [];

        if (empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Credenciales incompletas']);
            exit();
        }

        try {
            $api = new ApiClient();
            $response = $api->post('/usuario/validate', [
                'username' => $username,
                'password' => $password
            ]);

            if ($response['success']) {
                $data = $response['data']['data'];
                
                // Guardar sesión
                Session::set('token', $data['token']);
                Session::set('usuario', [
                    'id_usuario' => $data['user']['id'],
                    'nombreusuario' => $data['user']['username'],
                    'nombre' => $data['user']['nombre'],
                    'apellido_paterno' => $data['user']['apellido_paterno'] ?? '',
                    'email' => $data['user']['email'],
                    'tipousuario' => $data['user']['tipo_usuario'],
                    'estado' => $data['user']['estado'],
                    'cargo' => $data['user']['cargo'] ?? null,
                    'permisos' => $data['user']['permisos'] ?? []
                ]);

                // Transferir carrito público
                if (!empty($carritoPublico)) {
                    Session::set('carrito_ventas1', $carritoPublico);
                }
                unset($_SESSION['carrito_publico']);

                echo json_encode([
                    'success' => true,
                    'message' => 'Sesión iniciada correctamente',
                    'tipo_usuario' => $data['user']['tipo_usuario'],
                    'redirect' => $data['user']['tipo_usuario'] === 'empleado' ? 'inicio.php' : 'inicio1.php'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error en la autenticación: ' . $e->getMessage()
            ]);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}
?>