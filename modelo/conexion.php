<?php
// Verificar si la clase ya existe antes de declararla
if (!class_exists('Conexion')) {
    class Conexion extends mysqli 
    {
        public function __construct()
        {
            parent::__construct("localhost", "root", "", "proyecto_mvc");
            
            // Opcional: Verificar la conexión
            if ($this->connect_error) {
                die("Error de conexión: " . $this->connect_error);
            }
            
            // Opcional: Establecer charset UTF-8
            $this->set_charset("utf8");
        }
    }
}
?>