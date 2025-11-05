<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center mb-3">
    <div class="col-md-2">
        <a href="../controlador/empleadoRegistro.php" class="btn btn-success btn-sm w-100">
            <i class="fas fa-user-plus"></i> Nuevo Empleado
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header text-center bg-primary text-white">
        <h3>Lista de Empleados</h3>
    </div>
    <div class="card-body">
        <?php if (!empty($usuarios)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center" id="tblData">
                    <thead class="table-dark">
                        <tr>
                            <th>N°</th>
                            <th>Usuario</th>
                            <th>Nombre Completo</th>
                            <th>CI</th>
                            <th>Email</th>
                            <th>Cargo</th>
                            <th>Salario</th>
                            <th>Estado Laboral</th>
                            <th>Estado</th>
                            <th colspan="2">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $id = 1;
                        foreach ($usuarios as $usuario): 
                        ?>
                            <tr>
                                <td><?= $id++; ?></td>
                                <td><?= htmlspecialchars($usuario['usuario']); ?></td>
                                <td><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . ($usuario['apellido_materno'] ?? '')); ?></td>
                                <td><?= htmlspecialchars($usuario['ci']); ?></td>
                                <td><?= htmlspecialchars($usuario['email']); ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= htmlspecialchars($usuario['empleado']['cargo']['nombre'] ?? 'Sin cargo'); ?>
                                    </span>
                                </td>
                                <td>Bs. <?= number_format($usuario['empleado']['salario'] ?? 0, 2); ?></td>
                                <td>
                                    <?php
                                    $estado_laboral = $usuario['empleado']['estadoLaboral'] ?? 'ACTIVO';
                                    $badge_class = 'bg-success';
                                    if ($estado_laboral === 'INACTIVO') $badge_class = 'bg-danger';
                                    elseif ($estado_laboral === 'SUSPENDIDO') $badge_class = 'bg-warning';
                                    elseif ($estado_laboral === 'VACACIONES') $badge_class = 'bg-info';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= $estado_laboral ?></span>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               data-user-id="<?= $usuario['id'] ?>"
                                               onchange="actualizarEstado(this)" 
                                               <?= $usuario['estado'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" id="state-label-<?= $usuario['id'] ?>">
                                            <?= $usuario['estado'] ? 'Activo' : 'Inactivo'; ?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="../controlador/usuarioEditar.php?id=<?= $usuario['id']; ?>" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="../controlador/usuarioEliminar.php?id=<?= $usuario['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Está seguro de eliminar este empleado?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No hay empleados registrados</div>
        <?php endif; ?>
    </div>
</div>

<script>
function actualizarEstado(checkbox) {
    const userId = checkbox.getAttribute("data-user-id");
    const nuevoEstado = checkbox.checked ? "activo" : "inactivo";

    fetch("../controlador/estadoUser.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id_usuario=${userId}&estado=${nuevoEstado}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById("state-label-" + userId).textContent = 
                nuevoEstado.charAt(0).toUpperCase() + nuevoEstado.slice(1);
        } else {
            alert("Error: " + data.error);
            checkbox.checked = !checkbox.checked;
        }
    })
    .catch(err => {
        alert("Error de red");
        checkbox.checked = !checkbox.checked;
    });
}
</script>

<?php include("../componentes/footer.php"); ?>