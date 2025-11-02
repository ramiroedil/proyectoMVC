<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header text-center bg-warning text-dark">
                <h3>Lista de Clientes Inactivos</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($clientes)): ?>
                    <table class="table table-striped table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Razón Social</th>
                                <th>NIT/CI</th>
                                <th>Estado</th>
                                <th colspan="2">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?php echo $cliente['id']; ?></td>
                                    <td><?php echo htmlspecialchars($cliente['razon_social']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['nit_ci']); ?></td>
                                    <td><span class="badge bg-danger"><?php echo htmlspecialchars($cliente['estado']); ?></span></td>
                                    <td>
                                        <a href="../controlador/clienteactivo.php?id=<?php echo $cliente['id']; ?>&act=activar" 
                                           class="btn btn-success btn-sm"
                                           onclick="return confirm('¿Está seguro de activar este cliente?')">
                                            Activar
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../controlador/clienteEliminar.php?id=<?php echo $cliente['id']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Está seguro de eliminar permanentemente?')">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">No hay clientes inactivos</div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="../controlador/clienteLista.php" class="btn btn-primary">Ver Clientes Activos</a>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>