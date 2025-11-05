<?php
session_start();
include("assets/componentes/header.php");

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];
$total = 0;

// Calcular total
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}
?>

<style>
.carrito-title {
    color: #e85d04;
    font-weight: 800;
    text-shadow: 0 2px 8px rgba(252,185,0, .13);
}
.carrito-container {
    background: linear-gradient(135deg, #fffbe6 0%, #fff9e6 100%);
    border: 2px solid #fde68a;
    border-radius: 1.5rem;
    box-shadow: 0 6px 24px rgba(253, 230, 138, 0.15);
    padding: 2rem;
}
.item-carrito {
    background: #fff;
    border: 2px solid #ffe066;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 12px rgba(255, 224, 102, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}
.item-carrito:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(255, 224, 102, 0.2);
}
.btn-cantidad {
    background: #f48c06;
    color: white;
    border: none;
    border-radius: 0.5rem;
    width: 35px;
    height: 35px;
    font-weight: bold;
    transition: background 0.2s;
}
.btn-cantidad:hover {
    background: #e85d04;
    color: white;
}
.btn-eliminar {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-weight: bold;
    transition: background 0.2s;
}
.btn-eliminar:hover {
    background: #c82333;
    color: white;
}
.btn-comprar {
    background: linear-gradient(90deg, #28a745, #20c997);
    color: white;
    border: none;
    border-radius: 1rem;
    padding: 1rem 2rem;
    font-size: 1.2rem;
    font-weight: bold;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}
.btn-comprar:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: white;
}
.total-section {
    background: linear-gradient(90deg, #e85d04, #f48c06);
    color: white;
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(232, 93, 4, 0.3);
}
.carrito-vacio {
    text-align: center;
    color: #6c757d;
    font-size: 1.2rem;
    padding: 3rem;
}
.carrito-vacio i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}
</style>

<main class="container py-4">
    <h1 class="text-center mb-4 carrito-title">
        <i class="fas fa-shopping-cart"></i> Mi Carrito de Compras
    </h1>
    
    <div class="carrito-container">
        <?php if (empty($carrito)): ?>
            <div class="carrito-vacio">
                <i class="fas fa-shopping-cart"></i>
                <h3>Tu carrito está vacío</h3>
                <p>¡Agrega algunos juguetes increíbles!</p>
                <a href="productos.php" class="btn btn-primary btn-lg mt-3">
                    <i class="fas fa-cubes"></i> Ver Productos
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-4" style="color: #e85d04;">
                        <i class="fas fa-list"></i> Productos en tu carrito
                    </h3>
                    
                    <?php foreach ($carrito as $key => $item): ?>
                        <div class="item-carrito">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?= $item['img'] ?>" alt="<?= $item['nombre'] ?>" 
                                         class="img-fluid rounded" style="max-height: 80px; object-fit: cover;">
                                </div>
                                <div class="col-md-4">
                                    <h5 style="color: #e85d04; font-weight: bold;"><?= $item['nombre'] ?></h5>
                                    <p class="text-muted mb-0"><?= $item['desc'] ?></p>
                                </div>
                                <div class="col-md-2">
                                    <p class="mb-0" style="color: #28a745; font-weight: bold;">
                                        <?= number_format($item['precio'], 2) ?> Bs
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="button" class="btn-cantidad me-2" 
                                                onclick="actualizarCantidad(<?= $key ?>, -1)">-</button>
                                        <span class="fw-bold mx-2"><?= $item['cantidad'] ?></span>
                                        <button type="button" class="btn-cantidad ms-2" 
                                                onclick="actualizarCantidad(<?= $key ?>, 1)">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="mb-2" style="color: #e85d04; font-weight: bold;">
                                        <?= number_format($item['precio'] * $item['cantidad'], 2) ?> Bs
                                    </p>
                                    <button type="button" class="btn-eliminar btn-sm" 
                                            onclick="eliminarItem(<?= $key ?>)">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="col-lg-4">
                    <div class="total-section">
                        <h3><i class="fas fa-calculator"></i> Resumen de Compra</h3>
                        <hr style="border-color: rgba(255,255,255,0.3);">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span><?= number_format($total, 2) ?> Bs</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío:</span>
                            <span>Gratis</span>
                        </div>
                        <hr style="border-color: rgba(255,255,255,0.5);">
                        <div class="d-flex justify-content-between mb-3">
                            <strong style="font-size: 1.2rem;">Total:</strong>
                            <strong style="font-size: 1.2rem;"><?= number_format($total, 2) ?> Bs</strong>
                        </div>
                        <button type="button" class="btn-comprar w-100" onclick="procederCompra()">
                            <i class="fas fa-credit-card"></i> Proceder a Comprar
                        </button>
                    </div>
                    
                    <div class="mt-3 text-center">
                        <a href="productos.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Seguir Comprando
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
function actualizarCantidad(index, cambio) {
    fetch('ajax/actualizar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'actualizar_cantidad',
            index: index,
            cambio: cambio
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function eliminarItem(index) {
    if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
        fetch('ajax/actualizar_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'eliminar_item',
                index: index
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function procederCompra() {
    // Aquí puedes agregar la lógica de compra
    alert('¡Gracias por tu compra! En un proyecto real, aquí se procesaría el pago.');
    
    // Vaciar carrito después de la compra
    fetch('ajax/actualizar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'vaciar_carrito'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<?php include("assets/componentes/footer.php"); ?>