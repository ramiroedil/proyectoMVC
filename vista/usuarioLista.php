<?php
include("../componentes/header.php");
?>
<div class="row justify-content-center">
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/usuarioRegistro.php" class="btn btn-success btn-sm">
                <i class="bi bi-pencil-fill"></i> Nuevo Usuario
            </a>
        </div>
    </div>
    <!-- <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/cargoBusqueda.php" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i> Buscar Usuario
            </a>
        </div>
    </div>

    <div class="col-md-2"> 
        <div class="card shadow">
            <a href="cargo_pdf.php" target="_blank" class="btn btn-danger"> Ver PDF</a>
        </div>
    </div> -->
</div>
<div class="card shadow">
    <div class="card-header text-center bg-primary text-white">
        <h3>Lista de Usuarios</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered text-center" id="tblData">
            <thead class="table-dark">
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Tipo Usuario</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido Paterno</th>
                    <th scope="col">Apellido Materrno</th>
                    <th scope="col">ci</th>
                    <th scope="col">email</th>
                    <th scope="col" colspan="2">Operaciones</th>
                </tr>
            </thead>
            <?php
            $id = 1;
            ?>
            <tbody>
                <?php while ($r = mysqli_fetch_array($resul)) { ?>

                    <tr>
                        <td><span class="badge bg-info text-primary px-3 rounded"><?= $id++ ?></span></td>
                        <td><?php echo ($r["nombreusuario"]); ?></td>
                        <td><?php echo ($r["tipousuario"]); ?></td>
                        <td><?php echo ($r["estado"]); ?></td>
                        <td><?php echo ($r["nombre"]); ?></td>
                        <td><?php echo ($r["paterno"]); ?></td>
                        <td><?php echo ($r["materno"]); ?></td>
                        <td><?php echo ($r["ci"]); ?></td>
                        <td><?php echo ($r["email"]); ?></td>
                        <td>
                            <a href='../controlador/usuarioEditar.php?id=<?php echo $r['id_usuario']; ?>'
                                class="btn btn-success btn-sm">
                                <i class="bi bi-pencil-fill"></i> Editar
                            </a>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" data-user-id="<?= $r['id_usuario'] ?>"
                                    onchange="actualizarEstado(this)" <?php if ($r['estado'] == 'activo')
                                        echo 'checked'; ?>>
                                <label class="form-check-label" id="state-label-<?= $r['id_usuario'] ?>">
                                    <?php echo ucfirst($r['estado']); ?>
                                </label>
                            </div>

                            <!-- <a href='../controlador/usuarioEliminar.php?id=<?php echo $r['id_usuario']; ?>'
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Eliminar
                            </a> -->
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</main>
<?php
include("../componentes/footer.php");
?><script>
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

            document.getElementById("state-label-" + userId).textContent = nuevoEstado.charAt(0).toUpperCase() + nuevoEstado.slice(1);
        } else {
            alert("Error: " + data.error);
            checkbox.checked = !checkbox.checked; // Revertir estado
        }
    })
    .catch(err => {
        alert("Error de red");
        checkbox.checked = !checkbox.checked;
    });
}
</script>
