<?php
require_once(__DIR__ . '/../helpers/Session.php');

include("../componentes/header.php");

$usuario = Session::getUser();
$id = $_GET['id'] ?? $usuario['id_usuario'];
?>

<div class="overlay"></div>

<main class="main-wrapper">
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php if ($_GET['error'] == 'contraseña_incorrecta'): ?>
                La contraseña actual es incorrecta.
            <?php elseif ($_GET['error'] == 'contrasena_no_coincide'): ?>
                Las contraseñas nuevas no coinciden.
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

                                <input type="hidden" name="id" value="<?= $id ?>">

                                <div class="input-style-1 mb-3">
                                    <label>Contraseña actual:</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>

                                <div class="input-style-1 mb-3">
                                    <label>Contraseña nueva:</label>
                                    <input type="password" class="form-control" name="new_password" 
                                           pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                                           title="La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un número y un carácter especial." 
                                           required />
                                </div>

                                <div class="input-style-1 mb-3">
                                    <label>Confirmar contraseña nueva:</label>
                                    <input type="password" class="form-control" name="confirm_new_password" 
                                           pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
                                           title="La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, un número y un carácter especial." 
                                           required />
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