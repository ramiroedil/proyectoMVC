<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['token'])) {
    header('Location: index.php?sw=2');
    exit();
}
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juvenil</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="vendor/fontawesome-free-5.15.4-web/css/all.css">
</head>

<body>
    <aside class="offcanvas offcanvas-start" id="menuLateral">
        <div class="offcanvas-header text-center w-100">
            <div class="offcanvas-title w-100">
                <a href="inicio.php">
                    <img src="assets/images/logo/logo.svg" alt="logo">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="btn-group-vertical mb-3 d-flex">
                <?php
                if ($usuario['tipousuario'] == 'administrador') {
                    ?>
                    <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                        href="controlador/usuarioLista.php">USUARIOS
                    </a>
                    <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                        href="controlador/ventaLista.php">LISTA DE VENTAS
                    </a>
                    <?php
                }
                ?>
            </div>
            <div class="btn-group-vertical mb-3 d-flex"><a type="button"
                    class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/cargoLista.php">CARGO</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/clienteLista.php">CLIENTE</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/empleadoLista.php">EMPLEADOS</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/productoLista.php">PRODUCTO
                </a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/proveedorLista.php">PROVEEDOR
                </a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/controladorVenta.php">VENTAS
                </a>
            </div>
        </div>
    </aside>
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 ">
                    <a href="inicio.php" class="main-btn text-center w-100">
                        <img src="assets/images/logo/logo.svg" alt="logo">
                    </a>
                </div>
                <div class="col-lg-3">
                    <button data-bs-toggle="offcanvas" data-bs-target="#menuLateral" class="">
                        <i class="btn btn-primary main-btn">
                            <h3>Menu</h3>
                        </i>
                    </button>
                </div>
                <div class="col-lg-5">
                    <div class="header-right">
                        <div class="profile-box ml-15">
                            <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-info">
                                    <div class="info">
                                        <div class="image">
                                            <img src="imagenes/administrador.jpg" alt="" />
                                        </div>
                                        <div>
                                            <h6 class="fw-500"><?= $usuario['nombre'] ?></h6>
                                            <p><?= $usuario['tipousuario'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                <li>
                                    <div class="author-info flex items-center !p-1">
                                        <div class="image">
                                            <img src="imagenes/administrador.jpg" alt="image">
                                        </div>
                                        <div class="content">
                                            <h4 class="text-sm"><?= $usuario['nombreusuario'] ?></h4>
                                            <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                                                href="#"><?= $usuario['email'] ?></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="vista/pass_edit.php?id=<?= $usuario['id_usuario'] ?>"> <i
                                            class="lni lni-cog"></i> Cambiar
                                        contraseña </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="componentes/logout.php"> <i class="lni lni-exit"></i> Logout </a>
                                </li>
                            </ul>
                        </div>
                        <!-- profile end -->
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <?php
                    if ($usuario['tipousuario'] == 'administrador') {
                        ?>
                        <div class="alert alert-danger text-center">
                            <h1>BIENVENIDO ADMINISTRADOR</h1>
                        </div>
                        <?php
                    }
                    if ($usuario['tipousuario'] == 'cajero') {
                        ?>
                        <div class="alert alert-warning text-center">
                            <h1>BIENVENIDO CAJERO</h1>
                        </div>
                        <?php
                    }
                    if ($usuario['tipousuario'] == 'cliente') {
                        ?>
                        <div class="alert alert-success text-center">
                            <h1>BIENVENIDO CLIENTE</h1>
                        </div>
                        <?php
                    }
                ?>
                </div>
                </div>
                <div>
                    
    </main>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 order-last order-md-first">
                    <div class="copyright text-center my-auto">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="terms d-flex justify-content-center justify-content-md-end">
                        <a href="#0" class="text-sm">Term & Conditions</a>
                        <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/dynamic-pie-chart.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/fullcalendar.js"></script>
<script src="assets/js/jvectormap.min.js"></script>
<script src="assets/js/world-merc.js"></script>
<script src="assets/js/polyfill.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/Chart.min.js"></script>