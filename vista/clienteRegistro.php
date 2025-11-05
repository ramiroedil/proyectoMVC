<?php include("../componentes/header.php"); ?>

<main class="main-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h3 class="mb-0"><i class="fas fa-user"></i> Registrar Nuevo Cliente</h3>
                    </div>
                    <div class="card-body">
                        <form action="../controlador/clienteRegistro.php" method="post" id="formCliente">
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

                            <!-- Información Fiscal/Comercial -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2"><i class="fas fa-file-invoice"></i> Información Fiscal</h5>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">NIT/CI <span class="text-danger">*</span></label>
                                    <input type="text" name="nit_ci" class="form-control" required>
                                    <small class="form-text text-muted">Para facturación</small>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Razón Social</label>
                                    <input type="text" name="razon_social" class="form-control">
                                    <small class="form-text text-muted">Opcional, para empresas</small>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo de Cliente <span class="text-danger">*</span></label>
                                    <select name="tipo_cliente" class="form-select" required>
                                        <option value="PERSONA" selected>Persona Natural</option>
                                        <option value="EMPRESA">Empresa</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Estado del Cliente <span class="text-danger">*</span></label>
                                    <select name="estado_cliente" class="form-select" required>
                                        <option value="ACTIVO" selected>Activo</option>
                                        <option value="INACTIVO">Inactivo</option>
                                        <option value="SUSPENDIDO">Suspendido</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="../controlador/clienteLista.php" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-save"></i> Registrar Cliente
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
document.getElementById('formCliente').addEventListener('submit', function(e) {
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

// Mostrar/ocultar razón social según tipo de cliente
document.querySelector('select[name="tipo_cliente"]').addEventListener('change', function() {
    const razonSocialInput = document.querySelector('input[name="razon_social"]');
    if (this.value === 'EMPRESA') {
        razonSocialInput.required = true;
        razonSocialInput.parentElement.querySelector('label').innerHTML = 
            'Razón Social <span class="text-danger">*</span>';
    } else {
        razonSocialInput.required = false;
        razonSocialInput.parentElement.querySelector('label').textContent = 'Razón Social';
    }
});
</script>

<?php include("../componentes/footer.php"); ?>