<?php
session_start();

// Verificar que existe la venta exitosa en sesión
if (!isset($_SESSION['venta_exitosa'])) {
    header("Location: ../controlador/controladorVenta.php");
    exit();
}

$id_venta = $_SESSION['venta_exitosa'];

include_once("../modelo/ventaClase.php");

$venta = new Venta($id_venta, "", "", "");
$datos_venta = $venta->obtenerVenta();
$detalle_venta = $venta->obtenerDetalleVenta();
$total_venta = $venta->calcularTotalVenta();

// Obtener los datos de la venta
$venta_info = $datos_venta->fetch_assoc();

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
                    <h4>Número de Venta: <strong><?php echo $id_venta; ?></strong></h4>
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
                        <tr class="table-success">
                            <td><strong>TOTAL:</strong></td>
                            <td><strong>Bs <?php echo number_format($total_venta, 2); ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- DETALLE DE PRODUCTOS -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-shopping-cart"></i> PRODUCTOS VENDIDOS</h5>
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
                                <?php while($detalle = $detalle_venta->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($detalle['nombreproducto']); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo htmlspecialchars($detalle['descripcion']); ?></small>
                                        </td>
                                        <td><?php echo $detalle['cantidad']; ?></td>
                                        <td>Bs <?php echo number_format($detalle['precio'], 2); ?></td>
                                        <td>Bs <?php echo number_format($detalle['costo'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot class="table-success">
                                <tr>
                                    <td colspan="3"><strong>TOTAL:</strong></td>
                                    <td><strong>Bs <?php echo number_format($total_venta, 2); ?></strong></td>
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
                        <button onclick="imprimirFactura()" class="btn btn-info btn-lg">
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

<!-- ÁREA DE IMPRESIÓN (OCULTA) -->
<div id="areaImpresion" style="display: none;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h2>FACTURA DE VENTA</h2>
        <h3>Sistema Juvenil</h3>
        <hr>
    </div>
    
    <div style="margin-bottom: 20px;">
        <strong>Número de Venta:</strong> <?php echo $venta_info['id_venta']; ?><br>
        <strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($venta_info['fecha'])); ?><br>
        <strong>Cliente:</strong> <?php echo htmlspecialchars($venta_info['razonsocial']); ?><br>
        <strong>CI/NIT:</strong> <?php echo htmlspecialchars($venta_info['nit_ci']); ?><br>
        <strong>Vendedor:</strong> <?php echo htmlspecialchars($venta_info['nombre'] . ' ' . $venta_info['paterno'] . ' ' . $venta_info['materno']); ?>
    </div>
    
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Reiniciar el cursor del resultado
            $detalle_venta = $venta->obtenerDetalleVenta();
            while($detalle = $detalle_venta->fetch_assoc()): 
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($detalle['nombreproducto']); ?></td>
                    <td style="text-align: center;"><?php echo $detalle['cantidad']; ?></td>
                    <td style="text-align: right;">Bs <?php echo number_format($detalle['precio'], 2); ?></td>
                    <td style="text-align: right;">Bs <?php echo number_format($detalle['costo'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #e9ecef; font-weight: bold;">
                <td colspan="3" style="text-align: right;">TOTAL:</td>
                <td style="text-align: right;">Bs <?php echo number_format($total_venta, 2); ?></td>
            </tr>
        </tfoot>
    </table>
    
    <div style="margin-top: 30px; text-align: center;">
        <p>¡Gracias por su compra!</p>
        <p><small>Sistema de Ventas Juvenil - <?php echo date('d/m/Y H:i:s'); ?></small></p>
    </div>
</div>

<script>
// Mostrar mensaje de éxito al cargar
Swal.fire({
    title: '¡Éxito!',
    text: 'La venta se ha procesado correctamente',
    icon: 'success',
    timer: 3000,
    showConfirmButton: false
});

function imprimirFactura() {
    var contenido = document.getElementById('areaImpresion').innerHTML;
    var ventanaImpresion = window.open('', '_blank');
    
    ventanaImpresion.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Factura - Venta #<?php echo $id_venta; ?></title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
                th { background-color: #f2f2f2; }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                @media print {
                    body { margin: 0; }
                }
            </style>
        </head>
        <body>
            ${contenido}
        </body>
        </html>
    `);
    
    ventanaImpresion.document.close();
    ventanaImpresion.focus();
    ventanaImpresion.print();
}

// Limpiar la sesión de venta exitosa después de 5 segundos
setTimeout(function() {
    fetch('../componentes/limpiar_venta_exitosa.php');
}, 5000);
</script>

<?php
// Limpiar la sesión después de mostrar la página
unset($_SESSION['venta_exitosa']);

include("../componentes/footer.php");
?>