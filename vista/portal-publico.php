<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta data-api-url="<?= API_BASE_URL ?>" />
    <meta data-image-url="<?= IMAGE_URL ?>" />
    
    <title>Tienda de Juguetes - Juvenil</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="assets/css/portal-publico.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cube"></i> Juvenil Juguetes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <button class="btn btn-carrito position-relative" data-bs-toggle="modal" data-bs-target="#carritoModal">
                            <i class="fas fa-shopping-cart"></i> Carrito
                            <span class="carrito-badge" id="carrito-count">0</span>
                        </button>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light" href="inicio_sesion.php">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <h1><i class="fas fa-gamepad"></i> Bienvenido a Juvenil</h1>
            <p>Descubre la mayor variedad de juguetes y diversión para todas las edades</p>
        </div>
    </div>
    <div class="container py-4">
        <div class="categorias-container">
            <h3 class="categorias-titulo">
                <i class="fas fa-list"></i> Explora nuestras categorías
            </h3>
            <div class="d-flex flex-wrap gap-3">
                <a href="?cat=todas" 
                   class="btn categoria-btn<?= $activa === 'todas' ? ' active' : '' ?>">
                    <i class="fas fa-th"></i> Todas las categorías
                </a>

                <?php foreach ($categorias as $catId => $catNombre): ?>
                    <a href="?cat=<?= urlencode($catId) ?>"
                       class="btn categoria-btn<?= $catId == $activa ? ' active' : '' ?>">
                        <i class="fas fa-tag"></i> <?= htmlspecialchars($catNombre) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="container mb-3">
        <p class="text-muted">
            <i class="fas fa-info-circle"></i> 
            Mostrando <strong><?= count($productosActivos) ?></strong> producto(s)
            <?php if ($activa !== 'todas' && isset($categorias[$activa])): ?>
                en <span class="badge-categoria"><?= htmlspecialchars($categorias[$activa]) ?></span>
            <?php endif; ?>
        </p>
    </div>

    <div class="container py-4 pb-5">
        <?php if (!empty($productosActivos)): ?>
            <div class="row g-4" id="productosContainer">
                <?php foreach ($productosActivos as $prod): 

                    $imagen = $prod['imagen'] ?? null;
                    $imagenUrl = !empty($imagen) ? IMAGE_URL . htmlspecialchars($imagen) : IMAGE_DEFAULT;
                ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card card-producto">
                       
                                <?php if (!empty($prod['imagen'])): ?>
                                    <img src="<?= $imagenUrl; ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($prod['nombre']) ?>"
                                         onerror="console.error('Error cargando:', this.src); this.src='<?= IMAGE_DEFAULT ?>'; this.onerror=null;"
                                         onload="console.log('✅ Imagen cargada:', this.src)">
                                <?php else: ?>
                                    <div class="producto-sin-imagen">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
            
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title" style="color: #e85d04;">
                                        <?= htmlspecialchars($prod['nombre']) ?>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        <?= htmlspecialchars(substr($prod['descripcion'] ?? '', 0, 50)) ?>...
                                    </p>
                                    
                                    <p class="mb-2">
                                        <small>
                                            <span class="badge-categoria">
                                                <?= htmlspecialchars($prod['categoria']['nombre'] ?? 'Sin categoría') ?>
                                            </span>
                                        </small>
                                    </p>

                                    <div class="mt-auto">
                                        <p class="precio mb-2">Bs <?= number_format($prod['precio_venta'], 2) ?></p>
                                        
                                        <?php if ($prod['stock'] > 0): ?>
                                            <button class="btn btn-agregar btn-sm w-100 mb-2" 
                                                    onclick="agregarAlCarrito(<?= $prod['id'] ?>, '<?= htmlspecialchars(addslashes($prod['nombre'])) ?>', <?= $prod['precio_venta'] ?>)">
                                                <i class="fas fa-cart-plus"></i> Agregar al carrito
                                            </button>
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> Stock: <?= $prod['stock'] ?>
                                            </small>
                                        <?php else: ?>
                                            <button class="btn btn-danger btn-sm w-100" disabled>
                                                <i class="fas fa-ban"></i> Agotado
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>

            <div class="sin-productos">
                <i class="fas fa-inbox"></i>
                <h4>No hay productos disponibles</h4>
                <p class="text-muted">Por favor, selecciona otra categoría</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="carritoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-carrito">

                <div class="modal-header" style="background: linear-gradient(90deg, #e85d04, #f48c06); color: white; border: none;">
                    <h5 class="modal-title"><i class="fas fa-shopping-cart"></i> Mi Carrito</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="carrito-contenido">
                    <div class="alert alert-info-carrito">
                        <i class="fas fa-info-circle"></i> 
                        Puedes agregar productos sin iniciar sesión, pero necesitarás ingresar tu cuenta para completar la compra.
                    </div>
                    <div id="lista-carrito"></div>
                </div>


                <div class="modal-footer" style="background: #f8f9fa; border-top: 2px solid #ffe066;">
                    <div class="w-100 mb-3" id="total-carrito"></div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir Comprando</button>
                    <button type="button" class="btn btn-login-compra" id="btn-comprar">
                        <i class="fas fa-credit-card"></i> Proceder a Comprar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/portal-publico.js"></script>
</body>
</html>