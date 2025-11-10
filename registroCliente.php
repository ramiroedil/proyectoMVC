<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/modelo/ApiClient.php');
require_once(__DIR__ . '/config/config.php');
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $paterno = trim($_POST['paterno'] ?? '');
    $materno = trim($_POST['materno'] ?? '');
    $ci = trim($_POST['ci'] ?? '');
    $username = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $fecha_nacimiento = $_POST['fechanacimiento'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $nit_ci = trim($_POST['nit_ci'] ?? '');
    $razon_social = trim($_POST['razon_social'] ?? '');
    $tipo_cliente = trim($_POST['tipo_cliente'] ?? 'PERSONA');
    $tipo_usuario = 'cliente'; 
    $errores = [];

    if (empty($nombre)) $errores[] = 'El nombre es requerido';
    if (empty($paterno)) $errores[] = 'El apellido paterno es requerido';
    if (empty($ci)) $errores[] = 'La CI es requerida';
    if (empty($username)) $errores[] = 'El usuario es requerido';
    if (empty($password)) $errores[] = 'La contraseña es requerida';
    if (empty($email)) $errores[] = 'El email es requerido';
    if (empty($fecha_nacimiento)) $errores[] = 'La fecha de nacimiento es requerida';
    if (empty($nit_ci)) $errores[] = 'El NIT/CI es requerido';
    if ($tipo_cliente === 'EMPRESA' && empty($razon_social)) $errores[] = 'La razón social es requerida para empresas';

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El formato del email no es válido';
    }

    if (!empty($ci) && !preg_match('/^[0-9]{6,10}$/', $ci)) {
        $errores[] = 'La CI debe contener solo números (6-10 dígitos)';
    }

    if (!empty($nit_ci) && !preg_match('/^[0-9]{6,13}$/', $nit_ci)) {
        $errores[] = 'El NIT/CI debe contener solo números (6-13 dígitos)';
    }

    if (!empty($telefono) && !preg_match('/^[0-9\s\+\-\(\)]{7,20}$/', $telefono)) {
        $errores[] = 'El formato del teléfono no es válido';
    }

    if (strlen($username) < 3 || strlen($username) > 20) {
        $errores[] = 'El usuario debe tener entre 3 y 20 caracteres';
    }

    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $errores[] = 'El usuario solo puede contener letras, números y guión bajo';
    }

    if ($password !== $password_confirm) {
        $errores[] = 'Las contraseñas no coinciden';
    }

    if (strlen($password) < 8) {
        $errores[] = 'La contraseña debe tener mínimo 8 caracteres';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errores[] = 'La contraseña debe contener al menos una mayúscula';
    }
    if (!preg_match('/\d/', $password)) {
        $errores[] = 'La contraseña debe contener al menos un número';
    }
    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
        $errores[] = 'La contraseña debe contener al menos un carácter especial (!@#$%^&*)';
    }
    if (!empty($fecha_nacimiento)) {
        $fecha = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha)->y;
        if ($edad < 13) {
            $errores[] = 'Debes tener al menos 13 años para registrarte';
        }
    }

    if (!empty($errores)) {
        $error_message = implode('<br>', $errores);
    } else {

        try {
            $api = new ApiClient();

            $response = $api->post('/usuario/register', [
                'usuario' => $username,
                'password' => $password,
                'nombre' => $nombre,
                'apellido_paterno' => $paterno,
                'apellido_materno' => $materno,
                'ci' => $ci,
                'fecha_nacimiento' => $fecha_nacimiento,
                'email' => $email,
                'telefono' => $telefono,
                'genero' => $genero,
                'direccion' => $direccion,
                'nit_ci' => $nit_ci,
                'razon_social' => $razon_social,
                'tipo_cliente' => $tipo_cliente,
                'tipo_usuario' => $tipo_usuario
            ], [], false);  

            if ($response['success']) {
                $success_message = '¡Cuenta creada correctamente! Redirigiendo a inicio de sesión...';
                
                header('refresh:2;url=inicio_sesion.php?sw=0');
                
            } else {
                $errorMsg = $response['error'] ?? 'Error desconocido al registrar';
                if (strpos($errorMsg, 'usuario') !== false || strpos($errorMsg, 'username') !== false) {
                    $error_message = '❌ El usuario ya existe. Por favor elige otro.';
                } elseif (strpos($errorMsg, 'email') !== false) {
                    $error_message = '❌ El email ya está registrado. ¿Olvidaste tu contraseña?';
                } elseif (strpos($errorMsg, 'ci') !== false) {
                    $error_message = '❌ La CI ya está registrada en el sistema.';
                } else {
                    $error_message = '❌ Error al registrar: ' . htmlspecialchars($errorMsg);
                }
            }
        } catch (Exception $e) {
            $error_message = '❌ Error de conexión: ' . htmlspecialchars($e->getMessage());
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - Juvenil</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.css">
    <style>
        body {
            background: linear-gradient(135deg, #e85d04 0%, #f48c06 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .registro-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
            max-width: 700px;
            width: 100%;
            padding: 3rem 2rem;
        }

        .registro-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .registro-header h1 {
            color: #e85d04;
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .registro-header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #e85d04;
            box-shadow: 0 0 0 3px rgba(232, 93, 4, 0.1);
            outline: none;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc3545;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #10b981;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            display: none;
        }

        .success-message.show {
            display: block;
        }

        .btn-registrar {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(90deg, #e85d04, #f48c06);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-registrar:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(232, 93, 4, 0.3);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .password-requirements {
            background: #f3f4f6;
            border-left: 4px solid #e85d04;
            padding: 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.25rem 0;
            color: #6b7280;
        }

        .requirement.met {
            color: #10b981;
        }

        .registro-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
        }

        .registro-footer a {
            color: #e85d04;
            text-decoration: none;
            font-weight: 600;
        }

        .registro-footer a:hover {
            color: #ce3a00;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #374151;
            margin-top: 2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
        }

        @media (max-width: 576px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .registro-container {
                padding: 2rem 1.5rem;
            }

            .registro-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <div class="registro-header">
            <a href="../index.php" style="text-decoration: none; color: inherit;">
                <i class="fas fa-cube" style="color: #e85d04; font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                <h1>Juvenil</h1>
            </a>
            <p> Crea tu cuenta y comienza a comprar</p>
        </div>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" id="registroForm">
            <div class="section-title"><i class="fas fa-user-circle"></i> Información Personal</div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user"></i> Nombre *</label>
                    <input type="text" name="nombre" class="form-control" required 
                           placeholder="Tu nombre"
                           value="<?php echo htmlspecialchars($nombre ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user-tag"></i> Apellido Paterno *</label>
                    <input type="text" name="paterno" class="form-control" required 
                           placeholder="Primer apellido"
                           value="<?php echo htmlspecialchars($paterno ?? ''); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user-tag"></i> Apellido Materno</label>
                    <input type="text" name="materno" class="form-control" 
                           placeholder="Segundo apellido (opcional)"
                           value="<?php echo htmlspecialchars($materno ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-id-card"></i> CI *</label>
                    <input type="text" name="ci" class="form-control" required 
                           placeholder="12345678"
                           pattern="[0-9]{6,10}"
                           value="<?php echo htmlspecialchars($ci ?? ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-birthday-cake"></i> Fecha de Nacimiento *</label>
                <input type="date" name="fechanacimiento" class="form-control" required 
                       id="fechaNacimiento"
                       value="<?php echo htmlspecialchars($fecha_nacimiento ?? ''); ?>">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-venus-mars"></i> Género</label>
                    <select name="genero" class="form-select">
                        <option value="">Seleccionar</option>
                        <option value="M" <?php echo (isset($genero) && $genero === 'M') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="F" <?php echo (isset($genero) && $genero === 'F') ? 'selected' : ''; ?>>Femenino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                    <input type="tel" name="telefono" class="form-control" 
                           placeholder="+591 70000000"
                           value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                <input type="text" name="direccion" class="form-control" 
                       placeholder="Calle y número"
                       value="<?php echo htmlspecialchars($_POST['direccion'] ?? ''); ?>">
            </div>
            <div class="section-title"><i class="fas fa-lock"></i> Información de Cuenta</div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-envelope"></i> Email *</label>
                <input type="email" name="email" class="form-control" required 
                       placeholder="tu@email.com"
                       value="<?php echo htmlspecialchars($email ?? ''); ?>">
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-at"></i> Usuario *</label>
                <input type="text" name="usuario" class="form-control" required 
                       placeholder="usuario123"
                       minlength="3" maxlength="20"
                       value="<?php echo htmlspecialchars($username ?? ''); ?>">
                <small class="text-muted">3-20 caracteres (letras, números, _)</small>
            </div>
            <div class="section-title"><i class="fas fa-file-invoice"></i> Información Fiscal</div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-briefcase"></i> Tipo de Cliente *</label>
                <select name="tipo_cliente" class="form-select" id="tipoCliente" required>
                    <option value="PERSONA" <?php echo (isset($tipo_cliente) && $tipo_cliente === 'PERSONA') ? 'selected' : ''; ?>>Persona Natural</option>
                    <option value="EMPRESA" <?php echo (isset($tipo_cliente) && $tipo_cliente === 'EMPRESA') ? 'selected' : ''; ?>>Empresa</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-barcode"></i> NIT/CI *</label>
                <input type="text" name="nit_ci" class="form-control" required 
                       placeholder="Ej: 123456789"
                       pattern="[0-9]{6,13}"
                       value="<?php echo htmlspecialchars($nit_ci ?? ''); ?>">
                <small class="text-muted">Para facturación (6-13 dígitos)</small>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-building"></i> Razón Social</label>
                <input type="text" name="razon_social" class="form-control" 
                       id="razonSocial"
                       placeholder="Nombre de la empresa"
                       value="<?php echo htmlspecialchars($razon_social ?? ''); ?>">
                <small class="text-muted" id="razonSocialHelp">Opcional, requerido solo para empresas</small>
            </div>
            <div class="section-title"><i class="fas fa-shield-alt"></i> Seguridad</div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-lock"></i> Contraseña *</label>
                <input type="password" name="password" class="form-control" id="password" required 
                       placeholder="Contraseña segura">
                <div class="password-requirements">
                    <div class="requirement" id="req-length">
                        <span>❌</span> Mínimo 8 caracteres
                    </div>
                    <div class="requirement" id="req-upper">
                        <span>❌</span> Al menos una mayúscula
                    </div>
                    <div class="requirement" id="req-number">
                        <span>❌</span> Al menos un número
                    </div>
                    <div class="requirement" id="req-special">
                        <span>❌</span> Al menos un carácter especial
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-lock"></i> Confirmar Contraseña *</label>
                <input type="password" name="password_confirm" class="form-control" id="passwordConfirm" required 
                       placeholder="Confirma tu contraseña">
                <small class="text-danger d-none" id="matchError" style="display: block; margin-top: 0.5rem;">
                    <i class="fas fa-exclamation-triangle"></i> Las contraseñas no coinciden
                </small>
            </div>
            <button type="submit" class="btn-registrar">
                <i class="fas fa-user-plus"></i> Crear Cuenta
            </button>
        </form>

        <div class="registro-footer">
            ¿Ya tienes cuenta? <a href="../inicio_sesion.php">Inicia sesión aquí</a>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        const passwordInput = document.getElementById('password');
        const requirements = {
            'req-length': (pwd) => pwd.length >= 8,
            'req-upper': (pwd) => /[A-Z]/.test(pwd),
            'req-number': (pwd) => /\d/.test(pwd),
            'req-special': (pwd) => /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pwd)
        };

        passwordInput.addEventListener('input', function() {
            Object.entries(requirements).forEach(([id, test]) => {
                const element = document.getElementById(id);
                const span = element.querySelector('span');
                if (test(this.value)) {
                    element.classList.add('met');
                    span.textContent = '✅';
                } else {
                    element.classList.remove('met');
                    span.textContent = '❌';
                }
            });

            const matchError = document.getElementById('matchError');
            if (document.getElementById('passwordConfirm').value) {
                if (this.value !== document.getElementById('passwordConfirm').value) {
                    matchError.style.display = 'block';
                } else {
                    matchError.style.display = 'none';
                }
            }
        });

        document.getElementById('passwordConfirm').addEventListener('input', function() {
            const matchError = document.getElementById('matchError');
            if (this.value !== passwordInput.value) {
                matchError.style.display = 'block';
            } else {
                matchError.style.display = 'none';
            }
        });

        const tipoClienteSelect = document.getElementById('tipoCliente');
        const razonSocialInput = document.getElementById('razonSocial');
        const razonSocialHelp = document.getElementById('razonSocialHelp');

        function actualizarRequeridoRazonSocial() {
            if (tipoClienteSelect.value === 'EMPRESA') {
                razonSocialInput.required = true;
                razonSocialInput.parentElement.querySelector('label').innerHTML = 
                    '<i class="fas fa-building"></i> Razón Social <span style="color: #dc3545;">*</span>';
                razonSocialHelp.textContent = 'Requerido para empresas';
            } else {
                razonSocialInput.required = false;
                razonSocialInput.parentElement.querySelector('label').innerHTML = 
                    '<i class="fas fa-building"></i> Razón Social';
                razonSocialHelp.textContent = 'Opcional, requerido solo para empresas';
            }
        }

        tipoClienteSelect.addEventListener('change', actualizarRequeridoRazonSocial);
        actualizarRequeridoRazonSocial();
    </script>
</body>
</html>