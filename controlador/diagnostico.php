<?php
/**
 * DIAGNÓSTICO: ¿Por qué falla la lista?
 * 
 * UBICACIÓN: /controlador/diagnostico_lista.php
 * ACCESO: http://localhost/ProyectoMVC/controlador/diagnostico_lista.php
 */

require_once(__DIR__ . '/../modelo/ApiClient.php');

echo "<h1>🔍 DIAGNÓSTICO DE LISTA DE PROVEEDORES</h1>";
echo "<hr>";

$api = new ApiClient();

// === PASO 1: VERIFICAR API ACTIVE ===
echo "<h2>1. Obtener proveedores ACTIVOS</h2>";
echo "<p>Ruta: <code>GET /proveedor/active</code></p>";

$response_active = $api->get('/proveedor/active');

echo "<h3>Respuesta:</h3>";
echo "<pre>";
var_dump($response_active);
echo "</pre>";

if ($response_active['success']) {
    echo "✅ Ruta /proveedor/active funciona<br>";
    $proveedores = $response_active['data'];
    echo "📊 Cantidad de proveedores: " . count($proveedores) . "<br>";
    
    if (count($proveedores) > 0) {
        echo "<h3>Primeros proveedores:</h3>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><td>ID</td><td>Empresa</td><td>Email</td><td>Teléfono</td></tr>";
        
        $contador = 0;
        foreach ($proveedores as $p) {
            if ($contador >= 5) break;
            echo "<tr>";
            echo "<td>" . $p['id'] . "</td>";
            echo "<td>" . $p['empresa'] . "</td>";
            echo "<td>" . ($p['email'] ?? 'N/A') . "</td>";
            echo "<td>" . ($p['telefono'] ?? 'N/A') . "</td>";
            echo "</tr>";
            $contador++;
        }
        echo "</table>";
    } else {
        echo "⚠️ No hay proveedores activos";
    }
} else {
    echo "❌ Error: " . $response_active['error'] . "<br>";
}

// === PASO 2: INTENTAR RUTA GET /proveedor ===
echo "<h2>2. Obtener TODOS los proveedores</h2>";
echo "<p>Ruta: <code>GET /proveedor</code></p>";

$response_all = $api->get('/proveedor');

echo "<h3>Respuesta:</h3>";
echo "<pre>";
var_dump($response_all);
echo "</pre>";

if ($response_all['success']) {
    echo "✅ Ruta /proveedor funciona<br>";
    echo "📊 Cantidad: " . count($response_all['data']) . "<br>";
} else {
    echo "❌ Error: " . $response_all['error'] . "<br>";
}

// === PASO 3: VERIFICAR CONFIG ===
echo "<h2>3. Verificar Configuración</h2>";

if (defined('API_BASE_URL')) {
    echo "✅ API_BASE_URL definido: <code>" . API_BASE_URL . "</code><br>";
} else {
    echo "❌ API_BASE_URL NO está definido<br>";
}

if (defined('API_TIMEOUT')) {
    echo "✅ API_TIMEOUT definido: <code>" . API_TIMEOUT . "</code> segundos<br>";
} else {
    echo "❌ API_TIMEOUT NO está definido<br>";
}

// === PASO 4: PROBAR CONEXIÓN DIRECTA ===
echo "<h2>4. Prueba CURL Directa</h2>";

$url = (defined('API_BASE_URL') ? API_BASE_URL : 'http://localhost:3000/api/v1') . '/proveedor/active';
echo "<p>URL: <code>$url</code></p>";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);

$response_curl = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

echo "<p>HTTP Code: <strong>$http_code</strong></p>";

if ($curl_error) {
    echo "❌ Error CURL: <code>$curl_error</code><br>";
} else {
    echo "✅ Conexión exitosa<br>";
}

echo "<h3>Respuesta raw:</h3>";
echo "<pre>";
echo htmlspecialchars($response_curl);
echo "</pre>";

// === RESUMEN ===
echo "<hr>";
echo "<h2>📋 RESUMEN</h2>";
echo "<ul>";
echo "<li>" . ($response_active['success'] ? "✅" : "❌") . " GET /proveedor/active</li>";
echo "<li>" . ($response_all['success'] ? "✅" : "❌") . " GET /proveedor</li>";
echo "<li>" . ($http_code === 200 ? "✅" : "❌") . " Conexión CURL (HTTP $http_code)</li>";
echo "</ul>";

echo "<hr>";
echo "<a href='proveedorLista.php'>Volver a Lista</a>";
?>