<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <form role="form" method="GET" action="../controlador/empleadoBuscar.php">
            <h3>BUSCAR EMPLEADO</h3>
            <div class="form-group">
                <label for="empleado">Nombre del Empleado</label>
                <input type="text" class="form-control" name="empleado" id="empleado"
                       value="<?php echo isset($_GET['empleado']) ? htmlspecialchars($_GET['empleado']) : ''; ?>">
            </div>
            <div class="mt-3">
                <button type="submit" name="Buscar" class="btn btn-primary">BUSCAR EMPLEADO</button>
            </div>
        </form>
        
        <?php if (!empty($empleados)): ?>
            <table class="table mt-4 table-striped table-bordered">
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
                    $i = 1;
                    foreach ($empleados as $empleado): 
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
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
        <?php elseif (isset($_GET["Buscar"])): ?>
            <p class="mt-4 text-center text-danger">No se encontraron resultados.</p>
        <?php endif; ?>
        
        <a href="../controlador/empleadoLista.php" class="btn btn-danger mt-3">Ir a Principal</a>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>