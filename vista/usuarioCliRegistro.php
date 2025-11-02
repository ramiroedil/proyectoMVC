<?php include("../componentes/header.php"); ?>

<div class="col-xxl">
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-user"></i> Registro de Cliente</h5>
            <small class="text-white">Complete el formulario</small>
        </div>
        <div class="card-body">
            <form method="POST" action="../controlador/usuarioClienteRegistro.php">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">CI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ci" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Apellido Paterno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="paterno" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Apellido Materno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="materno" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fechanacimiento" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Usuario</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="usuario" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" 
                               pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                               title="Mínimo 8 caracteres, una mayúscula, un número y un carácter especial" required />
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-save"></i> Registrar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="../controlador/usuarioLista.php" class="btn btn-secondary w-100">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>