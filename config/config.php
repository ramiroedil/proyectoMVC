<?php
// Configuración del sistema
define('API_BASE_URL', 'http://localhost:3000');
define('API_TIMEOUT', 30);

// Configuración de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en producción con HTTPS

// Zona horaria
date_default_timezone_set('America/La_Paz');

// Manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1); // Cambiar a 0 en producción
?>