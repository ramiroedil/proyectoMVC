<?php

class Session {
    private static $configured = false;
    private static function configure() {
        if (self::$configured) {
            return;
        }
        
        ini_set('session.gc_maxlifetime', 3600);        // 1 hora
        ini_set('session.cookie_lifetime', 3600);       // 1 hora
        ini_set('session.cookie_httponly', 1);          // Solo HTTP
        ini_set('session.use_only_cookies', 1);         // Solo cookies
        ini_set('session.cookie_secure', 0);            // 0=HTTP, 1=HTTPS
        ini_set('session.use_strict_mode', 1);          // Modo estricto
        ini_set('session.cookie_samesite', 'Lax');      // Protección CSRF
        
        self::$configured = true;
    }
    public static function start() {
        self::configure();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    public static function get($key, $default = null) {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }
    public static function delete($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
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
    public static function isAuthenticated() {
        return self::has('token') && self::has('usuario');
    }
    public static function hasRole($role) {
        if (!self::isAuthenticated()) {
            return false;
        }
        $usuario = self::get('usuario');
        return isset($usuario['tipousuario']) && $usuario['tipousuario'] === $role;
    }
    public static function getUser() {
        return self::get('usuario');
    }
}

?>