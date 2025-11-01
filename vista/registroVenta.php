<?php
include("../componentes/header.php");

?>

<!-- SweetAlert para mensajes -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_SESSION['mensaje_carrito'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '<?php echo addslashes($_SESSION["mensaje_carrito"]); ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    <?php unset($_SESSION['mensaje_carrito']); endif; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>PRODUCTOS DISPONIBLES</h2>
                <a href="../vista/carrito_ventas.php" class="btn btn-success btn-lg">
                    <i class="fas fa-shopping-cart"></i> Ver Carrito
                    <?php
                    $items_carrito = isset($_SESSION['carrito_ventas1']) ? count($_SESSION['carrito_ventas1']) : 0;
                    if ($items_carrito > 0) {
                        echo " <span class='badge bg-warning text-dark'>$items_carrito</span>";
                    }
                    ?>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <?php
        if (mysqli_num_rows($res) > 0) {
            while ($r = mysqli_fetch_array($res)) {
                ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-container" style="height: 250px; overflow: hidden;">
                            <?php if (!empty($r['imagen'])): ?>
                                <img src="../controlador/imagenes/<?php echo htmlspecialchars($r['imagen']); ?>"
                                    class="card-img-top" alt="<?php echo htmlspecialchars($r['nombreproducto']); ?>"
                                    style="height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <span class="text-muted">Sin imagen</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($r['nombreproducto']); ?></h5>
                            <div class="card-text flex-grow-1">
                                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($r['descripcion']); ?></p>
                                <p><strong>Precio:</strong> <span class="text-success">Bs
                                        <?php echo number_format($r['precio'], 2); ?></span></p>
                                <p><strong>Stock:</strong>
                                    <?php if ($r['stock'] > 0): ?>
                                        <span class="text-success"><?php echo $r['stock']; ?> disponibles</span>
                                    <?php else: ?>
                                        <span class="text-danger">Agotado</span>
                                    <?php endif; ?>
                                </p>
                                <p><strong>Tipo:</strong> <?php echo htmlspecialchars($r['tipo']); ?></p>
                            </div>

                            <div class="mt-auto">
                                <?php
                                // Verificar si el producto ya está en el carrito
                                $en_carrito = false;
                                if (isset($_SESSION['carrito_ventas1'])) {
                                    foreach ($_SESSION['carrito_ventas1'] as $item_carrito) {
                                        if ($item_carrito['id_producto'] == $r['id']) {
                                            $en_carrito = true;
                                            break;
                                        }
                                    }
                                }

                                if ($en_carrito): ?>
                                    <div class="alert alert-success p-2 mb-2">
                                        <small><i class="fas fa-check"></i> Ya está en el carrito</small>
                                    </div>
                                    <a href="../vista/carrito_ventas.php" class="btn btn-outline-success btn-block">
                                        Ver en Carrito
                                    </a>
                                <?php elseif ($r['stock'] > 0): ?>
                                    <form method="post" action="../controlador/controlaventaCarrito.php">
                                        <input type="hidden" name="id_producto" value="<?php echo $r['id']; ?>">
                                        <input type="hidden" name="nombrep"
                                            value="<?php echo htmlspecialchars($r['nombreproducto']); ?>">
                                        <input type="hidden" name="descripcion"
                                            value="<?php echo htmlspecialchars($r['descripcion']); ?>">
                                        <input type="hidden" name="precio" value="<?php echo $r['precio']; ?>">
                                        <input type="hidden" name="imagen" value="<?php echo htmlspecialchars($r['imagen']); ?>">

                                        <div class="form-group mb-2">
                                            <label for="cantidad_<?php echo $r['id']; ?>" class="form-label">Cantidad:</label>
                                            <input type="number" class="form-control" id="cantidad_<?php echo $r['id']; ?>"
                                                name="cantidad" value="1" min="1" max="<?php echo $r['stock']; ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-cart-plus"></i> Agregar al Carrito
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="form-group mb-2">
                                        <label class="form-label">Cantidad:</label>
                                        <input type="number" class="form-control" value="0" readonly>
                                    </div>
                                    <button class="btn btn-danger btn-block" disabled>
                                        <i class="fas fa-times"></i> Agotado
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            echo '<div class="col-12"><div class="alert alert-info">No hay productos disponibles.</div></div>';
        }
        ?>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>