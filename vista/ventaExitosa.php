<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

// Verificar que existe la venta exitosa en sesión
if (!Session::has('venta_exitosa')) {
    header("Location: ../controlador/controladorVenta.php");
    exit();
}

$venta_exitosa = Session::get('venta_exitosa');
$id_venta = $venta_exitosa['id'] ?? null;

if (!$id_venta) {
    header("Location: ../controlador/controladorVenta.php");
    exit();
}

$api = new ApiClient();

// Obtener datos completos de la venta
$response = $api->get("/venta/search/{$id_venta}");

if (!$response['success']) {
    Session::delete('venta_exitosa');
    header("Location: ../controlador/controladorVenta.php");
    exit();
}

$venta = $response['data'];

include("../componentes/header.php");
?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center mb-4">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h2>¡VENTA PROCESADA EXITOSAMENTE!</h2>
                    <h4>Número de Venta: <strong><?php echo htmlspecialchars($venta['numero_venta']); ?></strong></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- INFORMACIÓN DE LA VENTA -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-info-circle"></i> INFORMACIÓN DE LA VENTA</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Número de Venta:</strong></td>
                            <td><?php echo htmlspecialchars($venta['numero_venta']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Número de Factura:</strong></td>
                            <td><?php echo htmlspecialchars($venta['numero_factura']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha:</strong></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($venta['fecha'])); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Cliente:</strong></td>
                            <td><?php echo htmlspecialchars($venta['cliente']['razon_social'] ?? $venta['cliente']['nombre']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>CI/NIT:</strong></td>
                            <td><?php echo htmlspecialchars($venta['cliente']['nit_ci'] ?? $venta['cliente']['ci']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Vendedor:</strong></td>
                            <td>
                                <?php 
                                    $nombre_vendedor = '';
                                    if (isset($venta['empleado']['usuario'])) {
                                        $nombre_vendedor = htmlspecialchars($venta['empleado']['usuario']['nombre'] . ' ' . ($venta['empleado']['usuario']['apellido_paterno'] ?? ''));
                                    } else {
                                        $nombre_vendedor = htmlspecialchars($venta['empleado']['nombre'] ?? 'N/A');
                                    }
                                    echo $nombre_vendedor;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Método de Pago:</strong></td>
                            <td>
                                <?php
                                    $metodos_pago = [
                                        'EFECTIVO' => '💵 Efectivo',
                                        'TARJETA' => '💳 Tarjeta',
                                        'TRANSFERENCIA' => '🏦 Transferencia',
                                        'CHEQUE' => '📄 Cheque'
                                    ];
                                    echo $metodos_pago[$venta['metodo_pago']] ?? $venta['metodo_pago'];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Estado:</strong></td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> <?php echo htmlspecialchars($venta['estado']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php if (!empty($venta['observaciones'])): ?>
                        <tr>
                            <td><strong>Observaciones:</strong></td>
                            <td><?php echo htmlspecialchars($venta['observaciones']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="table-success">
                            <td><strong>TOTAL:</strong></td>
                            <td><strong>Bs <?php echo number_format($venta['total'], 2); ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- DETALLE DE PRODUCTOS -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-shopping-cart"></i> PRODUCTOS VENDIDOS (<?php echo count($venta['detalles']); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Precio Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (!empty($venta['detalles'])): 
                                    foreach($venta['detalles'] as $detalle): 
                                ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($detalle['producto']['nombre'] ?? 'Producto'); ?></strong>
                                        </td>
                                        <td><?php echo intval($detalle['cantidad']); ?></td>
                                        <td>Bs <?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                                        <td>Bs <?php echo number_format($detalle['subtotal'], 2); ?></td>
                                    </tr>
                                <?php 
                                    endforeach; 
                                else:
                                ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            No hay productos registrados
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot class="table-success">
                                <tr>
                                    <td colspan="3"><strong>TOTAL:</strong></td>
                                    <td><strong>Bs <?php echo number_format($venta['total'], 2); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACCIONES -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="btn-group" role="group">
                        <a href="../controlador/controladorVenta.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus"></i> Nueva Venta
                        </a>
                        <button onclick="window.print()" class="btn btn-info btn-lg">
                            <i class="fas fa-print"></i> Imprimir Factura
                        </button>
                        <a href="../controlador/ventaLista.php" class="btn btn-secondary btn-lg">
                            <i class="fas fa-list"></i> Ver Todas las Ventas
                        </a>
                        <a href="../inicio.php" class="btn btn-success btn-lg">
                            <i class="fas fa-home"></i> Ir al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mostrar mensaje de éxito al cargar
Swal.fire({
    title: '¡Éxito!',
    text: 'La venta se ha procesado correctamente',
    icon: 'success',
    timer: 3000,
    showConfirmButton: false,
    timerProgressBar: true
});

// Limpiar la sesión de venta exitosa después de 10 segundos (permitir lectura)
setTimeout(function() {
    // No limpiar inmediatamente para permitir que el usuario vea la información
    // Se limpiará cuando navegue a otra página
}, 10000);
</script>

<?php include("../componentes/footer.php"); ?>