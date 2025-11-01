<?php
if(isset($_GET['id'])){
$cid = $_GET['id'];
include("../modelo/cargoClase.php");
$car=new Cargo($cid,"");
$r1=$car->obtenerCargo();
$r=mysqli_fetch_array($r1);
include ("../vista/cargoEditar.php");
if(isset($_GET['act'])){
    $car=$_GET['cargo'];
    $car=new Cargo($cid,$car);
    $r=$car->ediCargo();
    if($r){
        ?>
        
        <script type="text/javascript">
            alert("Cliente registrado con exito");
            location.href = '../controlador/cargoLista.php';
            </script>
            <?php
            }else{
                ?>
                <script type="text/javascript">
                    
            alert("Cliente NO registrado con exito");
            </script>
            <?php
            }
        }
    }
?>