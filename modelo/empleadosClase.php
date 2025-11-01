<?php
class Empleado {
    private $id_empleado;
    private $id_cargo;
    private $ci;
    private $nombre;
    private $paterno;
    private $materno;
    private $direccion;
    private $telefono;
    private $fechanacimiento;
    private $genero;
    private $intereses;
    public function __construct($id_empleado, $id_cargo, $ci, $nombre, $paterno, $materno, $direccion, $telefono, $fechanacimiento, $genero, $intereses) {
        $this->setIdEmpleado($id_empleado);
        $this->setIdCargo($id_cargo);
        $this->setCi($ci);
        $this->setNombre($nombre);
        $this->setPaterno($paterno);
        $this->setMaterno($materno);
        $this->setDireccion($direccion);
        $this->setTelefono($telefono);
        $this->setFechanacimiento($fechanacimiento);
        $this->setGenero($genero);
        $this->setIntereses($intereses);
    }
    public function grabarEmpleado() {
    $db = new Conexion();
    $gemp = $db->query("INSERT INTO empleado (id_cargo, ci, nombre, paterno, materno, direccion, telefono, fechanacimiento, genero, intereses) values ('$this->id_cargo', '$this->ci', '$this->nombre', '$this->paterno', '$this->materno', '$this->direccion', '$this->telefono', '$this->fechanacimiento', '$this->genero', '$this->intereses')");
    return ($gemp);
  }

    public function lista() {
        include("conexion.php");
        $db = new Conexion();
        $sql = $db->query("SELECT e.*,c.cargo FROM empleado e INNER JOIN cargo c ON c.id_cargo=e.id_cargo ORDER BY E.NOMBRE ASC");
        return ($sql);
    }
    public function editEmpleado()
    {
      $dbc = new Conexion();
      $mod = $dbc->query("UPDATE empleado SET id_cargo='$this->id_cargo', ci='$this->ci', nombre='$this->nombre', paterno='$this->paterno', materno='$this->materno', direccion='$this->direccion', telefono='$this->telefono', fechanacimiento='$this->fechanacimiento', genero='$this->genero', intereses='$this->intereses' where id_empleado='$this->id_empleado'");
      return ($mod);
    }
    public function elimEmpleado()
    {
      #include("conexion.php");
      $dbc = new Conexion();
      $eli = $dbc->query("DELETE FROM empleado where id_empleado='$this->id_empleado'");
      return ($eli);
    }
    public function obtenerEmpleado()
    {
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM empleado WHERE id_empleado='$this->id_empleado'");
      return ($sql);
    }
    public function buscarEmpleado()
    {
      #include("conexion.php");
      $db = new Conexion();
      $sql = $db->query("SELECT e.*, c.cargo FROM empleado e INNER JOIN cargo c ON c.id_cargo = e.id_cargo WHERE e.nombre LIKE '$this->nombre%'");
      return $sql;
    }
    public function setIdEmpleado($id_empleado) {
        $this->id_empleado = $id_empleado;
    }

    public function getIdEmpleado() {
        return $this->id_empleado;
    }

    public function setIdCargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    public function getIdCargo() {
        return $this->id_cargo;
    }

    public function setCi($ci) {
        $this->ci = $ci;
    }

    public function getCi() {
        return $this->ci;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setPaterno($paterno) {
        $this->paterno = $paterno;
    }

    public function getPaterno() {
        return $this->paterno;
    }

    public function setMaterno($materno) {
        $this->materno = $materno;
    }

    public function getMaterno() {
        return $this->materno;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setFechanacimiento($fechanacimiento) {
        $this->fechanacimiento = $fechanacimiento;
    }

    public function getFechanacimiento() {
        return $this->fechanacimiento;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function setIntereses($intereses) {
        $this->intereses = $intereses;
    }

    public function getIntereses() {
        return $this->intereses;
    }
}
?>

