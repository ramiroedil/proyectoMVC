<?php
include("../componentes/header.php");
?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="post">
                        
                        <div class="col-md-4">
                            <label>razonsocial</label>
                            <input type="text" class="form-control"  name="razonsocial">
                        </div>
                        <div class="col-md-4">
                            <label >NIT O CI</label>
                            <input type="text" class="form-control" name="nit_ci">
                        </div>
                        <input type ="submit" name="registrarCliente" value="registrarCliente" class="btn btn-primary">
                        <div class="col-12">
                            <a href="../controlador/clienteLista.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </main>
    <?php
include("../componentes/footer.php");
?>
