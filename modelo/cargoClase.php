
<?php
class Cargo{
    private $id;
    private $cargo;
    public function __construct($id,$cargo){
        $this->setId($id);
        $this->setCargo($cargo);
    }
    
    public function grabarCargo() {
        include_once("conexion.php");
        $db = new Conexion();
        if($db->query( "INSERT INTO cargo (cargo) 
                VALUES ('$this->cargo')")){
                return true;
                }else{
                    return false;
                }
            
    }
    public function buscarCargo($n){
        include_once("conexion.php");
        $db=new Conexion();
        $sql=$db->query("SELECT * FROM cargo where cargo like '$n%'");
        return $sql;
    }
   
    public function lista(){
        include_once("conexion.php");
        $db=new Conexion();
        $sql=$db->query("SELECT * FROM cargo");
        return ($sql);
    }
    public function eliCargo($id){
    include_once("conexion.php");
    $db = new Conexion();
    $sql=$db->query( "DELETE FROM cargo WHERE id_cargo =$this->id");
        return $sql;
    }
    public function ediCargo() {
    include_once("conexion.php");
    $db = new Conexion();
    $sql = $db->query("UPDATE cargo SET cargo ='$this->cargo' WHERE id_cargo = '$this->id'");
    return $sql;
}
public function obtenerCargo() {
    include_once("conexion.php");
    $db = new Conexion();
    $sql=$db->query("SELECT * from cargo WHERE id_cargo=$this->id");
    return $sql;
}

    public function setId($id){
        $this->id=$id;
    }
    
    public function getId(){
        return $this->id;
    }
    public function setCargo($cargo){
        $this->cargo=$cargo;
    }
        
    public function getCargo(){
        return $this->cargo;
    }
    
}
?>

