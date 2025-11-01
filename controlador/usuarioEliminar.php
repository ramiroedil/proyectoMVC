<?php
include("../modelo/usuario.php");
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $cargo = new Usuario(""
, ""
, ""
, ""
, ""
, ""
, ""
, ""
, ""
, ""
, $id,
"");
    $r= $cargo->elimUsuario();
    if($r){
        ?>
        <script type="text/javascript">
            alert("Usuario eliminado con exito");
            location.href = '../controlador/usuarioLista.php';
            </script>
            <?php
            }else{
                ?>
                <script type="text/javascript">
                    
            alert("Usuario NO eliminado con exito");
            </script>
            <?php
            }
        }
?>