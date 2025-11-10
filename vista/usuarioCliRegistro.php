<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("../componentes/header.php");
?>

<div class="col-xxl">
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-user"></i> Registro de Cliente</h5>
            <small class="text-white">Complete el formulario para comenzar a comprar</small>
        </div>
        <div class="card-body">
            <form method="POST" action="../controlador/usuarioClienteRegistro.php" id="registroForm" onsubmit="return validarFormulario()">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">CI <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ci" required 
                               pattern="[0-9]+" title="Solo números"
                               placeholder="Ej: 12345678" />
                        <small class="text-muted">Cédula de identidad sin guiones</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nombre <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" required 
                               placeholder="Tu nombre" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Apellido Paterno <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="paterno" required 
                               placeholder="Apellido paterno" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Apellido Materno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="materno" 
                               placeholder="Apellido materno (opcional)" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fechanacimiento" required 
                               id="fechaNacimiento" />
                        <small class="text-muted" id="edadInfo"></small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" required 
                               placeholder="tu@email.com" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Usuario <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="usuario" required 
                               minlength="3"
                               placeholder="Nombre de usuario (mín. 3 caracteres)" />
                        <small class="text-muted">Entre 3 y 20 caracteres, sin espacios</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Contraseña <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" 
                                   id="password"
                                   pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                                   title="Mínimo 8 caracteres, una mayúscula, un número y un carácter especial" 
                                   required />
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">
                            Requisitos: <span id="req1">❌</span> Mín. 8 caracteres | 
                            <span id="req2">❌</span> Mayúscula | 
                            <span id="req3">❌</span> Número | 
                            <span id="req4">❌</span> Carácter especial
                        </small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_confirm" 
                               id="password_confirm" required />
                        <small class="text-danger" id="matchError" style="display: none;">
                            Las contraseñas no coinciden
                        </small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terminos" id="terminos" required />
                            <label class="form-check-label" for="terminos">
                                Acepto los términos y condiciones
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info w-100" id="btnRegistrar">
                            <i class="fas fa-save"></i> Registrar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo isset($_SESSION['usuario']) ? '../controlador/usuarioLista.php' : '../../index.php'; ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validación de contraseña en tiempo real
const passwordInput = document.getElementById('password');
const req1 = document.getElementById('req1');
const req2 = document.getElementById('req2');
const req3 = document.getElementById('req3');
const req4 = document.getElementById('req4');

passwordInput.addEventListener('input', function() {
    const pwd = this.value;
    
    // Mínimo 8 caracteres
    req1.textContent = pwd.length >= 8 ? '✅' : '❌';
    
    // Mayúscula
    req2.textContent = /[A-Z]/.test(pwd) ? '✅' : '❌';
    
    // Número
    req3.textContent = /\d/.test(pwd) ? '✅' : '❌';
    
    // Carácter especial
    req4.textContent = /[^A-Za-z0-9]/.test(pwd) ? '✅' : '❌';
});

// Toggle de visibilidad de contraseña
document.getElementById('togglePassword').addEventListener('click', function() {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
});

// Validación de edad
document.getElementById('fechaNacimiento').addEventListener('change', function() {
    const fecha = new Date(this.value);
    const hoy = new Date();
    let edad = hoy.getFullYear() - fecha.getFullYear();
    const mes = hoy.getMonth() - fecha.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fecha.getDate())) {
        edad--;
    }
    
    const info = document.getElementById('edadInfo');
    if (edad < 13) {
        info.innerHTML = '<span class="text-danger">⚠️ Debes tener al menos 13 años para registrarte</span>';
        info.dataset.valid = 'false';
    } else {
        info.innerHTML = `<span class="text-success">✅ Edad: ${edad} años</span>`;
        info.dataset.valid = 'true';
    }
});

// Validación de coincidencia de contraseñas
document.getElementById('password_confirm').addEventListener('input', function() {
    const matchError = document.getElementById('matchError');
    if (this.value !== passwordInput.value) {
        matchError.style.display = 'block';
    } else {
        matchError.style.display = 'none';
    }
});

// Validación completa del formulario
function validarFormulario() {
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    const edadInfo = document.getElementById('edadInfo');
    const terminos = document.getElementById('terminos').checked;
    
    // Verificar coincidencia de contraseñas
    if (password !== passwordConfirm) {
        alert('Las contraseñas no coinciden');
        return false;
    }
    
    // Verificar edad
    if (edadInfo.dataset.valid === 'false') {
        alert('Debes tener al menos 13 años para registrarte');
        return false;
    }
    
    // Verificar términos
    if (!terminos) {
        alert('Debes aceptar los términos y condiciones');
        return false;
    }
    
    // Deshabilitar botón para evitar doble envío
    document.getElementById('btnRegistrar').disabled = true;
    return true;
}
</script>

<?php include("../componentes/footer.php"); ?>