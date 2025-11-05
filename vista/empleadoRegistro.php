<?php include("../componentes/header.php"); ?>

<main class="main-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-user-tie"></i> Registrar Nuevo Empleado</h3>
                    </div>
                    <div class="card-body">
                        <form action="../controlador/empleadoRegistro.php" method="post" id="formEmpleado">
                            <!-- Información Personal -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2"><i class="fas fa-user"></i> Información Personal</h5>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                                    <input type="text" name="paterno" class="form-control" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Materno</label>
                                    <input type="text" name="materno" class="form-control">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">CI/Cédula <span class="text-danger">*</span></label>
                                    <input type="text" name="ci" class="form-control" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" name="fechanacimiento" class="form-control">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Género</label>
                                    <select name="genero" class="form-select">
                                        <option value="">Seleccionar</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="tel" name="telefono" class="form-control" placeholder="+591">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" name="direccion" class="form-control">
                                </div>
                            </div>

                            <!-- Información de Cuenta -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2"><i class="fas fa-key"></i> Información de Cuenta</h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre de Usuario <span class="text-danger">*</span></label>
                                    <input type="text" name="usuario" class="form-control" required>
                                    <small class="form-text text-muted">Usuario para iniciar sesión</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="confirm_password" required>
                                    <small id="password-error" class="text-danger d-none">Las contraseñas no coinciden</small>
                                </div>
                            </div>

                            <!-- Información Laboral -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2"><i class="fas fa-briefcase"></i> Información Laboral</h5>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Cargo <span class="text-danger">*</span></label>
                                    <select name="cargoId" class="form-select" required>
                                        <option value="">Seleccionar cargo</option>
                                        <?php foreach ($cargos as $cargo): ?>
                                            <option value="<?= $cargo['id'] ?>">
                                                <?= htmlspecialchars($cargo['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Salario</label>
                                    <input type="number" name="salario" class="form-control" step="0.01" min="0" value="0">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Estado Laboral <span class="text-danger">*</span></label>
                                    <select name="estadoLaboral" class="form-select" required>
                                        <option value="ACTIVO" selected>Activo</option>
                                        <option value="INACTIVO">Inactivo</option>
                                        <option value="SUSPENDIDO">Suspendido</option>
                                        <option value="VACACIONES">Vacaciones</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="../controlador/empleadoLista.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Registrar Empleado
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('formEmpleado').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const errorElement = document.getElementById('password-error');
    
    if (password !== confirmPassword) {
        e.preventDefault();
        errorElement.classList.remove('d-none');
        document.getElementById('confirm_password').classList.add('is-invalid');
        return false;
    } else {
        errorElement.classList.add('d-none');
        document.getElementById('confirm_password').classList.remove('is-invalid');
    }
});

// Validación en tiempo real
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    const errorElement = document.getElementById('password-error');
    
    if (password !== confirmPassword && confirmPassword !== '') {
        errorElement.classList.remove('d-none');
        this.classList.add('is-invalid');
    } else {
        errorElement.classList.add('d-none');
        this.classList.remove('is-invalid');
    }
});
</script>

<?php include("../componentes/footer.php"); ?>