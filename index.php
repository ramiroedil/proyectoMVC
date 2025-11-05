<?php
session_start();

// Inicializar carrito de sesión si no existe
if (!isset($_SESSION['carrito_publico'])) {
    $_SESSION['carrito_publico'] = [];
}

// Simular productos desde una base de datos
$categorias = [
    "Para Niños", "Para Niñas", "Para bebés", "Figuras de acción",
    "Juegos de mesa", "Vehículos", "Muñecas y accesorios", "Peluches",
    "Juegos al aire libre", "Artes y manualidades", "Educativos", "Bloques y legos"
];

$productos = [
    "Para Niños" => [
        ["id" => 1, "nombre" => "Camión de Bomberos", "img" => "assets/imagenes/niño1.jpg", "precio" => 45, "desc" => "Con luces y sonidos."],
        ["id" => 2, "nombre" => "Dinosaurios Armables", "img" => "assets/imagenes/niño2.jpg", "precio" => 38.5, "desc" => "Set de construcción."],
        ["id" => 3, "nombre" => "Pistola de Agua", "img" => "assets/imagenes/niño3.jpg", "precio" => 22, "desc" => "Gran alcance y fácil de llenar."],
    ],
    "Para Niñas" => [
        ["id" => 4, "nombre" => "Casa de Muñecas", "img" => "assets/imagenes/niña1.jpg", "precio" => 65, "desc" => "Con accesorios."],
        ["id" => 5, "nombre" => "Set de Belleza Infantil", "img" => "assets/imagenes/niña2.jpg", "precio" => 22, "desc" => "Incluye peine, espejo y maquillaje no tóxico."],
    ],
    "Figuras de acción" => [
        ["id" => 6, "nombre" => "Figura Spider-Man", "img" => "assets/imagenes/herue1.jpg", "precio" => 25.9, "desc" => "Superhéroe articulado."],
        ["id" => 7, "nombre" => "Figura Batman", "img" => "assets/imagenes/herue2.jpg", "precio" => 28, "desc" => "Incluye capa y batarang."],
    ],
];

$activa = isset($_GET['cat']) && in_array($_GET['cat'], $categorias) ? $_GET['cat'] : $categorias[0];

// Procesamiento de AJAX para agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'agregar_carrito') {
        $producto_id = intval($_POST['producto_id']);
        $cantidad = intval($_POST['cantidad'] ?? 1);
        
        // Buscar el producto en todas las categorías
        $producto_encontrado = null;
        foreach ($productos as $items) {
            foreach ($items as $prod) {
                if ($prod['id'] === $producto_id) {
                    $producto_encontrado = $prod;
                    break 2;
                }
            }
        }
        
        if ($producto_encontrado && $cantidad > 0) {
            // Verificar si ya existe en el carrito
            $existe = false;
            foreach ($_SESSION['carrito_publico'] as &$item) {
                if ($item['id'] === $producto_id) {
                    $item['cantidad'] += $cantidad;
                    $existe = true;
                    break;
                }
            }
            
            if (!$existe) {
                $_SESSION['carrito_publico'][] = [
                    'id' => $producto_id,
                    'nombre' => $producto_encontrado['nombre'],
                    'precio' => $producto_encontrado['precio'],
                    'cantidad' => $cantidad,
                    'imagen' => $producto_encontrado['img']
                ];
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'carrito_count' => count($_SESSION['carrito_publico'])
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al agregar el producto'
            ]);
        }
        exit();
    }
    
    if ($_POST['action'] === 'obtener_carrito') {
        echo json_encode([
            'success' => true,
            'carrito' => $_SESSION['carrito_publico'],
            'count' => count($_SESSION['carrito_publico'])
        ]);
        exit();
    }
    
    if ($_POST['action'] === 'eliminar_carrito') {
        $producto_id = intval($_POST['producto_id']);
        $_SESSION['carrito_publico'] = array_filter($_SESSION['carrito_publico'], 
            function($item) use ($producto_id) {
                return $item['id'] !== $producto_id;
            }
        );
        $_SESSION['carrito_publico'] = array_values($_SESSION['carrito_publico']);
        
        echo json_encode([
            'success' => true,
            'message' => 'Producto eliminado',
            'carrito_count' => count($_SESSION['carrito_publico'])
        ]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Juguetes - Juvenil</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="vendor/fontawesome-free-5.15.4-web/css/all.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-custom {
            background: linear-gradient(90deg, #e85d04, #f48c06);
            box-shadow: 0 2px 8px rgba(232, 93, 4, 0.2);
        }
        
        .navbar-custom .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .btn-carrito {
            position: relative;
            background: white;
            color: #e85d04;
            border: 2px solid white;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .btn-carrito:hover {
            background: #e85d04;
            color: white;
        }
        
        .carrito-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }
        
        .categoria-btn {
            border: 2px solid #343a40;
            color: #343a40;
            background: #fff;
            transition: all 0.2s;
            font-weight: bold;
        }
        
        .categoria-btn:hover, .categoria-btn.active {
            background: #17a2b8;
            color: #fff;
            border-color: #17a2b8;
            text-decoration: none;
        }
        
        .card-producto {
            border: 2px solid #ffe066;
            border-radius: 1rem;
            background: #fffbe6;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        
        .card-producto:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 224, 102, 0.3);
        }
        
        .card-producto img {
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #ffe066;
        }
        
        .precio {
            color: #28a745;
            font-size: 1.3rem;
            font-weight: bold;
        }
        
        .btn-agregar {
            background: #f39c12;
            color: white;
            font-weight: bold;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-agregar:hover {
            background: #e85d04;
            color: white;
        }
        
        .modal-carrito {
            background: linear-gradient(135deg, #fffbe6 0%, #fff9e6 100%);
        }
        
        .item-carrito-modal {
            background: white;
            border-left: 4px solid #e85d04;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
        }
        
        .btn-login-compra {
            background: linear-gradient(90deg, #28a745, #20c997);
            color: white;
            font-weight: bold;
            border: none;
            padding: 0.75rem 2rem;
        }
        
        .btn-login-compra:hover {
            background: linear-gradient(90deg, #20c997, #28a745);
            color: white;
        }
        
        .alert-info-carrito {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #e85d04 0%, #f48c06 100%);
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .hero-section p {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
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

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1><i class="fas fa-gamepad"></i> Bienvenido a Juvenil</h1>
            <p>Descubre la mayor variedad de juguetes y diversión para todas las edades</p>
        </div>
    </div>

    <!-- Categorías -->
    <div class="container py-4">
        <h3 class="mb-3" style="color: #e85d04;">Explora nuestras categorías</h3>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <?php foreach ($categorias as $cat): ?>
                <a href="?cat=<?= urlencode($cat) ?>"
                   class="btn rounded-pill categoria-btn px-3 py-2<?= $cat == $activa ? ' active' : '' ?>">
                    <?= $cat ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Productos -->
    <div class="container py-4">
        <div class="row g-4">
            <?php if (!empty($productos[$activa])): ?>
                <?php foreach ($productos[$activa] as $prod): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-producto">
                            <img src="<?= $prod['img'] ?>" class="card-img-top" alt="<?= $prod['nombre'] ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" style="color: #e85d04;"><?= $prod['nombre'] ?></h5>
                                <p class="card-text text-muted"><?= $prod['desc'] ?></p>
                                <p class="precio mt-auto"><?= number_format($prod['precio'], 2) ?> Bs</p>
                                <button class="btn btn-agregar btn-sm w-100 mt-2" 
                                        onclick="agregarAlCarrito(<?= $prod['id'] ?>, '<?= htmlspecialchars($prod['nombre']) ?>', <?= $prod['precio'] ?>)">
                                    <i class="fas fa-cart-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">
                    <p>No hay productos en esta categoría.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal del Carrito -->
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
                    <button type="button" class="btn btn-login-compra" id="btn-comprar" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-credit-card"></i> Proceder a Comprar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'componentes/modal_login_carrito.php'; ?>

    <!-- Scripts -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        function agregarAlCarrito(productoId, nombre, precio) {
            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=agregar_carrito&producto_id=${productoId}&cantidad=1`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarNotificacion('success', `"${nombre}" agregado al carrito`);
                    actualizarCarrito();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function actualizarCarrito() {
            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=obtener_carrito'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('carrito-count').textContent = data.count;
                    renderizarCarrito(data.carrito);
                }
            });
        }

        function renderizarCarrito(carrito) {
            const listaCarrito = document.getElementById('lista-carrito');
            const totalCarrito = document.getElementById('total-carrito');
            
            if (carrito.length === 0) {
                listaCarrito.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x" style="color: #ddd;"></i>
                        <p class="mt-3 text-muted">Tu carrito está vacío</p>
                    </div>
                `;
                totalCarrito.innerHTML = '';
                return;
            }

            let html = '';
            let total = 0;

            carrito.forEach(item => {
                const subtotal = item.precio * item.cantidad;
                total += subtotal;
                
                html += `
                    <div class="item-carrito-modal">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="${item.imagen}" alt="${item.nombre}" class="img-fluid rounded" style="max-height: 60px; object-fit: cover;">
                            </div>
                            <div class="col-md-4">
                                <strong>${item.nombre}</strong>
                                <p class="mb-0 text-muted small">Bs ${item.precio.toFixed(2)}</p>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="badge bg-primary">${item.cantidad}</span>
                            </div>
                            <div class="col-md-2">
                                <strong style="color: #e85d04;">Bs ${subtotal.toFixed(2)}</strong>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-sm btn-danger" onclick="eliminarDelCarrito(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            listaCarrito.innerHTML = html;
            
            totalCarrito.innerHTML = `
                <div class="alert alert-warning mb-0">
                    <strong style="font-size: 1.2rem;">Total: Bs ${total.toFixed(2)}</strong>
                </div>
            `;
        }

        function eliminarDelCarrito(productoId) {
            if (confirm('¿Deseas eliminar este producto del carrito?')) {
                fetch('index.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=eliminar_carrito&producto_id=${productoId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarNotificacion('success', data.message);
                        actualizarCarrito();
                    }
                });
            }
        }

        function mostrarNotificacion(tipo, mensaje) {
            const notificacion = document.createElement('div');
            notificacion.className = `alert alert-${tipo === 'success' ? 'success' : 'danger'} position-fixed`;
            notificacion.style.cssText = 'top: 20px; right: 20px; z-index: 9999; width: auto; min-width: 300px;';
            notificacion.innerHTML = `
                <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${mensaje}
            `;
            
            document.body.appendChild(notificacion);
            
            setTimeout(() => {
                notificacion.remove();
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            actualizarCarrito();
        });
    </script>
</body>
</html> 