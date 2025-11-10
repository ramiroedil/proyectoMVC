<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

// Variables
$error_message = '';
$success_message = '';

// Procesar formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    // Obtener datos del formulario
    $empresa = trim($_POST['empresa'] ?? '');
    $nit = trim($_POST['nit'] ?? '');
    $contacto_nombre = trim($_POST['contacto_nombre'] ?? '');
    $contacto_cargo = trim($_POST['contacto_cargo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $ciudad = trim($_POST['ciudad'] ?? '');
    $pais = trim($_POST['pais'] ?? 'Bolivia');
    $sitio_web = trim($_POST['sitio_web'] ?? '');
    
    // Validaciones
    $errores = [];
    
    if (empty($empresa)) {
        $errores[] = 'El nombre de la empresa es requerido';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El email es requerido y debe ser válido';
    }
    if (empty($telefono)) {
        $errores[] = 'El teléfono es requerido';
    }
    if (empty($direccion)) {
        $errores[] = 'La dirección es requerida';
    }
    
    if (!empty($errores)) {
        $error_message = implode('<br>', $errores);
    } else {
        // Preparar datos para la API
        $data = [
            'empresa' => $empresa,
            'email' => $email,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'pais' => $pais
        ];
        
        // Agregar campos opcionales
        if (!empty($nit)) {
            $data['nit'] = $nit;
        }
        if (!empty($contacto_nombre)) {
            $data['contacto_nombre'] = $contacto_nombre;
        }
        if (!empty($contacto_cargo)) {
            $data['contacto_cargo'] = $contacto_cargo;
        }
        if (!empty($ciudad)) {
            $data['ciudad'] = $ciudad;
        }
        if (!empty($sitio_web)) {
            $data['sitio_web'] = $sitio_web;
        }
        
        // Preparar archivos si existen
        $files = [];
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
            $files['logo'] = $_FILES['logo'];
        }
        
        // Enviar a la API
        $response = $api->post('/proveedor', $data, $files);
        
        if ($response['success']) {
            header('Location: proveedorLista.php?success=1');
            exit();
        } else {
            $error_message = $response['error'] ?? 'Error al registrar proveedor';
        }
    }
}

// Incluir vista
include(__DIR__ . '/../vista/proveedorRegistro.php');
?>