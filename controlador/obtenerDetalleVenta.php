<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de venta no válido</div>";
    exit();
}

$id_venta = intval($_GET['id']);

include_once("../modelo/ventaClase.php");

$venta = new Venta($id_venta, "", "", "");
$datos_venta = $venta->obtenerVenta();
$detalle_venta = $venta->obtenerDetalleVenta();
$total_venta = $venta->calcularTotalVenta();

if (!$datos_venta || mysqli_num_rows($datos_venta) == 0) {
    echo "<div class='alert alert-danger'>Venta no encontrada</div>";
    exit();
}

$venta_info = $datos_venta->fetch_assoc();
?>

<div class="row">
    <!-- INFORMACIÓN GENERAL -->
    <div class="col-md-6">
        <h6><i class="fas fa-info-circle"></i> Información General</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <td><strong>Número de Venta:</strong></td>
                <td><?php echo $venta_info['id_venta']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha:</strong></td>
                <td><?php echo date('d/m/Y', strtotime($venta_info['fecha'])); ?></td>
            </tr>
            <tr>
                <td><strong>Cliente:</strong></td>
                <td><?php echo htmlspecialchars($venta_info['razonsocial']); ?></td>
            </tr>
            <tr>
                <td><strong>CI/NIT:</strong></td>
                <td><?php echo htmlspecialchars($venta_info['nit_ci']); ?></td>
            </tr>
            <tr>
                <td><strong>Vendedor:</strong></td>
                <td><?php echo htmlspecialchars($venta_info['nombre'] . ' ' . $venta_info['paterno'] . ' ' . $venta_info['materno']); ?></td>
            </tr>
        </table>
    </div>
    
    <!-- RESUMEN -->
    <div class="col-md-6">
        <h6><i class="fas fa-calculator"></i> Resumen</h6>
        <div class="alert alert-success text-center">
            <h4><strong>TOTAL: Bs <?php echo number_format($total_venta, 2); ?></strong></h4>
        </div>
    </div>
</div>

<!-- DETALLE DE PRODUCTOS -->
<div class="row">
    <div class="col-12">
        <h6><i class="fas fa-shopping-cart"></i> Productos Vendidos</h6>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($detalle_venta) > 0): ?>
                        <?php while($detalle = $detalle_venta->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($detalle['nombreproducto']); ?></strong></td>
                                <td><?php echo htmlspecialchars($detalle['descripcion']); ?></td>
                                <td class="text-center"><?php echo $detalle['cantidad']; ?></td>
                                <td class="text-end">Bs <?php echo number_format($detalle['precio'], 2); ?></td>
                                <td class="text-end">Bs <?php echo number_format($detalle['costo'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No se encontraron productos</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-success">
                    <tr>
                        <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                        <td class="text-end"><strong>Bs <?php echo number_format($total_venta, 2); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>