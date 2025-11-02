<?php include("../componentes/header.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>PRODUCTOS DISPONIBLES</h2>
            <a href="../vista/carrito_ventas.php" class="btn btn-success btn-lg">
                Ver Carrito
                <?php
                $items_carrito = Session::has('carrito_ventas1') ? count(Session::get('carrito_ventas1')) : 0;
                if ($items_carrito > 0) {
                    echo " <span class='badge bg-warning text-dark'>$items_carrito</span>";
                }
                ?>
            </a>
        </div>
    </div>

    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="../controlador/imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>"
                         class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                         style="height: 250px; object-fit: cover;">
                    
                    <div class="card-body">
                        <h5><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                        <p><strong>Precio:</strong> Bs <?php echo number_format($producto['precio_venta'], 2); ?></p>
                        <p><strong>Stock:</strong> <?php echo $producto['stock']; ?></p>
                        
                        <?php if ($producto['stock'] > 0): ?>
                            <form method="post" action="../controlador/controlaventaCarrito.php">
                                <input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">
                                <input type="hidden" name="nombrep" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <input type="hidden" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion']); ?>">
                                <input type="hidden" name="precio" value="<?php echo $producto['precio_venta']; ?>">
                                <input type="hidden" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>">
                                
                                <div class="form-group mb-2">
                                    <label>Cantidad:</label>
                                    <input type="number" class="form-control" name="cantidad" 
                                           value="1" min="1" max="<?php echo $producto['stock']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Agregar al Carrito</button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-danger btn-block" disabled>Agotado</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>