<?php

define('API_BASE_URL', 'http://localhost:3000');
define('API_TIMEOUT', 30);
define('BASE_URL', 'http://localhost/ProyectoMVC/');

// ✅ CORREGIDO: Usar el API_BASE_URL para las imágenes
define('IMAGE_URL', API_BASE_URL . '/uploads/');
define('IMAGE_DEFAULT', API_BASE_URL . '/uploads/default-product.jpg');

// Base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'jugue_db');

// Configuración general
date_default_timezone_set('America/La_Paz');

// Errores (cambiar a 0 en PRODUCCIÓN)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers de seguridad
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

?>