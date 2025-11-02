<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form role="form" method="GET">
            <h3>Actualizar Cargo</h3>
            <input type="hidden" name="id" value="<?= $r['id']; ?>">
            
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo" id="cargo" 
                       value="<?= htmlspecialchars($r['cargo']); ?>" required>
            </div>

            <div class="mt-3">
                <button type="submit" name="act" class="btn btn-primary">Actualizar</button>
                <a href="../controlador/cargoLista.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>