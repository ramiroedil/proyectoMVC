<?php include("../componentes/header.php"); ?>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nro</th>
                <th>Cargo</th>
                <th>CI</th>
                <th>Nombre Completo</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th colspan="2">Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $id = 1;
            foreach ($empleados as $empleado): 
            ?>
                <tr>
                    <td><?= $id++; ?></td>
                    <td><?= htmlspecialchars($empleado['cargo']['cargo']); ?></td>
                    <td><?= htmlspecialchars($empleado['ci']); ?></td>
                    <td><?= htmlspecialchars($empleado['nombre'] . ' ' . $empleado['paterno'] . ' ' . $empleado['materno']); ?></td>
                    <td><?= htmlspecialchars($empleado['direccion']); ?></td>
                    <td><?= htmlspecialchars($empleado['telefono']); ?></td>
                    <td>
                        <a href="../controlador/empleadoModificar.php?id=<?= $empleado['id']; ?>"
                           class="btn btn-success btn-sm">Editar</a>
                    </td>
                    <td>
                        <a href="../controlador/empleadoEliminar.php?id=<?= $empleado['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Está seguro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("../componentes/footer.php"); ?>