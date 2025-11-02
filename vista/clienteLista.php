<?php include("../componentes/header.php"); ?>

<div class="card shadow">
    <div class="card-header text-center bg-primary text-white">
        <h3>Lista de Clientes</h3>
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
                            <td><?php echo htmlspecialchars($cliente['estado']); ?></td>
                            <td>
                                <a href="../controlador/clienteModifica.php?id_cliente=<?php echo $cliente['id']; ?>"
                                   class="btn btn-success btn-sm">Editar</a>
                            </td>
                            <td>
                                <a href="../controlador/clienteEliminar.php?id=<?php echo $cliente['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Está seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No hay clientes registrados</div>
        <?php endif; ?>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>