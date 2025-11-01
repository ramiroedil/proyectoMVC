<?php
include("../componentes/header.php");
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-list"></i> LISTADO DE VENTAS</h2>
                <a href="../controlador/controladorVenta.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Venta
                </a>
            </div>
        </div>
    </div>

    <!-- FILTROS -->
    <!-- <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-filter"></i> Filtros de Búsqueda</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" class="border-end pe-3">
                                <h6>Filtrar por Fecha</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Fecha Inicio:</label>
                                        <input type="date" name="fecha_inicio" class="form-control" 
                                               value="<?php echo isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fecha Fin:</label>
                                        <input type="date" name="fecha_fin" class="form-control" 
                                               value="<?php echo isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : ''; ?>" required>
                                    </div>
                                </div>
                                <button type="submit" name="filtrar_fecha" class="btn btn-info mt-2">
                                    <i class="fas fa-calendar"></i> Filtrar por Fecha
                                </button>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form method="POST" class="ps-3">
                                <h6>Filtrar por Cliente</h6>
                                <div class="mb-2">
                                    <label class="form-label">Seleccionar Cliente:</label>
                                    <select name="id_cliente" class="form-select" required>
                                        <option value="">-- Seleccionar Cliente --</option>
                                        <?php while($cliente = $clientes_lista->fetch_assoc()): ?>
                                            <option value="<?php echo $cliente['id_cliente']; ?>"
                                                    <?php echo (isset($_POST['id_cliente']) && $_POST['id_cliente'] == $cliente['id_cliente']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($cliente['razonsocial']) . ' - ' . htmlspecialchars($cliente['nit_ci']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <button type="submit" name="filtrar_cliente" class="btn btn-warning">
                                    <i class="fas fa-user"></i> Filtrar por Cliente
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="../controlador/ventaLista.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- RESULTADOS -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-table"></i> Resultados</h5>
                </div>
                <div class="card-body">
                    <?php if ($ventas_resultado && mysqli_num_rows($ventas_resultado) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID Venta</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>CI/NIT</th>
                                        <th>Vendedor</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($venta_row = $ventas_resultado->fetch_assoc()): ?>
                                        <tr>
                                            <td><strong><?php echo $venta_row['id_venta']; ?></strong></td>
                                            <td><?php echo date('d/m/Y', strtotime($venta_row['fecha'])); ?></td>
                                            <td><?php echo htmlspecialchars($venta_row['razonsocial']); ?></td>
                                            <td><?php echo htmlspecialchars($venta_row['nit_ci']); ?></td>
                                            <td><?php echo htmlspecialchars($venta_row['nombre'] . ' ' . $venta_row['paterno']); ?></td>
                                            <td>
                                                <?php
                                                // Calcular total de la venta
                                                $venta_temp = new Venta($venta_row['id_venta'], "", "", "");
                                                $total = $venta_temp->calcularTotalVenta();
                                                echo "<strong>Bs " . number_format($total, 2) . "</strong>";
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-info btn-sm" 
                                                            onclick="verDetalle(<?php echo $venta_row['id_venta']; ?>)">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </button>
                                                    <?php if ($_SESSION['usuario']['tipousuario'] == 'administrador'): ?>
                                                        <a href='../controlador/ventaEliminar.php?id=<?php echo $venta_row['id_venta']; ?>'class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> No se encontraron ventas con los criterios especificados.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETALLE VENTA -->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1" aria-labelledby="modalDetalleVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalDetalleVentaLabel">
                    <i class="fas fa-info-circle"></i> Detalle de Venta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoDetalleVenta">
                <!-- El contenido se cargará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
function verDetalle(idVenta) {

    fetch('../controlador/obtenerDetalleVenta.php?id=' + idVenta)
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenidoDetalleVenta').innerHTML = data;
            new bootstrap.Modal(document.getElementById('modalDetalleVenta')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudo cargar el detalle de la venta', 'error');
        });
}

</script>

<?php include("../componentes/footer.php"); ?>