<?php
session_start();

// PROCESAR SOLO LA ACCIÓN DE ELIMINAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    
    if (isset($_POST['indice'])) {
        $indice = intval($_POST['indice']);
        
        // Verificar que el índice existe en el carrito
        if (isset($_SESSION['carrito_ventas1'][$indice])) {
            // Obtener el nombre del producto antes de eliminarlo
            $nombre_producto = $_SESSION['carrito_ventas1'][$indice]['nombre'];
            
            // Eliminar el producto del carrito
            unset($_SESSION['carrito_ventas1'][$indice]);
            
            // Reindexar el array para evitar problemas con índices
            $_SESSION['carrito_ventas1'] = array_values($_SESSION['carrito_ventas1']);
            
            // Mensaje de confirmación
            $_SESSION['mensaje_carrito'] = "Producto '$nombre_producto' eliminado del carrito";
        } else {
            $_SESSION['mensaje_carrito'] = "Error: Producto no encontrado en el carrito";
        }
    } else {
        $_SESSION['mensaje_carrito'] = "Error: No se especificó qué producto eliminar";
    }
    
    // Redirigir para refrescar la página
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Función para calcular el total del carrito
function calcularTotal()
{
    $total = 0;
    if (isset($_SESSION['carrito_ventas1']) && is_array($_SESSION['carrito_ventas1'])) {
        foreach ($_SESSION['carrito_ventas1'] as $item) {
            if (isset($item['subtotal'])) {
                $total += floatval($item['subtotal']);
            }
        }
    }
    return $total;
}

include("../componentes/header.php");
?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-shopping-cart"></i> CARRITO DE COMPRAS</h2>
                <a href="../controlador/controladorVenta.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Seguir Comprando
                </a>
            </div>

            <?php if (isset($_SESSION['carrito_ventas1']) && !empty($_SESSION['carrito_ventas1'])): ?>
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
                            <?php foreach ($_SESSION['carrito_ventas1'] as $indice => $item): ?>
                                <tr>
                                    <td style="width: 100px;">
                                        <?php if (!empty($item['imagen'])): ?>
                                            <img src="../controlador/imagenes/<?php echo htmlspecialchars($item['imagen']); ?>"
                                                class="img-thumbnail" alt="<?php echo htmlspecialchars($item['nombre']); ?>"
                                                style="width: 100px; height: 100px;">
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
                                    <td style="width: 200px;">
                                        <span class="fw-bold"><?php echo $item['cantidad']; ?></span>
                                    </td>
                                    <td>Bs <?php echo number_format($item['subtotal'], 2); ?></td>
                                    <td>
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('¿Estás seguro de eliminar este producto del carrito?')">
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
                    <i class="fas fa-info-circle"></i> El carrito está vacío
                    <br><br>
                    <a href="../controlador/controladorVenta.php" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Ir a Comprar
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>