<?php
include("../modelo/clienteClase.php");
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $cargo = new clientes($id,"","","");
    $r= $cargo->eliminarCliente($id);
    if($r){
        ?>
        <script type="text/javascript">
            alert("Cliente registrado con exito");
            location.href = '../controlador/clienteLista.php';
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
