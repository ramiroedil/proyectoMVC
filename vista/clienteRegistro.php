<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Registrar Nuevo Cliente</h3>
            </div>
            <div class="card-body">
                <form method="post" action="../controlador/clienteRegistroCo.php">
                    <div class="form-group mb-3">
                        <label for="razonsocial">Razón Social / Nombre</label>
                        <input type="text" class="form-control" name="razonsocial" id="razonsocial" 
                               placeholder="Nombre completo o razón social" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="nit_ci">NIT o CI</label>
                        <input type="text" class="form-control" name="nit_ci" id="nit_ci" 
                               placeholder="Número de documento" required>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" name="registrarCliente" class="btn btn-primary">
                            <i class="fas fa-save"></i> Registrar Cliente
                        </button>
                        <a href="../controlador/clienteLista.php" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>