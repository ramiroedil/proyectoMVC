<?php
/**
 * =====================================================
 * CONFIGURACIÓN GLOBAL - PROYECTO TIENDA DE JUGUETES
 * =====================================================
 * 
 * ✅ Las sesiones se manejan en: Session.php
 * ✅ Este archivo solo contiene configuración global
 * 
 * Autor: Edil Rosales
 * ICSNBOLIVIA - La Paz, Bolivia
 */

// =========================================================
// 1️⃣ RUTAS Y URLs
// =========================================================

define('API_BASE_URL', 'http://localhost:3000');
define('API_TIMEOUT', 30);
define('BASE_URL', 'http://localhost/ProyectoMVC/');
define('UPLOAD_DIR', 'uploads/productos/');

// =========================================================
// 2️⃣ BASE DE DATOS
// =========================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tienda_juguetes');

// =========================================================
// 3️⃣ ZONA HORARIA
// =========================================================

date_default_timezone_set('America/La_Paz');

// =========================================================
// 4️⃣ MANEJO DE ERRORES
// =========================================================

error_reporting(E_ALL);
ini_set('display_errors', 1);  // Cambiar a 0 en PRODUCCIÓN

// =========================================================
// 5️⃣ HEADERS DE SEGURIDAD
// =========================================================

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

?>