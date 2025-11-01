<?php
include("../vista/cargoRegistrov.php");
if(isset($_POST['registrarCargo'])){
    $cargo=$_POST['cargo'];
    include ("../modelo/cargoClase.php");
    $cliente=new Cargo("",$cargo);
    $re=$cliente->grabarCargo();
    if($re){
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
?>