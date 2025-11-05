<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-2">
        <a href="../controlador/cargoRegistro.php" class="btn btn-success btn-sm">Nuevo cargo</a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header text-center bg-primary text-white">
        <h3>Lista de Cargos</h3>
    </div>
    <div class="card-body">
        <?php if (!empty($cargos)): ?>
            <table class="table table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Cargo</th>
                        <th>Descripcion</th>
                        <th colspan="2">Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cargos as $cargo): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cargo['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($cargo['descripcion']); ?></td>
                            <td>
                                <a href='../controlador/cargoModifica.php?id=<?php echo $cargo['id']; ?>'
                                   class="btn btn-success btn-sm">Editar</a>
                            </td>
                            <td>
                                <a href='../controlador/cargoEliminar.php?id=<?php echo $cargo['id']; ?>'
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Está seguro de eliminar este cargo?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No hay cargos registrados</div>
        <?php endif; ?>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>