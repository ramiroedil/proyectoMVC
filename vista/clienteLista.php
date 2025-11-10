<?php include("../componentes/header.php"); ?>

<div class="d-flex justify-content-center mb-3">
        <a href="../controlador/clienteRegistro.php" class="btn btn-info btn-sm">
            <i class="fas fa-user-plus"></i> Nuevo Cliente
        </a>
        <a href="../controlador/usuarioLista.php" class="btn btn-warning btn-sm">
        <i class="fas fa-user"></i> Lista de Usuarios
    </a>
    <a href="../controlador/empleadoLista.php" class="btn btn-primary btn-sm">
        <i class="fas fa-user"></i> Lista de Empleados
    </a>
</div>

<div class="card shadow">
    <div class="card-header text-center bg-info text-white">
        <h3>Lista de Clientes</h3>
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
                            <th>NIT/CI</th>
                            <th>Razón Social</th>
                            <th>Tipo</th>
                            <th>Estado Cliente</th>
                            <th>Estado</th>
                            <th colspan="2">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $contador = 1;
                        foreach ($usuarios as $usuario): 
                        ?>
                            <tr>
                                <td><?= $contador++; ?></td>
                                <td><?= htmlspecialchars($usuario['usuario']); ?></td>
                                <td><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . ($usuario['apellido_materno'] ?? '')); ?></td>
                                <td><?= htmlspecialchars($usuario['ci'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($usuario['email']); ?></td>
                                <td><?= htmlspecialchars($usuario['cliente']['nit_ci'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($usuario['cliente']['razon_social'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php
                                    $tipo = $usuario['cliente']['tipo_cliente'] ?? 'PERSONA';
                                    $badge_class = $tipo === 'EMPRESA' ? 'bg-primary' : 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= $tipo ?></span>
                                </td>
                                <td>
                                    <?php
                                    $estado_cliente = $usuario['cliente']['estado_cliente'] ?? 'ACTIVO';
                                    $badge_class = 'bg-success';
                                    if ($estado_cliente === 'INACTIVO') $badge_class = 'bg-danger';
                                    elseif ($estado_cliente === 'SUSPENDIDO') $badge_class = 'bg-warning';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= $estado_cliente ?></span>
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
                                    <a href="../controlador/clienteEditar.php?id=<?= $usuario['id']; ?>" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="../controlador/clienteEliminar.php?id=<?= $usuario['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Está seguro de eliminar este cliente?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No hay clientes registrados</div>
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