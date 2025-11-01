<?php
if (isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == "activar") {
    $cid = $_GET['id'];
    include("../modelo/clienteClase.php");
    $cliente = new Clientes($cid, "", "", "");
    $resultado = $cliente->activo(); 
    if ($resultado) {
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
