<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form role="form" method="GET" action="../controlador/clienteModifica.php">
            <h3>Actualizar Cliente</h3>
            <input type="hidden" name="id_cliente" value="<?= $r['id']; ?>">
            
            <div class="form-group mb-3">
                <label for="razonsocial">Razón Social</label>
                <input type="text" class="form-control" name="razonsocial" id="razonsocial" 
                       value="<?= htmlspecialchars($r['razon_social']); ?>" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="nit_ci">NIT/CI</label>
                <input type="text" class="form-control" name="nit_ci" id="nit_ci" 
                       value="<?= htmlspecialchars($r['nit_ci']); ?>" required>
            </div>

            <div class="mt-3">
                <button type="submit" name="modificarCliente" class="btn btn-primary">Actualizar</button>
                <a href="../controlador/clienteLista.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>