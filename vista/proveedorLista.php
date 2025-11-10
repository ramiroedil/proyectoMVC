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

<div class="row">
            <div class="col-12">
                <?php if (!empty($proveedores)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tblProveedores">
                            <thead class="table-dark sticky-top">
                                <tr>
                                    <th style="width: 5%;">Nro</th>
                                    <th style="width: 20%;">Empresa</th>
                                    <th style="width: 15%;">NIT</th>
                                    <th style="width: 20%;">Contacto</th>
                                    <th style="width: 15%;">Email</th>
                                    <th style="width: 12%;">Teléfono</th>
                                    <th style="width: 15%;">Ciudad</th>
                                    <th style="width: 10%;">Estado</th>
                                    <th colspan="2" style="width: 12%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $contador = 1;
                                foreach ($proveedores as $proveedor): 
                                    // Mapeo de campos según TypeORM Entity
                                    $id = $proveedor['id'] ?? '';
                                    $empresa = $proveedor['empresa'] ?? 'N/A';
                                    $nit = $proveedor['nit'] ?? 'N/A';
                                    $contacto_nombre = $proveedor['contacto_nombre'] ?? 'N/A';
                                    $contacto_cargo = $proveedor['contacto_cargo'] ?? '';
                                    $email = $proveedor['email'] ?? 'N/A';
                                    $telefono = $proveedor['telefono'] ?? 'N/A';
                                    $direccion = $proveedor['direccion'] ?? '';
                                    $ciudad = $proveedor['ciudad'] ?? 'N/A';
                                    $pais = $proveedor['pais'] ?? 'Bolivia';
                                    $estado = $proveedor['estado'] ?? true;
                                    $logo = $proveedor['logo'] ?? null;
                                    $sitio_web = $proveedor['sitio_web'] ?? null;
                                ?>
                                    <tr>
                                        <!-- Número -->
                                        <td class="text-center font-weight-bold"><?= $contador++; ?></td>

                                        <!-- Empresa -->
                                        <td>
                                            <strong><?= htmlspecialchars($empresa); ?></strong>
                                            <?php if (!empty($logo)): ?>
                                                <br><small>
                                                    <i class="fas fa-image"></i>
                                                    <a href="<?= htmlspecialchars($logo); ?>" 
                                                       target="_blank" class="text-decoration-none">
                                                        Logo
                                                    </a>
                                                </small>
                                            <?php endif; ?>
                                        </td>

                                        <!-- NIT -->
                                        <td>
                                            <code><?= htmlspecialchars($nit); ?></code>
                                        </td>

                                        <!-- Contacto (Nombre + Cargo) -->
                                        <td>
                                            <strong><?= htmlspecialchars($contacto_nombre); ?></strong>
                                            <?php if (!empty($contacto_cargo)): ?>
                                                <br><small class="text"><?= htmlspecialchars($contacto_cargo); ?></small>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Email -->
                                        <td>
                                            <a href="mailto:<?= htmlspecialchars($email); ?>" 
                                               class="text-decoration-non">
                                                <?= htmlspecialchars($email); ?>
                                            </a>
                                        </td>

                                        <!-- Teléfono -->
                                        <td>
                                            <a href="tel:<?= htmlspecialchars($telefono); ?>" 
                                               class="text-decoration-none">
                                                <i class="fas fa-phone"></i> 
                                                <?= htmlspecialchars($telefono); ?>
                                            </a>
                                        </td>

                                        <!-- Ciudad -->
                                        <td>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($ciudad); ?>
                                            <?php if ($pais !== 'Bolivia'): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars($pais); ?></small>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Estado -->
                                        <td class="text-center">
                                            <?php if ($estado): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Activo
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-ban"></i> Inactivo
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Botón Editar -->
                                        <td class="text-center">
                                            <a href="../controlador/proveedorModificar.php?id=<?= $id; ?>" 
                                               class="btn btn-sm btn-outline-success"
                                               title="Editar proveedor">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </td>

                                        <!-- Botón Eliminar/Desactivar -->
                                        <td class="text-center">
                                            <a href="../controlador/proveedorEliminar.php?id=<?= $id; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               title="Eliminar proveedor"
                                               onclick="return confirm('⚠️ ¿Está seguro de eliminar este proveedor?\n\nEmpresa: <?= htmlspecialchars($empresa); ?>')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>No hay proveedores registrados</strong>
                        <p class="mb-0">Haz clic en <a href="../controlador/proveedorRegistro.php" class="alert-link">Nuevo Proveedor</a> para agregar.</p>
                        <?php if (!empty($error_message)): ?>
                            <p class="mb-0 mt-2">
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Error: <?= htmlspecialchars($error_message); ?>
                                </small>
                            </p>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
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