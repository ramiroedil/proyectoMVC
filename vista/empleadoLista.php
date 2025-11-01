<?php
include("../componentes/header.php");
?>
<div class="row pt-3 justify-content-center">

    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/empleadoRegistro.php" class="btn btn-success btn-sm">
                <i class="bi bi-pencil-fill"></i> Nuevo empleado
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/empleadoBuscar.php" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i> Buscar empleado
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="#" class="btn  btn-success"><i data-feather="file"></i><span class="align-middle"
                    onclick="exportTableToExcel('tblData', 'lista_empleados.xls')">Exportar a Excel</span></a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="empleadoPdf.php" target="_blank" class="btn btn-danger"> Ver PDF</a>
        </div>
    </div>

</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered p-3" id="tblData">
        <thead class="table-dark">
            <tr>
                <th>Nro</th>
                <th>Cargo</th>
                <th>CI</th>
                <th>Nombre Completo</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Fecha Nacimiento</th>
                <th>Genero</th>
                <th>Intereses</th>
                <th scope="col" colspan="2">Operaciones</th>
                <th> </th>
            </tr>
        </thead>
        <?php
        $id = 1;
        ?>
        <tbody class="table-border-bottom-0">
            <?php
            while ($r = mysqli_fetch_array($res)) {
                ?>
                <tr class="table">
                    <td><span class="badge bg-info text-primary px-3 rounded"><?= $id++ ?></span></td>
                    <td><?= $r['cargo'] ?></td>
                    <td><?= $r['ci'] ?></td>
                    <td><?= $r['nombre'] ?>     <?= $r['paterno'] ?>     <?= $r['materno'] ?></td>
                    <td><?= $r['direccion'] ?></td>
                    <td><?= $r['telefono'] ?></td>
                    <td><?= $r['fechanacimiento'] ?></td>
                    <td><?= $r['genero'] ?></td>
                    <td><?= $r['intereses'] ?></td>

                    <td>
                        <a href='../controlador/empleadoModificar.php?id=<?php echo $r['id_cargo']; ?>'
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
                <?php
            }

            ?>
        </tbody>
    </table>
</div>
</div>

</main>

<?php
include("../componentes/footer.php");
?>