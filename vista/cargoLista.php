<?php
include("../componentes/header.php");
?>
<div class="row justify-content-center">
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/cargoRegistro.php" class="btn btn-success btn-sm">
                <i class="bi bi-pencil-fill"></i> Nuevo cargo
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/cargoBusqueda.php" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i> Buscar Cargo
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="#" class="btn  btn-success"><i data-feather="file"></i><span class="align-middle"
                    onclick="exportTableToExcel('tblData', 'lista_cargo.xls')">Exportar a Excel</span></a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="cargo_pdf.php" target="_blank" class="btn btn-danger"> Ver PDF</a>
            </div>
    </div>
</div>
<div class="card shadow">
    <div class="card-header text-center bg-primary text-white">
        <h3>Lista de Cargos</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered text-center" id="tblData">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Cargo</th>
                    <th scope="col" colspan="2">Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r = mysqli_fetch_array($res)) { ?>
                    <tr>
                        <td><?php echo ($r["cargo"]); ?></td>
                        <td>
                            <a href='../controlador/cargoModifica.php?id=<?php echo $r['id_cargo']; ?>'
                                class="btn btn-success btn-sm">
                                <i class="bi bi-pencil-fill"></i> Editar
                            </a>
                        </td>
                        <td>
                            <a href='../controlador/cargoEliminar.php?id=<?php echo $r['id_cargo']; ?>'
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i> Eliminar
                            </a>
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
?>