<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center mb-3">
    <div class="col-md-2">
        <a href="../controlador/usuarioRegistro.php" class="btn btn-success btn-sm w-100">
            <i class="fas fa-user-plus"></i> Nuevo Usuario
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-header text-center bg-primary text-white">
        <h3>Lista de Usuarios</h3>
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
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Cargo</th>
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
            <td><?= htmlspecialchars($usuario['telefono'] ?? 'N/A'); ?></td>
            <td><?= htmlspecialchars($usuario['direccion'] ?? 'N/A'); ?></td>
            <td>
                <?php
                $badge_class = 'bg-secondary';
                $cargo_display = 'Sin cargo';

                // Verificar si es empleado y tiene cargo
                if (isset($usuario['empleado']['cargo']['nombre'])) {
                    $cargo = strtolower($usuario['empleado']['cargo']['nombre']);
                    if ($cargo == 'administrador' || $cargo == 'gerente') $badge_class = 'bg-danger';
                    elseif ($cargo == 'cajero') $badge_class = 'bg-warning text-dark';
                    elseif ($cargo == 'vendedor') $badge_class = 'bg-success';
                    $cargo_display = ucfirst($usuario['empleado']['cargo']['nombre']);
                }
                // Verificar si es cliente
                elseif (isset($usuario['cliente'])) {
                    $badge_class = 'bg-info';
                    $cargo_display = 'Cliente';
                }
                ?>
                <span class="badge <?= $badge_class ?>"><?= $cargo_display; ?></span>
            </td>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" 
                           data-user-id="<?= $usuario['id'] ?>"
                           onchange="actualizarEstado(this)" 
                           <?= ($usuario['estado'] == true || $usuario['estado'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" id="state-label-<?= $usuario['id'] ?>">
                        <?= ($usuario['estado'] == true || $usuario['estado'] == 1) ? 'Activo' : 'Inactivo'; ?>
                    </label>
                </div>
            </td>
            <td>
                <a href="../controlador/usuarioEditar.php?id=<?= $usuario['id']; ?>" 
                   class="btn btn-success btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </td>
            <td>
                <a href="../controlador/usuarioEliminar.php?id=<?= $usuario['id']; ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                    <i class="fas fa-trash"></i> Eliminar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No hay usuarios registrados</div>
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
