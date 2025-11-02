<?php include("../componentes/header.php"); ?>

<div class="col-xxl">
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-danger text-white">
            <h5 class="mb-0"><i class="fas fa-user-shield"></i> Registro de Administrador</h5>
            <small class="text-white">Complete el formulario</small>
        </div>
        <div class="card-body">
            <form method="POST" action="../controlador/usuarioAdministradorRegistro.php">
                <!-- CI -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">CI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ci" required />
                    </div>
                </div>

                <!-- Nombre -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" required />
                    </div>
                </div>

                <!-- Apellido Paterno -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Apellido Paterno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="paterno" required />
                    </div>
                </div>

                <!-- Apellido Materno -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Apellido Materno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="materno" />
                    </div>
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fechanacimiento" required />
                    </div>
                </div>

                <!-- Email -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" required />
                    </div>
                </div>

                <!-- Usuario -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Usuario</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="usuario" required />
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="pasword" id="password" 
                               pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                               title="Mínimo 8 caracteres, una mayúscula, un número y un carácter especial" required />
                        <div class="form-text">
                            La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, un número y un carácter especial.
                        </div>
                    </div>
                </div>

                <!-- Cargo -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="cargo" required>
                            <option value="1">Administrador</option>
                            <option value="2">Cajero</option>
                            <option value="3">Cliente</option>
                            <!-- Agrega más cargos si es necesario -->
                        </select>
                    </div>
                </div>

                <!-- Estado Laboral -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Estado Laboral</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="estadoLaboral" required>
                            <option value="ACTIVO">Activo</option>
                            <option value="INACTIVO">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100">
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
