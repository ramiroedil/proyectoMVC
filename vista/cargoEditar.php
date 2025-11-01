<?php
include("../componentes/header.php");
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <form role="form" method="GET">
            <h3>Actualizar Cargo</h3>
            <!-- Campo oculto para el ID -->
            <input type="hidden" name="id" id="id" value='<?= $r[0]; ?>'>
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo" id="cargo" value='<?= $r[1]; ?>' required>
            </div>

            <div class="mt-3">
                <button type="submit" name="act" id="act" class="btn btn-primary">Actualizar</button>
                <a href="../controlador/cargoLista.php" class="btn btn-danger">Cancelar</a>
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