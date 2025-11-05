<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

if (isset($_POST['user']) && isset($_POST['pasw'])) {
    $username = trim($_POST['user']);
    $password = trim($_POST['pasw']);

    if (empty($username) || empty($password)) {
        header("Location: ../inicio_sesion.php?sw=4");
        exit();
    }

    $api = new ApiClient();
    $response = $api->post('/usuario/validate', [
        'username' => $username,
        'password' => $password  // ← Se envía en texto plano (CORRECTO)
    ]);

    if ($response['success']) {
    $data = $response['data']['data']; // <- agregar otro 'data'
    
    Session::set('token', $data['token']);
    
     Session::set('usuario', [
            'id_usuario' => $data['user']['id'],
            'nombreusuario' => $data['user']['username'],
            'nombre' => $data['user']['nombre'],
            'apellido_paterno' => $data['user']['apellido_paterno'] ?? '',
            'email' => $data['user']['email'],
            'tipousuario' => $data['user']['tipo_usuario'], // 'empleado' o 'cliente'
            'estado' => $data['user']['estado'], // 'activo' o 'inactivo'
            'cargo' => $data['user']['cargo'] ?? null, // Solo para empleados
            'permisos' => $data['user']['permisos'] ?? [] // Array de permisos
        ]);
                
    
    header("Location: ../inicio.php");
    exit();
}
 else {
        header("Location: ../inicio_sesion.php?sw=1");
        exit();
    }
} else {
    header("Location: ../inicio_sesion.php?sw=4");
    exit();
}
?>