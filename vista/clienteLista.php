<?php
include("../componentes/header.php");
?>
<div class="row justify-content-center">
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/clienteRegistroCo.php" class="btn btn-success btn-sm">
                <i class="bi bi-pencil-fill"></i> Nuevo cliente
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/clienteBusqueda.php" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i> Buscar Cliente
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="clientePdf.php" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil-fill"></i> Reporte
            </a>
        </div>
    </div>
    <div class="row pt-3 justify-content-center">
        <div class="col-md-4">
            <div class="alert alert-info text-center shadow">
                <h5 class="mb-0"> Tipo de Cambio USD → BOB</h5>
                <strong><?= $tipoCambio ?></strong>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/clienteListainactivo.php" class="btn btn-danger btn-sm">
                <i class="bi bi-pencil-fill"></i> INACTIVOS
            </a>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h3>Lista de Grupos</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">NIT</th>
                            <th scope="col">Estado</th>
                            <th scope="col" colspan="2">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysqli_fetch_array($res)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r["id_cliente"]); ?></td>
                                <td><?php echo htmlspecialchars($r["razonsocial"]); ?></td>
                                <td><?php echo htmlspecialchars($r["nit_ci"]); ?></td>
                                <td><?php echo htmlspecialchars($r["estado"]); ?></td>
                                <td>
                                    <a href="../controlador/clienteModifica.php?id_cliente=<?php echo $r['id_cliente']; ?>"
                                        class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil-fill"></i> Editar
                                    </a>
                                </td>
                                <td>
                                    <a href="../controlador/clienteInactivo.php?id=<?php echo $r['id_cliente']; ?>&act=desactivar"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de desactivar este cliente?')"> <i
                                            class="bi bi-trash-fill"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>
</main>
<?php
include("../componentes/footer.php");
?>