<?php include("../componentes/header.php"); ?>

<div class="col-xxl">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Registro de Proveedor</h5>
        </div>
        <div class="card-body">
            <form method="post" action="../controlador/proveedorRegistrar.php" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Empresa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="empresa" 
                               placeholder="Nombre de la empresa" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Contacto</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="contacto" 
                               placeholder="Nombre del contacto" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="mail" 
                               placeholder="correo@ejemplo.com" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telefono" 
                               placeholder="Número de teléfono" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="direccion" 
                               placeholder="Dirección completa" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Logo</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="logo" accept="image/*" />
                        <small class="text-muted">Formatos permitidos: JPG, PNG, GIF</small>
                    </div>
                </div>
                
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" name="registrarProveedor">
                            <i class="fas fa-save"></i> Registrar
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