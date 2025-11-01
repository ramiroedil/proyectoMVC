<?php
include_once("conexion.php");
class Producto
{
  private $id;
  private $IdProveedor;
  private $nombrep;
  private $descripcion;
  private $estado;
  private $precio;
  private $stock;
  private $tipo;
  private $imagen; // Cambiado de 'foto' a 'imagen'

  public function __construct($id, $IdProveedor, $nombrep, $descripcion, $estado, $precio, $stock, $tipo, $imagen)
  {
    $this->setId($id);
    $this->setIdProveedor($IdProveedor);
    $this->setNombreP($nombrep);
    $this->setDescripcion($descripcion);
    $this->setEstado($estado);
    $this->setPrecio($precio);
    $this->setStock($stock);
    $this->setTipo($tipo);
    $this->setImagen($imagen); // Cambiado de setFoto a setImagen
  }

  public function grabarProducto()
  {
    $db = new Conexion();
    $sql = $db->query("INSERT INTO producto 
      (id_proveedor, nombreproducto, descripcion, estado, precio, stock, tipo, imagen) 
      VALUES 
      ('$this->IdProveedor', '$this->nombrep', '$this->descripcion', '$this->estado', '$this->precio', '$this->stock', '$this->tipo', '$this->imagen')");
    return $sql;
  }

  public function editProducto()
  {
    $db = new Conexion();
    $sql = $db->query("UPDATE producto SET 
      id_proveedor = '$this->IdProveedor', 
      nombreproducto = '$this->nombrep', 
      descripcion = '$this->descripcion', 
      estado = '$this->estado', 
      precio = '$this->precio', 
      stock = '$this->stock', 
      tipo = '$this->tipo', 
      imagen = '$this->imagen' 
      WHERE id = '$this->id'"); // Cambiado de 'id_producto' a 'id'
    return $sql;
  }

  public function elimProducto()
  {
    $db = new Conexion();
    $sql = $db->query("DELETE FROM producto WHERE id = '$this->id'"); // Cambiado de 'id_producto' a 'id'
    return $sql;
  }

  public function obtenerProducto()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM producto WHERE id = '$this->id'"); // Cambiado de 'id_producto' a 'id'
    return $sql;
  }

  public function buscarProducto()
  {
    $db = new Conexion();
    $sql = $db->query("SELECT p.*, pr.empresa 
      FROM producto p 
      INNER JOIN proveedor pr ON pr.id_proveedor = p.id_proveedor 
      WHERE p.nombreproducto LIKE '$this->nombrep%'");
    return $sql;
  }

  public function lista(){
    $db = new Conexion();
    $sql = $db->query("SELECT p.*, pr.empresa 
      FROM producto p 
      INNER JOIN proveedor pr ON pr.id_proveedor = p.id_proveedor 
      ORDER BY p.nombreproducto ASC");
    return $sql;
  }

  public function mujer(){
    $db = new Conexion();
    $sql = $db->query("SELECT p.*, pr.empresa 
      FROM producto p 
      INNER JOIN proveedor pr ON pr.id_proveedor = p.id_proveedor 
      WHERE p.tipo = 'mujer'
      ORDER BY p.nombreproducto ASC");
    return $sql;
  }

  public function hombre(){
    $db = new Conexion();
    $sql = $db->query("SELECT p.*, pr.empresa
    FROM producto p
    INNER JOIN proveedor pr ON pr.id_proveedor = p.id_proveedor
    WHERE p.tipo = 'varon'
    ORDER BY p.nombreproducto ASC");
    return $sql;
  }

  // Getters y Setters
  public function setId($id) { $this->id = $id; }
  public function getId() { return $this->id; }

  public function setIdProveedor($dato) { $this->IdProveedor = $dato; }
  public function getIdProveedor() { return $this->IdProveedor; }

  public function setNombreP($dato) { $this->nombrep = $dato; }
  public function getNombreP() { return $this->nombrep; }

  public function setDescripcion($dato) { $this->descripcion = $dato; }
  public function getDescripcion() { return $this->descripcion; }

  public function setEstado($dato) { $this->estado = $dato; }
  public function getEstado() { return $this->estado; }

  public function setPrecio($dato) { $this->precio = $dato; }
  public function getPrecio() { return $this->precio; }

  public function setStock($dato) { $this->stock = $dato; }
  public function getStock() { return $this->stock; }

  public function setTipo($dato) { $this->tipo = $dato; }
  public function getTipo() { return $this->tipo; }

  public function setImagen($dato) { $this->imagen = $dato; } // Cambiado de setFoto
  public function getImagen() { return $this->imagen; } // Cambiado de getFoto
}
?>