<?php
include_once("conexion.php");
class Usuario
{
    private $id;
    private $nombre;
    private $apellidoPaterno;
    private $apellidoMaterno;
    private $ci;
    private $usuario;
    private $password;
    private $fechaNacimiento;
    private $tipoUsuario;
    private $email;
    private $idUsuarioRef;
    private $estado;
    public function __construct($id, $nombre, $apellidoPaterno, $apellidoMaterno, $ci, $usuario, $password, $fechaNacimiento, $tipoUsuario, $email, $idUsuarioRef, $estado)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setApellidoPaterno($apellidoPaterno);
        $this->setApellidoMaterno($apellidoMaterno);
        $this->setCi($ci);
        $this->setUsuario($usuario);
        $this->setPassword($password);
        $this->setFechaNacimiento($fechaNacimiento);
        $this->setTipoUsuario($tipoUsuario);
        $this->setEmail($email);
        $this->setIdUsuarioRef($idUsuarioRef);
        $this->setEstado($estado);
    }
    public static function existeNombreUsuario($nombreUsuario)
    {
        $conexion = new Conexion();
        $sql = "SELECT COUNT(*) FROM usuarios WHERE nombreusuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $stmt->bind_result($cantidad);
        $stmt->fetch();
        $stmt->close();
        return $cantidad > 0;
    }


    public function registrarAdministrador()
    {
        $db = new Conexion();
        $sql = $db->query("INSERT INTO usuarios (nombre, paterno, materno, ci, nombreusuario, pasword, fecha, tipousuario, email, id_usuario, estado) 
        VALUES (
        '$this->nombre',
        '$this->apellidoPaterno',
        '$this->apellidoMaterno',
        '$this->ci',
        '$this->usuario',
        '$this->password',
        '$this->fechaNacimiento',
        '$this->tipoUsuario',
        '$this->email',
        '$this->idUsuarioRef',
        '$this->estado'
        )");
        return $sql;
    }
    public function lista()
    {
        $db = new Conexion();
        $sql = $db->query("SELECT id_usuario, nombre, paterno, materno, ci, nombreusuario, fecha, tipousuario, email, estado 
                FROM usuarios 
                ORDER BY paterno ASC");
        return $sql;
    }

    public function elimUsuario()
    {
        #include("conexion.php");
        $dbc = new Conexion();
        $eli = $dbc->query("DELETE FROM usuarios where id_usuario='$this->idUsuarioRef'");
        return ($eli);
    }


    //   public function editUsuario()
//   {
//     $dbc = new Conexion();
//     $mod = $dbc->query("UPDATE usuarios SET usuario='$this->usuario', password='$this->password', nivel='$this->nivel', estado='$this->estado', id_empleado='$this->idEmpleado' where id_usuario='$this->id'");
//     return ($mod);
//   }
//   public function obtenerUsuario()
//   {
//     $db = new Conexion();
//     $sql = $db->query("SELECT u.id_usuario, u.password, u.usuario, u.nivel, u.id_empleado, e.nombre, e.paterno, e.materno, u.estado
//     FROM usuarios u INNER JOIN empleado e ON u.id_empleado = e.id_empleado WHERE u.id_usuario='$this->id'");
//     return ($sql);
//   }
//   public function buscarUsuario()
//   {
//     $db = new Conexion();
//     $sql = $db->query("SELECT u.id_usuario, u.usuario, u.nivel, e.nombre, e.paterno, e.materno, c.cargo, u.estado 
//                     FROM usuarios u INNER JOIN empleado e ON u.id_empleado = e.id_empleado
//                     INNER JOIN cargo c ON e.id_cargo = c.id_cargo WHERE u.usuario LIKE '$this->usuario%'");
//     return $sql;
//   }
    public function actualizarPassword($nuevaPassword)
    {
        $db = new Conexion();
        // Encriptar la contraseña (recomendado)
        $passwordHash = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        $sql = $db->prepare("UPDATE usuarios SET pasword = ? WHERE id_usuario = ?");
        $sql->bind_param("si", $passwordHash, $this->id);
        $resultado = $sql->execute();
        $sql->close();

        return $resultado;
    }public function editarUsuario()
{
    $db = new Conexion();
    $sql = "UPDATE usuarios SET 
            nombre = '$this->nombre',
            paterno = '$this->apellidoPaterno',
            materno = '$this->apellidoMaterno',
            ci = '$this->ci',
            nombreusuario = '$this->usuario',
            fecha = '$this->fechaNacimiento',
            tipousuario = '$this->tipoUsuario',
            email = '$this->email',
            estado = '$this->estado'
        WHERE id_usuario = '$this->idUsuarioRef'";
    return $db->query($sql);
}
public function obtenerUsuario() {
    $db = new Conexion();
    $id = $this->idUsuarioRef;
    $sql = $db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    if (!$sql) {
        die("Error en preparación de consulta: " . $db->error);
    }
    $sql->bind_param("i", $id);
    $sql->execute();
    $resultado = $sql->get_result();
    $sql->close();
    return $resultado;
}
public function actualizarEstado($id, $nuevoEstado) {
    $con = new Conexion();
    $sql = "UPDATE usuarios SET estado = ? WHERE id_usuario = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $nuevoEstado, $id);
    return $stmt->execute();
}

    // Métodos setters y getters

    public function setId($dato)
    {
        $this->id = $dato;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setNombre($dato)
    {
        $this->nombre = $dato;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setApellidoPaterno($dato)
    {
        $this->apellidoPaterno = $dato;
    }
    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    public function setApellidoMaterno($dato)
    {
        $this->apellidoMaterno = $dato;
    }
    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    public function setCi($dato)
    {
        $this->ci = $dato;
    }
    public function getCi()
    {
        return $this->ci;
    }

    public function setUsuario($dato)
    {
        $this->usuario = $dato;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setPassword($dato)
    {
        $this->password = $dato;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setFechaNacimiento($dato)
    {
        $this->fechaNacimiento = $dato;
    }
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setTipoUsuario($dato)
    {
        $this->tipoUsuario = $dato;
    }
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }

    public function setEmail($dato)
    {
        $this->email = $dato;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setIdUsuarioRef($dato)
    {
        $this->idUsuarioRef = $dato;
    }
    public function getIdUsuarioRef()
    {
        return $this->idUsuarioRef;
    }

    public function setEstado($dato)
    {
        $this->estado = $dato;
    }
    public function getEstado()
    {
        return $this->estado;
    }
}
class Administrador extends Usuario
{

}
class Cliente extends Usuario
{

}
class Cajero extends Usuario
{

}

?>