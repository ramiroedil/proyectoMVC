<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form role="form" method="GET" action="../controlador/clienteBusqueda.php">
            <h3>BUSCAR CLIENTE</h3>
            <div class="form-group">
                <label for="cliente">Cliente (Razón Social o NIT/CI)</label>
                <input type="text" class="form-control" name="cliente" id="cliente"
                       value="<?php echo isset($_GET['cliente']) ? htmlspecialchars($_GET['cliente']) : ''; ?>">
            </div>
            <div class="mt-3">
                <button type="submit" name="Buscar" class="btn btn-primary">BUSCAR</button>
            </div>
        </form>
        
        <?php if (!empty($datos)): ?>
            <table class="table mt-4 table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>RAZÓN SOCIAL</th>
                        <th>NIT/CI</th>
                        <th>ESTADO</th>
                        <th colspan="2">OPERACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['razon_social']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['nit_ci']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['estado']); ?></td>
                            <td>
                                <a href="../controlador/clienteModifica.php?id_cliente=<?php echo $cliente['id']; ?>" 
                                   class="btn btn-warning">Editar</a>
                            </td>
                            <td>
                                <a href="../controlador/clienteEliminar.php?id=<?php echo $cliente['id']; ?>" 
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
        
        <a href="../controlador/clienteLista.php" class="btn btn-danger mt-3">Ir a Principal</a>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>