<?php
include_once("conexion.php");
class Proveedor
{
  #`id_proveedor`, `empresa`, `contacto`, `mail`, `telefono`, `direccion`, `logo`
  private $id;
  private $empresa;
  private $contacto;
  private $mail;
  private $telefono;
  private $direccion;
  private $logo;
  public function __construct($id, $empresa, $contacto, $mail, $telefono, $direccion, $logo)
  {
    $this->setId($id);
    $this->setEmpresa($empresa);
    $this->setContacto($contacto);
    $this->setMail($mail);
    $this->setTelefono($telefono);
    $this->setDireccion($direccion);
    $this->setLogo($logo);
  }
  public function grabarProveedor()
  {
    #include("conexion.php");
    $db = new Conexion();
    $sql = $db->query("INSERT INTO proveedor (empresa, contacto, mail, telefono, direccion, logo) values ('$this->empresa', '$this->contacto', '$this->mail', '$this->telefono', '$this->direccion', '$this->logo')");
    return ($sql);
  }
  public function ediProveedor()
  {
    #include("conexion.php");
    $dbc = new Conexion();
    $mod = $dbc->query("UPDATE proveedor SET empresa='$this->empresa', contacto='$this->contacto', mail='$this->mail', telefono='$this->telefono', direccion='$this->direccion', logo='$this->logo'where id_proveedor='$this->id'");
    return ($mod);
  }
  public function elimProveedor()
  {
    ##include("conexion.php");
    $dbc = new Conexion();
    $eli = $dbc->query("DELETE FROM proveedor where id_proveedor='$this->id'");
    return ($eli);
  }
  public function obtenerProveedor()
  {
    #include("conexion.php");
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM proveedor WHERE id_proveedor='$this->id'");
    return ($sql);
  }
  public function buscarProveedor()
  {
    #include("conexion.php");
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM proveedor  WHERE empresa LIKE '$this->empresa%'");
    return $sql;
  }
  public function lista()
  {
    #include("conexion.php");
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM proveedor");
    return ($sql);
  }
  public function setId($dato)
  {
    $this->id = $dato;
  }
  public function getId()
  {
    return $this->id;
  }
  public function setEmpresa($dato)
  {
    $this->empresa = $dato;
  }
  public function getEmpresa()
  {
    return $this->empresa;
  }
  public function setContacto($dato)
  {
    $this->contacto = $dato;
  }
  public function getContacto()
  {
    return $this->contacto;
  }
  public function setMail($dato)
  {
    $this->mail = $dato;
  }
  public function getMail()
  {
    return $this->mail;
  }
  public function setTelefono($dato)
  {
    $this->telefono = $dato;
  }
  public function getTelefono()
  {
    return $this->telefono;
  }

  public function setDireccion($dato)
  {
    $this->direccion = $dato;
  }
  public function getDireccion()
  {
    return $this->direccion;
  }
  public function setLogo($dato)
  {
    $this->logo = $dato;
  }
  public function getLogo()
  {
    return $this->logo;
  }
}