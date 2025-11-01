<?php
include("../componentes/header.php");
require_once(__DIR__ . '/../modelo/conexion.php');
$conexion = new Conexion();
$id = $_GET['id'];
$consulta = "SELECT * FROM usuarios WHERE id_usuario = '" . $id . "'";
$datos = mysqli_query($conexion, $consulta);
$uEdit = mysqli_fetch_array($datos);
?>

<div class="overlay"></div>

<main class="main-wrapper">

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php if ($_GET['error'] == 'contraseña_incorrecta'): ?>
                La contraseña actual es incorrecta.
            <?php elseif ($_GET['error'] == 'contrasena_no_coincide'): ?>
                Las contraseñas nuevas no coinciden.
            <?php elseif ($_GET['error'] == 'usuario_no_encontrado'): ?>
                Usuario no encontrado.
            <?php elseif ($_GET['error'] == 'fallo_actualizacion'): ?>
                Error al actualizar la contraseña.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <section class="tab-components">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Modificar Contraseña</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="../controlador/user_pass.php" method="post">
                            <div class="card-style mb-30">
                                <h6 class="mb-25">Cambiar Contraseña</h6>

                                <input type="hidden" name="id" value="<?= $uEdit['id_usuario'] ?>">
                                <input type="hidden" name="nombre" value="<?= $uEdit['nombre'] ?>">
                                <input type="hidden" name="nombreusuario" value="<?= $uEdit['nombreusuario'] ?>">
                                <input type="hidden" name="tipousuario" value="<?= $uEdit['tipousuario'] ?>">

                                <div class="input-style-1">
                                    <label>Contraseña actual:</label>
                                    <input type="password" name="current_password"  id="current_password" required>
                                    <i class="fa fa-eye" id="icono1"></i>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="togglePassword1"></button>
                                </div>

                                <div class="input-style-1">
                                    <label>Contraseña nueva:</label>
                                    
                                    <div class="col-sm-10 input">
                                        <input type="password" class="form-control" name="new_password" id="password"
                                            required pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                                            title="La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un numero y un carácter especial." required /><i
                                            class="fa fa-eye" id="icono"></i>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="togglePassword"></button>
                                    </div>
                                </div>

                                <div class="input-style-1">
                                    <label>Confirmar contraseña nueva:</label>
                                    <div class="col-sm-10 input">
                                        <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password"
                                            required pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                                            title="La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un numero y un carácter especial." required /><i
                                            class="fa fa-eye" id="icono2"></i>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="togglePassword2"></button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('¿Está seguro de que quiere cambiar su contraseña?')">
                                    Cambiar contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("../componentes/footer.php"); ?>
</main>

<!-- Scripts -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/Chart.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const icon = document.getElementById('icono');
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>
<script>
    const togglePassword1 = document.getElementById('togglePassword1');
    const passwordInput1 = document.getElementById('current_password');
    const icon1 = document.getElementById('icono1');
    togglePassword1.addEventListener('click', function () {
        const type1 = passwordInput1.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput1.setAttribute('type', type1);
        icon1.classList.toggle('fa-eye');
        icon1.classList.toggle('fa-eye-slash');
    });
</script>
<script>
    const togglePassword2 = document.getElementById('togglePassword2');
    const passwordInput2 = document.getElementById('confirm_new_password');
    const icon2 = document.getElementById('icono2');
    togglePassword2.addEventListener('click', function () {
        const type2 = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput2.setAttribute('type', type2);
        icon2.classList.toggle('fa-eye');
        icon2.classList.toggle('fa-eye-slash');
    });
</script>