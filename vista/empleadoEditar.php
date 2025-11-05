<?php include("../componentes/header.php"); ?>

<main class="main-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-user-edit"></i> Editar Empleado</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($usuarioEditar) && !empty($usuarioEditar)): ?>
                        <form action="../controlador/usuarioEditar.php" method="post" id="formEditarEmpleado">
                            <input type="hidden" name="id" value="<?= isset($usuarioEditar['id']) ? $usuarioEditar['id'] : '' ?>">
                            <input type="hidden" name="tipo_usuario_original" value="empleado">
                            
                            <!-- Información Personal -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2"><i class="fas fa-user"></i> Información Personal</h5>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" class="form-control" 
                                           value="<?= isset($usuarioEditar['nombre']) ? htmlspecialchars($usuarioEditar['nombre']) : '' ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                                    <input type="text" name="paterno" class="form-control" 
                                           value="<?= isset($usuarioEditar['apellido_paterno']) ? htmlspecialchars($usuarioEditar['apellido_paterno']) : '' ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Apellido Materno</label>
                                    <input type="text" name="materno" class="form-control" 
                                           value="<?= isset($usuarioEditar['apellido_materno']) ? htmlspecialchars($usuarioEditar['apellido_materno']) : '' ?>">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">CI/Cédula <span class="text-danger">*</span></label>
                                    <input type="text" name="ci" class="form-control" 
                                           value="<?= isset($usuarioEditar['ci']) ? htmlspecialchars($usuarioEditar['ci']) : '' ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Fecha de Nacimiento</label>
                                    <?php 
                                    $fecha = '';
                                    if (isset($usuarioEditar['fecha_nacimiento']) && $usuarioEditar['fecha_nacimiento']) {
                                        $fecha = substr($usuarioEditar['fecha_nacimiento'], 0, 10);
                                    }
                                    ?>
                                    <input type="date" name="fecha_nacimiento" class="form-control" value="<?= $fecha ?>">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Género</label>
                                    <select name="genero" class="form-select">
                                        <option value="">Seleccionar</option>
                                        <option value="M" <?= (isset($usuarioEditar['genero']) && $usuarioEditar['genero'] === 'M') ? 'selected' : '' ?>>Masculino</option>
                                        <option value="F" <?= (isset($usuarioEditar['genero']) && $usuarioEditar['genero'] === 'F') ? 'selected' : '' ?>>Femenino</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="tel" name="telefono" class="form-control" 
                                           value="<?= isset($usuarioEditar['telefono']) ? htmlspecialchars($usuarioEditar['telefono']) : '' ?>">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" name="direccion" class="form-control" 
                                           value="<?= isset($usuarioEditar['direccion']) ? htmlspecialchars($usuarioEditar['direccion']) : '' ?>">
                                </div>
                            </div>

                            <!-- Información de Cuenta -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2"><i class="fas fa-key"></i> Información de Cuenta</h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre de Usuario <span class="text-danger">*</span></label>
                                    <input type="text" name="usuario" class="form-control" 
                                           value="<?= isset($usuarioEditar['usuario']) ? htmlspecialchars($usuarioEditar['usuario']) : '' ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?= isset($usuarioEditar['email']) ? htmlspecialchars($usuarioEditar['email']) : '' ?>" required>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Deja la contraseña en blanco si no deseas cambiarla
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Dejar en blanco para no cambiar">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirmar nueva contraseña">
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
                                        <option value="">Seleccionar Cargo</option>
                                        <?php if (isset($cargos) && !empty($cargos)): ?>
                                            <?php foreach ($cargos as $cargo): ?>
                                                <option value="<?= $cargo['id'] ?>" 
                                                    <?= (isset($usuarioEditar['empleado']['id_cargo']) && $usuarioEditar['empleado']['id_cargo'] == $cargo['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($cargo['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Salario</label>
                                    <input type="number" name="salario" class="form-control" 
                                           value="<?= isset($usuarioEditar['empleado']['salario']) ? floatval($usuarioEditar['empleado']['salario']) : 0 ?>"
                                           step="0.01" min="0">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Estado Laboral <span class="text-danger">*</span></label>
                                    <select name="estadoLaboral" class="form-select" required>
                                        <option value="ACTIVO" <?= (isset($usuarioEditar['empleado']['estadoLaboral']) && $usuarioEditar['empleado']['estadoLaboral'] === 'ACTIVO') ? 'selected' : '' ?>>Activo</option>
                                        <option value="INACTIVO" <?= (isset($usuarioEditar['empleado']['estadoLaboral']) && $usuarioEditar['empleado']['estadoLaboral'] === 'INACTIVO') ? 'selected' : '' ?>>Inactivo</option>
                                        <option value="LICENCIA" <?= (isset($usuarioEditar['empleado']['estadoLaboral']) && $usuarioEditar['empleado']['estadoLaboral'] === 'LICENCIA') ? 'selected' : '' ?>>Licencia</option>
                                        <option value="SUSPENDIDO" <?= (isset($usuarioEditar['empleado']['estadoLaboral']) && $usuarioEditar['empleado']['estadoLaboral'] === 'SUSPENDIDO') ? 'selected' : '' ?>>Suspendido</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Estado del Usuario -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2"><i class="fas fa-toggle-on"></i> Estado</h5>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Estado del Usuario</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="estado" value="1" 
                                               id="estado" <?= (isset($usuarioEditar['estado']) && $usuarioEditar['estado']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="estado">
                                            Usuario Activo
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="../controlador/empleadoLista.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" name="edit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Empleado
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            No se pudieron cargar los datos del empleado. 
                            <a href="../controlador/empleadoLista.php">Volver a la lista</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('formEditarEmpleado')?.addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const errorElement = document.getElementById('password-error');
    
    if (password !== '' || confirmPassword !== '') {
        if (password !== confirmPassword) {
            e.preventDefault();
            errorElement.classList.remove('d-none');
            document.getElementById('confirm_password').classList.add('is-invalid');
            return false;
        }
    }
    
    errorElement.classList.add('d-none');
    document.getElementById('confirm_password').classList.remove('is-invalid');
});

document.getElementById('confirm_password')?.addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    const errorElement = document.getElementById('password-error');
    
    if (password !== confirmPassword && (password !== '' || confirmPassword !== '')) {
        errorElement.classList.remove('d-none');
        this.classList.add('is-invalid');
    } else {
        errorElement.classList.add('d-none');
        this.classList.remove('is-invalid');
    }
});
</script>

<?php include("../componentes/footer.php"); ?>