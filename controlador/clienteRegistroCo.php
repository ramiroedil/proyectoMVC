<?php
include("../vista/clienteRegistro.php");
if(isset($_POST['registrarCliente'])){
    $razonsocial=$_POST['razonsocial'];
    $nit_ci=$_POST['nit_ci'];
    $estado="activo";
    include ("../modelo/clienteClase.php");
    $cliente=new clientes("",$razonsocial,$nit_ci,$estado);
    $re=$cliente->grabarCliente();
    if($re){
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