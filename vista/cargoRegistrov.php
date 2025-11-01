<?php
include("../componentes/header.php");
?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="post">
                        
                        <div class="col-md-4">
                            <label>CARGO</label>
                            <input type="text" class="form-control"  name="cargo">
                        </div>
                        
                        <input type ="submit" name="registrarCargo" value="registrarCargo" class="btn btn-primary">
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
