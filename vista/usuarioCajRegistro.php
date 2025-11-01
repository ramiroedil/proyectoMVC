<?php include("../componentes/header.php"); ?>

<div class="col-xxl">
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Registro de CAJERO</h5>
            <small class="text-muted float-end">Formulario</small>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">CI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ci" required />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" required />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Paterno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="paterno" required />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Materno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="materno" required />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telefono" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fechanacimiento" required />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Usuario</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="usuario" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" required
                            pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                            title="La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un número y un carácter especial." />
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" name="registrarUsuario"
                            value="Registrar">Registrar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="../controlador/usuarioLista.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>