<?php



// ... resto del código

require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');
// DEBUG: Mostrar qué se está enviando al frontend
error_log('═══════════════════════════════════════════');
error_log('📥 PETICIÓN A controladorVenta.php');
error_log('Método: ' . $_SERVER['REQUEST_METHOD']);
error_log('URL: ' . $_SERVER['REQUEST_URI']);

// Si es AJAX/fetch
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    error_log('🔄 Es una petición AJAX');
    error_log('Body: ' . file_get_contents('php://input'));
}
error_log('═══════════════════════════════════════════');


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Si es preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
$api = new ApiClient();
$response = $api->get('/producto/active');

if ($response['success']) {
    $productos = $response['data'];
} else {
    $productos = [];
    $error_message = $response['error'];
}

include("../vista/registroVenta.php");
?>