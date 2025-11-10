<?php
require_once(__DIR__ . '/helpers/Session.php');

if (!Session::isAuthenticated()) {
    header('Location: ../index.php?sw=2');
    exit();
}

$usuarioActual = Session::getUser();
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
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.css">
</head>

<body class="d-flex flex-column" style="height: 100vh">
    <aside class="offcanvas offcanvas-start" id="menuLateral">
        <div class="offcanvas-header text-center w-100">
            <div class="offcanvas-title w-100">
                <a href="../inicio.php">
                    <img src="assets/images/logo/logo.svg" alt="logo">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="btn-group-vertical mb-3 d-flex">
                <?php if ($usuarioActual['tipousuario'] == 'empleado'): ?>
                    <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                        href="controlador/usuarioLista.php">USUARIOS</a>
                    <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                        href="controlador/ventaLista.php">LISTA DE VENTAS</a>
                <?php endif; ?>
            </div>
            <div class="btn-group-vertical mb-3 d-flex">
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/cargoLista.php">CARGO</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/clienteLista.php">CLIENTE</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/empleadoLista.php">EMPLEADOS</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/productoLista.php">PRODUCTO</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/proveedorLista.php">PROVEEDOR</a>
                <a type="button" class="btn btn-white btn-outline-secondary text-primary fw-bold"
                    href="controlador/controladorVenta.php">VENTAS</a>
            </div>
        </div>
    </aside>
    
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <a href="index.php" class="main-btn text-center w-100">
                        <img src="assets/images/logo/logo.svg" alt="logo">
                    </a>
                </div>
                <div class="col-lg-3">
                    <button data-bs-toggle="offcanvas" data-bs-target="#menuLateral" class="btn btn-primary rounded">
                        <h3>Menu</h3>
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
                                            <h6 class="fw-500"><?= $usuarioActual['nombre'] ?></h6>
                                            <p><?= $usuarioActual['tipousuario'] ?></p>
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
                                            <h4 class="text-sm"><?= $usuarioActual['nombreusuario'] ?></h4>
                                            <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                                                href="#"><?= $usuarioActual['email'] ?></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="componentes/logout.php"> <i class="lni lni-exit"></i> Logout </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container-fluid">            <div class="row">
                <div class="col-12">
                    <?php
                    // Mensaje de bienvenida basado en el cargo
                    if ($usuarioActual['tipousuario'] === 'empleado') {
                        $cargoNombre = $usuarioActual['cargo']['nombre'] ?? 'Empleado';
                        $alertClass = 'alert-info';
                        
                        if ($cargoNombre === 'Administrador') {
                            $alertClass = 'alert-danger';
                        } elseif (in_array($cargoNombre, ['Gerente', 'Cajero'])) {
                            $alertClass = 'alert-warning';
                        }
                        ?>
                        <div class="alert <?= $alertClass ?> text-center">
                            <h1>BIENVENIDO <?= strtoupper(htmlspecialchars($cargoNombre)) ?></h1>
                            <p class="mb-0"><?= htmlspecialchars($usuarioActual['nombre'] . ' ' . $usuarioActual['apellido_paterno']) ?></p>
                        </div>
                        <?php
                    } elseif ($usuarioActual['tipousuario'] === 'cliente') {
                        ?>
                        <div class="alert alert-success text-center">
                            <h1>BIENVENIDO CLIENTE</h1>
                            <p class="mb-0"><?= htmlspecialchars($usuarioActual['nombre'] . ' ' . $usuarioActual['apellido_paterno']) ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            
            <!-- Contenido adicional del dashboard -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Estado del Sistema</h5>
                            <p class="card-text">
                                Estado de cuenta: <span class="badge bg-success"><?= $usuarioActual['estado'] ?></span>
                            </p>
                            <?php if ($usuarioActual['tipousuario'] === 'empleado' && !empty($usuarioActual['permisos'])): ?>
                            <div class="mt-3">
                                <h6>Permisos asignados:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($usuarioActual['permisos'] as $permiso): ?>
                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($permiso) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 order-last order-md-first">
                    <div class="copyright text-center my-auto">
                        <p>&copy; <?= date('Y') ?> Edil Rosales Zambrana    . Todos los derechos reservados.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="terms d-flex justify-content-center justify-content-md-end">
                        <a href="#0" class="text-sm">Términos & Condiciones</a>
                        <a href="#0" class="text-sm ml-15">Política de Privacidad</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
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
</body>

</html>