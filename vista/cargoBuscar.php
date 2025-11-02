<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form role="form" method="GET" action="../controlador/cargoBusqueda.php">
            <h3>BUSCAR CARGO</h3>
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo" id="cargo" 
                       value="<?php echo isset($_GET['cargo']) ? htmlspecialchars($_GET['cargo']) : ''; ?>">
            </div>
            <div class="mt-3">
                <button type="submit" name="Buscar" class="btn btn-primary">BUSCAR</button>
            </div>
        </form>
        
        <?php if (!empty($datos)): ?>
            <table class="table mt-4 table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>CARGO</th>
                        <th colspan="2">OPERACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $cargo): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cargo['cargo']); ?></td>
                            <td>
                                <a href="../controlador/cargoModifica.php?id=<?php echo $cargo['id']; ?>" 
                                   class="btn btn-warning">Editar</a>
                            </td>
                            <td>
                                <a href="../controlador/cargoEliminar.php?id=<?php echo $cargo['id']; ?>" 
                                   class="btn btn-danger"
                                   onclick="return confirm('¿Está seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_GET["Buscar"])): ?>
            <p class="mt-4 text-center text-danger">No se encontraron resultados.</p>
        <?php endif; ?>
        
        <a href="../controlador/cargoLista.php" class="btn btn-danger mt-3">Ir a Principal</a>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>