<?php
include("../componentes/header.php");
?>
<div class="row pt-3 justify-content-center">
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/proveedorRegistrar.php" class="btn btn-success btn-sm">
                <i class="bi bi-pencil-fill"></i> Nuevo Proveedor
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="../controlador/empleadoBuscar.php" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i> Buscar Proveedor
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="#" class="btn  btn-success"><i data-feather="file"></i><span class="align-middle"
                    onclick="exportTableToExcel('tblData', 'lista_proveedores.xls')">Exportar a Excel</span></a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow">
            <a href="proveedorPdf.php" target="_blank" class="btn btn-danger"> Ver PDF</a>
        </div>
    </div>
</div>
<div class="row pt-3 justify-content-center">
    <div class="col-md-12 text-center">
        <h1 class="text-aligment-center">PROVEEDORES</h1>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered p-3" id="tblData">
        <thead class="table-dark">
            <tr>
                <th>Nro</th>
                <th>EMPRESA</th>
                <th>CONTACTO</th>
                <th>MAIL</th>
                <th>TELEFONO</th>
                <th>DIRECCION</th>
                <th>LOGO</th>
                <th scope="col" colspan="2" class="text-center">OPERACIONES</th>
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
                    <td><?= $r['empresa'] ?></td>
                    <td><?= $r['contacto'] ?></td>
                    <td><?= $r['mail'] ?> </td>
                    <td><?= $r['telefono'] ?></td>
                    <td><?= $r['direccion'] ?></td>
                    <td><a class="navbar-brand rounded" href="#" data-bs-toggle="modal"
                            data-bs-target="#mostrar_<?= $r['id_proveedor'] ?>">
                            <img src="../controlador/imagenes/<?php echo $r[6]; ?>" width="70px" height="70px" class="rounded">
                        </a>
                    </td>
                    <td>
                        <a href='../controlador/proveedorModificar.php?id=<?php echo $r['id_proveedor']; ?>'
                            class="btn btn-success btn-sm">
                            <i class="bi bi-pencil-fill"></i> Editar
                        </a>
                    </td>
                    <td>
                        <a href='../controlador/proveedorEliminar.php?id=<?php echo $r['id_proveedor']; ?>'
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
<?php
while ($re = mysqli_fetch_array($rs)) {
    ?>
    <div class="modal fade" id="mostrar_<?= $re['id_proveedor'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white ">
                    <h4 class="modal-title text-white text-center w-100">PROVEEDOR</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img src="../controlador/imagenes/<?php echo $re[6]; ?>" width="100%" height="100%">
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>