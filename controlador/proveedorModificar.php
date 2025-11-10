<?php
/**
 * CONTROLADOR: Modificación de Proveedor (CON LOGGING)
 * 
 * UBICACIÓN: /controlador/proveedorModificar.php
 */

require_once(__DIR__ . '/../modelo/ApiClient.php');

$api = new ApiClient();

// Variables iniciales
$error_message = '';
$success_message = '';
$r = [];
$id = 0;
$debug_logs = [];

// === PASO 1: VALIDAR ID ===
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $debug_logs[] = "[ERROR] No se recibió ID en GET";
    header('Location: proveedorLista.php?error=1');
    exit();
}

$id = intval($_GET['id']);
$debug_logs[] = "[GET] ID recibido: $id";

if ($id <= 0) {
    $debug_logs[] = "[ERROR] ID inválido";
    header('Location: proveedorLista.php?error=1');
    exit();
}

// === PASO 2: DETECTAR SI ES POST ===
$debug_logs[] = "[INFO] Método HTTP: " . $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $debug_logs[] = "[POST] Formulario recibido";
    
    // Verificar que existe el botón guardar
    if (!isset($_POST['guardar'])) {
        $debug_logs[] = "[ERROR] No se detectó POST['guardar']";
        $error_message = "Formulario incompleto";
    } else {
        $debug_logs[] = "[POST] Botón 'guardar' detectado ✓";
        
        // Capturar datos
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
        
        $debug_logs[] = "[POST] Datos capturados:";
        $debug_logs[] = "  - empresa: '$empresa'";
        $debug_logs[] = "  - email: '$email'";
        $debug_logs[] = "  - telefono: '$telefono'";
        $debug_logs[] = "  - direccion: '$direccion'";
        
        // === VALIDACIONES ===
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
            $debug_logs[] = "[VALIDACIÓN] Errores encontrados:";
            foreach ($errores as $err) {
                $debug_logs[] = "  - $err";
            }
        } else {
            $debug_logs[] = "[VALIDACIÓN] ✓ Todas las validaciones pasaron";
            
            // === PREPARAR DATOS PARA API ===
            $data = [
                'email' => $email,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'pais' => $pais
            ];
            
            // Enviar empresa SOLO si cambió
            if ($empresa !== ($r['empresa'] ?? '')) {
                $data['empresa'] = $empresa;
                $debug_logs[] = "[DATA] Empresa cambió, se incluirá en PUT";
            } else {
                $debug_logs[] = "[DATA] Empresa no cambió, NO se incluirá en PUT";
            }
            
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
            
            $debug_logs[] = "[DATA] Datos a enviar: " . json_encode($data);
            
            // === ENVIAR PUT A LA API ===
            $debug_logs[] = "[API] Enviando PUT a /proveedor/update/{$id}";
            $debug_logs[] = "[API] URL completa: " . (defined('API_BASE_URL') ? API_BASE_URL . "/proveedor/update/{$id}" : 'API_BASE_URL no definido');
            
            $response = $api->put("/proveedor/update/{$id}", $data);
            
            $debug_logs[] = "[API] Respuesta recibida:";
            $debug_logs[] = "[API] Success: " . ($response['success'] ? 'true' : 'false');
            if (isset($response['error'])) {
                $debug_logs[] = "[API] Error: " . $response['error'];
            }
            if (isset($response['data'])) {
                $debug_logs[] = "[API] Data: " . json_encode($response['data']);
            }
            
            if ($response['success']) {
                $debug_logs[] = "[SUCCESS] ✓ Proveedor actualizado correctamente";
                $success_message = '✅ Proveedor actualizado correctamente';
                
                // Actualizar datos
                if (isset($response['data'])) {
                    $r = $response['data'];
                }
            } else {
                $debug_logs[] = "[ERROR] ❌ No se pudo actualizar";
                $error_message = $response['error'] ?? 'Error al actualizar proveedor';
            }
        }
    }
}

// === OBTENER DATOS DEL PROVEEDOR (SI ES GET O SI NO TENEMOS DATOS) ===
if (empty($r)) {
    $debug_logs[] = "[GET] Obteniendo datos del proveedor ID=$id";
    $response_get = $api->get("/proveedor/search/{$id}");
    
    $debug_logs[] = "[GET] Respuesta: " . ($response_get['success'] ? 'OK' : 'ERROR');
    
    if (!$response_get['success']) {
        $debug_logs[] = "[ERROR] No se pudo obtener el proveedor";
        $debug_logs[] = "[ERROR] " . $response_get['error'];
        header('Location: proveedorLista.php?error=1');
        exit();
    }
    
    $r = $response_get['data'];
    $debug_logs[] = "[GET] Datos obtenidos: " . $r['empresa'];
}

// === INCLUIR VISTA ===
include(__DIR__ . '/../vista/proveedorModificar.php');

// === MOSTRAR LOGS ===
if (isset($_GET['debug']) || isset($_POST['debug'])) {
    echo "\n\n<!-- =========================================== -->";
    echo "\n<!-- DEBUG LOGS -->";
    echo "\n<!-- =========================================== -->\n";
    echo "<div style='background: #1a1a1a; color: #00ff00; padding: 15px; margin-top: 30px; font-family: monospace; font-size: 12px; border: 2px solid #00ff00; border-radius: 5px;'>";
    echo "<h3 style='color: #00ff00; margin-top: 0;'>🔍 DEBUG LOGS</h3>";
    
    foreach ($debug_logs as $log) {
        $color = '#00ff00'; // default green
        
        if (strpos($log, '[ERROR]') === 0) {
            $color = '#ff0000'; // red
        } elseif (strpos($log, '[WARNING]') === 0) {
            $color = '#ffaa00'; // orange
        } elseif (strpos($log, '[SUCCESS]') === 0) {
            $color = '#00ff00'; // green
        } elseif (strpos($log, '[API]') === 0) {
            $color = '#00aaff'; // blue
        } elseif (strpos($log, '[POST]') === 0) {
            $color = '#ffff00'; // yellow
        } elseif (strpos($log, '[INFO]') === 0) {
            $color = '#aaaaaa'; // gray
        }
        
        echo "<div style='color: $color; margin: 5px 0;'>" . htmlspecialchars($log) . "</div>";
    }
    
    echo "<hr style='border-color: #00ff00; margin-top: 15px;'>";
    echo "<div style='color: #aaaaaa; font-size: 11px; margin-top: 10px;'>";
    echo "📝 Para ver estos logs, agrega <code style='background: #333; padding: 2px 5px;'>&debug</code> a la URL<br>";
    echo "Ejemplo: <code style='background: #333; padding: 2px 5px;'>proveedorModificar.php?id=1&debug</code>";
    echo "</div>";
    echo "</div>";
}
?>