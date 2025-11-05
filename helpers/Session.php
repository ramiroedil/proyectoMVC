<?php
/**
 * =====================================================
 * CLASE SESSION - MANEJO CENTRALIZADO DE SESIONES
 * =====================================================
 * 
 * ✅ AQUÍ se configura y maneja todo sobre sesiones
 * ✅ config.php NO toca sesiones
 * 
 * Autor: Edil Rosales
 */

class Session {
    
    /**
     * Flag para evitar configurar dos veces
     */
    private static $configured = false;
    
    /**
     * Configurar sesión (se ejecuta solo una vez)
     */
    private static function configure() {
        // ⚠️ IMPORTANTE: Estos ini_set() deben estar ANTES de session_start()
        // y solo se ejecutan una vez
        if (self::$configured) {
            return;
        }
        
        // Configuración de sesión
        ini_set('session.gc_maxlifetime', 3600);        // 1 hora
        ini_set('session.cookie_lifetime', 3600);       // 1 hora
        ini_set('session.cookie_httponly', 1);          // Solo HTTP
        ini_set('session.use_only_cookies', 1);         // Solo cookies
        ini_set('session.cookie_secure', 0);            // 0=HTTP, 1=HTTPS
        ini_set('session.use_strict_mode', 1);          // Modo estricto
        ini_set('session.cookie_samesite', 'Lax');      // Protección CSRF
        
        self::$configured = true;
    }
    
    /**
     * Iniciar sesión
     * ✅ Se configura primero, luego se inicia
     */
    public static function start() {
        // Primero: Configurar (antes de session_start)
        self::configure();
        
        // Segundo: Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Establecer valor en sesión
     */
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Obtener valor de sesión
     */
    public static function get($key, $default = null) {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Verificar si existe una clave
     */
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Eliminar una clave específica
     */
    public static function delete($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destruir toda la sesión
     */
    public static function destroy() {
        self::start();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Verificar si el usuario está autenticado
     */
    public static function isAuthenticated() {
        return self::has('token') && self::has('usuario');
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public static function hasRole($role) {
        if (!self::isAuthenticated()) {
            return false;
        }
        $usuario = self::get('usuario');
        return isset($usuario['tipousuario']) && $usuario['tipousuario'] === $role;
    }

    /**
     * Obtener datos del usuario actual
     */
    public static function getUser() {
        return self::get('usuario');
    }
}

?>