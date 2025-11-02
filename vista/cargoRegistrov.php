<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Registrar Nuevo Cargo</h3>
            </div>
            <div class="card-body">
                <form method="post" action="../controlador/cargoRegistro.php">
                    <div class="form-group mb-3">
                        <label for="cargo">Nombre del Cargo</label>
                        <input type="text" class="form-control" name="cargo" id="cargo" 
                               placeholder="Ej: Gerente, Vendedor, etc." required>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" name="registrarCargo" class="btn btn-primary">
                            <i class="fas fa-save"></i> Registrar
                        </button>
                        <a href="../controlador/cargoLista.php" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>