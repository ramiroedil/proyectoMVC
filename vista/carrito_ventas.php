<?php

require_once(__DIR__ . '/../helpers/Session.php');
require_once(__DIR__ . '/../config/config.php');
Session::start();

$carrito = Session::get('carrito_ventas1', []);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    if (isset($_POST['indice'])) {
        $indice = intval($_POST['indice']);
        $carrito = Session::get('carrito_ventas1', []);

        if (isset($carrito[$indice])) {
            $nombre_producto = $carrito[$indice]['nombre'];
            unset($carrito[$indice]);
            $carrito = array_values($carrito);
            Session::set('carrito_ventas1', $carrito);
            Session::set('mensaje_carrito', "Producto '$nombre_producto' eliminado del carrito");
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function calcularTotal()
{
    $total = 0;
    $carrito = Session::get('carrito_ventas1', []);
    foreach ($carrito as $item) {
        if (isset($item['subtotal'])) {
            $total += floatval($item['subtotal']);
        }
    }
    return $total;
}

include("../componentes/header.php");
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (Session::has('mensaje_carrito')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '<?php echo addslashes(Session::get("mensaje_carrito")); ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    <?php Session::delete('mensaje_carrito'); ?>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-shopping-cart"></i> CARRITO DE COMPRAS</h2>
                <a href="../controlador/controladorVenta.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Seguir Comprando
                </a>
            </div>

            <?php
            $carrito = Session::get('carrito_ventas1', []);
            if (!empty($carrito)):
            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carrito as $indice => $item): ?>
                                <tr>
                                    <td style="width: 100px;">
                                        <?php if (!empty($item['imagen'])): ?>
                                            <?php
                                            $imageUrl = IMAGE_URL . htmlspecialchars($item['imagen']);
                                            echo "<!-- DEBUG: Intentando cargar imagen desde: $imageUrl -->";

                                            // Log en consola del navegador
                                            echo "<script>
                                                console.log('🖼️  Intentando cargar imagen:', '$imageUrl');
                                                console.log('📍 Desde archivo:', '" . __FILE__ . "');
                                                console.log('📦 Datos del item:', " . json_encode($item) . ");
                                            </script>";
                                            ?>

                                            <img src="<?= $imageUrl; ?>"
                                                class="img-thumbnail"
                                                style="width: 80px; height: 80px; object-fit: cover;"
                                                onerror="console.error('❌ Error cargando:', this.src); this.src='<?= IMAGE_DEFAULT ?>'"
                                                onload="console.log('✅ Imagen cargada:', this.src)">
                                            <img src="<?= IMAGE_URL . htmlspecialchars($item['imagen']); ?>"
                                                class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;"
                                                onerror="this.src='<?= IMAGE_DEFAULT ?>'">
                                        <?php else: ?>
                                            <span class="text-muted">Sin imagen</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['nombre']); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($item['descripcion']); ?></small>
                                    </td>
                                    <td>Bs <?php echo number_format($item['precio'], 2); ?></td>
                                    <td>
                                        <span class="fw-bold"><?php echo $item['cantidad']; ?></span>
                                    </td>
                                    <td>Bs <?php echo number_format($item['subtotal'], 2); ?></td>
                                    <td>
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                <td><strong>Bs <?php echo number_format(calcularTotal(), 2); ?></strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="../controlador/controladorVenta.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Seguir Comprando
                    </a>
                    <a href="../controlador/controladorprocesar.php" class="btn btn-success btn-lg ms-2">
                        <i class="fas fa-check-circle"></i> Procesar Venta
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>El carrito está vacío</h4>
                    <p>Agrega productos para realizar una venta</p>
                    <a href="../controlador/controladorVenta.php" class="btn btn-primary mt-3">
                        <i class="fas fa-shopping-bag"></i> Ir a Comprar
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="assets/js/recuperar-carrito.js"></script>

<?php include("../componentes/footer.php"); ?>