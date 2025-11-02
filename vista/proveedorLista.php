<?php include("../componentes/header.php"); ?>

<div class="row pt-3 justify-content-center">
    <div class="col-md-2">
        <a href="../controlador/proveedorRegistrar.php" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Nuevo Proveedor
        </a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/proveedorBuscar.php" class="btn btn-warning btn-sm">
            <i class="fas fa-search"></i> Buscar Proveedor
        </a>
    </div>
    <div class="col-md-2">
        <a href="#" class="btn btn-success" onclick="exportTableToExcel('tblData', 'lista_proveedores.xls')">
            <i class="fas fa-file-excel"></i> Exportar a Excel
        </a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/proveedorPdf.php" target="_blank" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Ver PDF
        </a>
    </div>
</div>

<div class="row pt-3 justify-content-center">
    <div class="col-md-12 text-center">
        <h1>LISTA DE PROVEEDORES</h1>
    </div>
</div>

<div class="table-responsive">
    <?php if (!empty($proveedores)): ?>
        <table class="table table-striped table-bordered" id="tblData">
            <thead class="table-dark">
                <tr>
                    <th>Nro</th>
                    <th>Empresa</th>
                    <th>Contacto</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Logo</th>
                    <th colspan="2">Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $id = 1;
                foreach ($proveedores as $proveedor): 
                ?>
                    <tr>
                        <td><?= $id++; ?></td>
                        <td><?= htmlspecialchars($proveedor['empresa']); ?></td>
                        <td><?= htmlspecialchars($proveedor['contacto']); ?></td>
                        <td><?= htmlspecialchars($proveedor['mail']); ?></td>
                        <td><?= htmlspecialchars($proveedor['telefono']); ?></td>
                        <td><?= htmlspecialchars($proveedor['direccion']); ?></td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#mostrar_<?= $proveedor['id'] ?>">
                                <img src="../controlador/imagenes/<?= htmlspecialchars($proveedor['logo']); ?>" 
                                     width="70px" height="70px" class="rounded">
                            </a>
                        </td>
                        <td>
                            <a href="../controlador/proveedorModificar.php?id=<?= $proveedor['id']; ?>" 
                               class="btn btn-success btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </td>
                        <td>
                            <a href="../controlador/proveedorEliminar.php?id=<?= $proveedor['id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Está seguro de eliminar este proveedor?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay proveedores registrados</div>
    <?php endif; ?>
</div>

<!-- MODALES PARA LOGOS -->
<?php foreach ($proveedores as $proveedor): ?>
    <div class="modal fade" id="mostrar_<?= $proveedor['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h4 class="modal-title text-white text-center w-100">
                        <?= htmlspecialchars($proveedor['empresa']); ?>
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img src="../controlador/imagenes/<?= htmlspecialchars($proveedor['logo']); ?>" 
                         width="100%" height="100%" style="object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php include("../componentes/footer.php"); ?>