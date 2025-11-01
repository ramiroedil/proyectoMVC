<?php
include("../modelo/cargoClase.php");
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $cargo = new Cargo($id,"");
    $r= $cargo->eliCargo($id);
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
?>