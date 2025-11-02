<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de venta no válido</div>";
    exit();
}

$id_venta = intval($_GET['id']);
$api = new ApiClient();

// Obtener venta completa
$response = $api->get("/venta/search/{$id_venta}");

if (!$response['success'] || empty($response['data'])) {
    echo "<div class='alert alert-danger'>Venta no encontrada</div>";
    exit();
}

$venta = $response['data'];
?>

<div class="row">
    <!-- INFORMACIÓN GENERAL -->
    <div class="col-md-6">
        <h6><i class="fas fa-info-circle"></i> Información General</h6>
        <table class="table table-sm table-borderless">
            <tr>
                <td><strong>Número de Venta:</strong></td>
                <td><?php echo $venta['id']; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha:</strong></td>
                <td><?php echo date('d/m/Y H:i', strtotime($venta['fecha'])); ?></td>
            </tr>
            <tr>
                <td><strong>Cliente:</strong></td>
                <td><?php echo htmlspecialchars($venta['cliente']['razon_social']); ?></td>
            </tr>
            <tr>
                <td><strong>CI/NIT:</strong></td>
                <td><?php echo htmlspecialchars($venta['cliente']['nit_ci']); ?></td>
            </tr>
            <tr>
                <td><strong>Vendedor:</strong></td>
                <td><?php echo htmlspecialchars($venta['empleado']['nombre'] . ' ' . $venta['empleado']['paterno']); ?></td>
            </tr>
            <tr>
                <td><strong>Método de Pago:</strong></td>
                <td><?php echo $venta['metodo_pago']; ?></td>
            </tr>
        </table>
    </div>
    
    <!-- RESUMEN -->
    <div class="col-md-6">
        <h6><i class="fas fa-calculator"></i> Resumen</h6>
        <div class="alert alert-success text-center">
            <h4><strong>TOTAL: Bs <?php echo number_format($venta['total'], 2); ?></strong></h4>
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
                    <?php if (!empty($venta['detalles'])): ?>
                        <?php foreach($venta['detalles'] as $detalle): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($detalle['producto']['nombre']); ?></strong></td>
                                <td><?php echo htmlspecialchars($detalle['producto']['descripcion']); ?></td>
                                <td class="text-center"><?php echo $detalle['cantidad']; ?></td>
                                <td class="text-end">Bs <?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                                <td class="text-end">Bs <?php echo number_format($detalle['subtotal'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No se encontraron productos</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-success">
                    <tr>
                        <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                        <td class="text-end"><strong>Bs <?php echo number_format($venta['total'], 2); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>