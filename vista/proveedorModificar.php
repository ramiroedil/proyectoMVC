<?php include("../componentes/header.php"); ?>

<div class="container-xxl">
    <h4 class="fw-bold py-3 mb-4">Modificar Proveedor</h4>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Modificación de Proveedor</h5>
        </div>
        <div class="card-body">
            <form method="post" action="../controlador/proveedorModificar.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Empresa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="empresa" 
                               value="<?= htmlspecialchars($r['empresa']); ?>" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Contacto</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="contacto" 
                               value="<?= htmlspecialchars($r['contacto']); ?>" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="mail" 
                               value="<?= htmlspecialchars($r['mail']); ?>" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telefono" 
                               value="<?= htmlspecialchars($r['telefono']); ?>" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="direccion" 
                               value="<?= htmlspecialchars($r['direccion']); ?>" />
                    </div>
                </div>
                
                <?php if (!empty($r['logo'])): ?>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Logo Actual</label>
                        <div class="col-sm-10">
                            <img src="../controlador/imagenes/<?= htmlspecialchars($r['logo']) ?>" 
                                 style="width: 200px; height: 200px; object-fit: contain;" 
                                 class="img-thumbnail">
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nuevo Logo</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="logo" accept="image/*" />
                        <small class="text-muted">Dejar vacío si no desea cambiar el logo</small>
                    </div>
                </div>
                
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" name="modificarProveedor">
                            <i class="fas fa-save"></i> Modificar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="../controlador/proveedorLista.php" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>