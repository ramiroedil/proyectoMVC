<?php
if (isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == "desactivar") {
    $cid = $_GET['id'];
    include("../modelo/clienteClase.php");

    // Instanciamos la clase con el ID del cliente
    $cliente = new Clientes($cid, "", "", "");
    $res = $cliente->inactivo(); 
    if ($res) {
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
