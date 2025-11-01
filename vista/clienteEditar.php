<?php
include("../componentes/header.php");
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <form role="form" method="GET" action="../controlador/clienteModifica.php">
            <h3>Actualizar Cargo</h3>
            <!-- Campo oculto para el ID -->
            <input type="hidden" name="id" id="id" value='<?= $r[0]; ?>'>
            <div class="form-group">
                <label for="razonsocial">RAZON SOCIAL</label>
                <input type="text" class="form-control" name="razonsocial" id="razonsocial" value='<?= $r[1]; ?>' required>
                <label for="nit_ci">NIT_CI</label>
                <input type="text" class="form-control" name="nit_ci" id="nit_ci" value='<?= $r[2]; ?>' required>
                <input type="hidden" class="form-control" name="estado" id="estado" value='<?= $r[3]; ?>'>
            
            </div>

            <div class="mt-3">
                <button type="submit" name="modificarCliente" id="modificarCliente" class="btn btn-primary">Actualizar</button>
                <a href="../controlador/clienteLista.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</main>
<?php
include("../componentes/footer.php");
?>