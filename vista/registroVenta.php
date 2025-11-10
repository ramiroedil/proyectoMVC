<?php
require_once(__DIR__ . '/../helpers/Session.php');
Session::start();


include("../componentes/header.php");
?>

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .product-img-container {
        height: 250px;
        overflow: hidden;
        background: #f0f0f0;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img-container img {
        transform: scale(1.05);
    }

    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
    }

    .stock-badge.low {
        background: #ffc107;
        color: black;
    }

    .stock-badge.out {
        background: #dc3545;
    }

    .btn-agregar {
        width: 100%;
        margin-top: 10px;
    }

    .cantidad-input {
        max-width: 80px;
    }

    .precio-producto {
        font-size: 1.5rem;
        color: #28a745;
        font-weight: bold;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-shopping-bag"></i> PRODUCTOS DISPONIBLES</h2>
                    <p class="text-muted">Selecciona los productos que deseas comprar</p>
                </div>
                <div>
                    <a href="../vista/carrito_ventas.php" class="btn btn-success btn-lg">
                        <i class="fas fa-shopping-cart"></i> Ver Carrito
                        <?php
                        $items_carrito = Session::has('carrito_ventas1') ? count(Session::get('carrito_ventas1')) : 0;
                        if ($items_carrito > 0) {
                            echo " <span class='badge bg-warning text-dark ms-2'>$items_carrito</span>";
                        }
                        ?>
                    </a>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <?php if (empty($productos)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>No hay productos disponibles</strong>
            <p>En este momento no tenemos productos en stock.</p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <?php
                $imagen = $producto['imagen'] ?? null;
                $imagenUrl = !empty($imagen) ? IMAGE_URL . htmlspecialchars($imagen) : IMAGE_DEFAULT;
                $stock = intval($producto['stock'] ?? 0);
                $enStock = $stock > 0;
                $stockBajo = $stock > 0 && $stock <= 5;
                ?>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
          
                        <div class="product-img-container position-relative">
                            <img src="<?= $imagenUrl; ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($producto['nombre']); ?>"
                                onerror="console.error('❌ Error cargando imagen:', this.src); this.src='<?= IMAGE_DEFAULT ?>'; this.onerror=null;"
                                onload="console.log('✅ Imagen cargada:', this.src)">

                            <?php if (!$enStock): ?>
                                <span class="stock-badge out">AGOTADO</span>
                            <?php elseif ($stockBajo): ?>
                                <span class="stock-badge low">POCAS UNIDADES</span>
                            <?php else: ?>
                                <span class="stock-badge">EN STOCK</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($producto['nombre']); ?></h5>

                            <?php if (!empty($producto['descripcion'])): ?>
                                <p class="card-text small text-muted">
                                    <?= htmlspecialchars(substr($producto['descripcion'], 0, 80)); ?>
                                    <?= strlen($producto['descripcion']) > 80 ? '...' : ''; ?>
                                </p>
                            <?php endif; ?>

                            <div class="product-details mb-3">
                                <p class="mb-1">
                                    <span class="precio-producto">Bs <?= number_format($producto['precio_venta'], 2); ?></span>
                                </p>
                                <?php if (!empty($producto['marca'])): ?>
                                    <p class="mb-1 small">
                                        <i class="fas fa-tag"></i> <strong>Marca:</strong> <?= htmlspecialchars($producto['marca']); ?>
                                    </p>
                                <?php endif; ?>
                                <p class="mb-0 text-muted">
                                    <small>
                                        <i class="fas fa-cube"></i> Stock: <strong><?= $stock; ?> unidades</strong>
                                    </small>
                                </p>
                            </div>

                            <form method="POST" action="../controlador/controlaventaCarrito.php" class="mt-auto">
                               
                                <input type="hidden" name="id_producto" value="<?= $producto['id']; ?>">
                                <input type="hidden" name="nombrep" value="<?= htmlspecialchars($producto['nombre']); ?>">
                                <input type="hidden" name="descripcion" value="<?= htmlspecialchars($producto['descripcion'] ?? ''); ?>">
                                <input type="hidden" name="precio" value="<?= $producto['precio_venta']; ?>">
                                <input type="hidden" name="imagen" value="<?= htmlspecialchars($imagen ?? ''); ?>">

                                <?php if ($enStock): ?>
                                    <div class="input-group mb-2">
                                        <input type="number" 
                                            name="cantidad" 
                                            class="form-control cantidad-input" 
                                            value="1" 
                                            min="1" 
                                            max="<?= $stock; ?>"
                                            required>
                                        <button type="submit" class="btn btn-primary" title="Agregar al carrito">
                                            <i class="fas fa-shopping-cart"></i> Agregar
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <button type="button" class="btn btn-danger btn-agregar" disabled>
                                        <i class="fas fa-times"></i> Agotado
                                    </button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    console.log('%c🛍️  Producto ID <?= $producto["id"] ?>', 'color: #0066ff; font-weight: bold;');
                    console.log('   Nombre:', '<?= htmlspecialchars($producto["nombre"]); ?>');
                    console.log('   Imagen:', '<?= htmlspecialchars($imagen ?? 'NULL'); ?>');
                    console.log('   URL:', '<?= $imagenUrl; ?>');
                    console.log('   Stock:', <?= $stock; ?>);
                </script>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- <script>
    console.log('%c═══════════════════════════════════════', 'color: #00ff00;');
    console.log('%c REGISTRO VENTA - INFORMACIÓN GLOBAL', 'color: #00ff00; font-weight: bold;');
    console.log('%c═══════════════════════════════════════', 'color: #00ff00;');
    console.log('IMAGE_URL:', '<?= IMAGE_URL ?>');
    console.log('API_BASE_URL:', '<?= API_BASE_URL ?>');
    console.log('Total productos:', <?= count($productos); ?>);
    console.log('Productos:', <?= json_encode($productos, JSON_UNESCAPED_UNICODE); ?>);
    console.log('%c═══════════════════════════════════════', 'color: #00ff00;');
</script> -->
<script src="assets/js/recuperar-carrito.js"></script>
<?php include("../componentes/footer.php"); ?>      