
<?php
include("../modelo/conexion.php");
if(isset($_GET["Buscar"])){
    $id = $_GET["empleado"];
    include("../modelo/empleadosClase.php");
    $empleado = new Empleado("","","","","","","","","","","");
    $res= $empleado->buscarEmpleado();
    
include("../vista/empleadoBuscar.php");

}
?>