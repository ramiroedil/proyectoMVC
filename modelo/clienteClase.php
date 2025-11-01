<?php
class clientes
{
    private $idcliente;
    private $razonsocial;
    private $ci;
    private $estado;
    public function __construct($idcliente, $razonsocial, $ci, $estado)
    {
        $this->setIdcliente($idcliente);
        $this->setrazon($razonsocial);
        $this->setci($ci);
        $this->setestado($estado);

    }
    public function grabarCliente()
    {
        include("conexion.php");
        $db = new Conexion();
        if (
            $db->query("INSERT INTO cliente (razonsocial, nit_ci, estado) 
                VALUES ('$this->razonsocial', '$this->ci', '$this->estado')")
        ) {
            return true;
        } else {
            return false;
        }
    }
    public function lista()
    {
        include("conexion.php");
        $db = new Conexion();
        $sql = $db->query("SELECT * FROM cliente where estado='activo'");
        return ($sql);
    }
    public function buscarCliente($n)
    {
        include_once("conexion.php");
        $db = new Conexion();
        $sql = $db->query("SELECT * FROM cliente where razonsocial like '$n%'");
        return $sql;
    }
    public function buscarPorCINIT($ci_nit)
    {
        include_once("conexion.php");
        $db = new Conexion();
        $sql = $db->query("SELECT * FROM cliente 
                      WHERE nit_ci = '$ci_nit' 
                      AND estado='activo'");
        return $sql;
    }
    public function inactivos()
    {
        include("conexion.php");
        $db = new Conexion();
        $sql = $db->query("SELECT * FROM cliente where estado='Inactivo'");
        return ($sql);
    }
    public function inactivo()
    {
        include("conexion.php");
        $db = new Conexion();
        $sql = $db->query("UPDATE cliente SET estado='Inactivo' WHERE id_cliente='$this->idcliente'");
        return ($sql);
    }
    public function activo()
    {
        include("conexion.php");
        $db = new Conexion();
        $sql = $db->query("UPDATE cliente SET estado='Activo' WHERE id_cliente='$this->idcliente'");
        return ($sql);
    }
    public function eliminarCliente($id)
    {
        include("conexion.php");
        $db = new Conexion();
        $sql = $db->query("DELETE FROM cliente WHERE id_cliente =$this->idcliente");
        return ($sql);
    }
    public function editarCliente()
    {
        include("conexion.php");
        $db = new Conexion();
        $sql = $db->query("UPDATE cliente SET razonsocial='$razonsocial', nit_ci='$ci', estado='$estado' WHERE id_cliente='$this->idcliente'");
        return ($sql);
    }
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }
    public function getIdcliente()
    {
        return $this->idcliente;
    }
    public function setrazon($razonsocial)
    {
        $this->razonsocial = $razonsocial;
    }

    public function getrazon()
    {
        return $this->razonsocial;
    }
    public function setci($ci)
    {
        $this->ci = $ci;
    }
    public function getci()
    {
        return $this->ci;
    }
    public function setestado($estado)
    {
        $this->estado = $estado;
    }
    public function getestado()
    {
        return $this->estado;
    }

}
?>