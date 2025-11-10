<?php
require_once(__DIR__ . '/../helpers/Session.php');
include("../componentes/header.php");
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-list"></i> LISTADO DE VENTAS</h2>
                <a href="../controlador/controladorVenta.php" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nueva Venta
                </a>
            </div>

            <!-- FILTROS -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5><i class="fas fa-filter"></i> FILTROS</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Filtro por fechas -->
                        <div class="col-md-6 mb-3">
                            <form method="POST" class="form-inline">
                                <div class="input-group w-100">
                                    <input type="date" name="fecha_inicio" class="form-control" required>
                                    <input type="date" name="fecha_fin" class="form-control" required>
                                    <button type="submit" name="filtrar_fecha" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filtrar por Fecha
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Filtro por cliente -->
                        <div class="col-md-6 mb-3">
                            <form method="POST" class="form-inline">
                                <div class="input-group w-100">
                                    <select name="id_cliente" class="form-select" required>
                                        <option value="">-- Seleccionar Cliente --</option>
                                        <?php foreach($clientes_lista as $cliente): ?>
                                            <option value="<?php echo $cliente['id']; ?>">
                                                <?php echo htmlspecialchars($cliente['razon_social'] ?? $cliente['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="filtrar_cliente" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filtrar por Cliente
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Botón limpiar filtros -->
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <a href="../controlador/ventaLista.php" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i> Limpiar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLA DE VENTAS -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-table"></i> VENTAS REGISTRADAS (<?php echo count($ventas); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($ventas)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nº Venta</th>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Empleado</th>
                                        <th>Total</th>
                                        <th>Método Pago</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ventas as $venta): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($venta['numero_venta'] ?? $venta['id']); ?></strong>
                                            </td>
                                            <td>
                                                <?php echo date('d/m/Y H:i', strtotime($venta['fecha'])); ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if (isset($venta['cliente'])) {
                                                        echo htmlspecialchars($venta['cliente']['razon_social'] ?? $venta['cliente']['nombre'] ?? 'N/A');
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if (isset($venta['empleado'])) {
                                                        if (isset($venta['empleado']['usuario'])) {
                                                            echo htmlspecialchars($venta['empleado']['usuario']['nombre'] ?? 'N/A');
                                                        } else {
                                                            echo htmlspecialchars($venta['empleado']['nombre'] ?? 'N/A');
                                                        }
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <strong>Bs <?php echo number_format($venta['total'], 2); ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                    $metodos = [
                                                        'EFECTIVO' => '<span class="badge bg-success">💵 Efectivo</span>',
                                                        'TARJETA' => '<span class="badge bg-info">💳 Tarjeta</span>',
                                                        'TRANSFERENCIA' => '<span class="badge bg-primary">🏦 Transferencia</span>',
                                                        'CHEQUE' => '<span class="badge bg-warning">📄 Cheque</span>'
                                                    ];
                                                    echo $metodos[$venta['metodo_pago']] ?? '<span class="badge bg-secondary">' . $venta['metodo_pago'] . '</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $estados = [
                                                        'COMPLETADA' => '<span class="badge bg-success"><i class="fas fa-check"></i> Completada</span>',
                                                        'PENDIENTE' => '<span class="badge bg-warning"><i class="fas fa-clock"></i> Pendiente</span>',
                                                        'CANCELADA' => '<span class="badge bg-danger"><i class="fas fa-times"></i> Cancelada</span>',
                                                        'DEVOLUCION' => '<span class="badge bg-info"><i class="fas fa-undo"></i> Devolución</span>'
                                                    ];
                                                    echo $estados[$venta['estado']] ?? '<span class="badge bg-secondary">' . $venta['estado'] . '</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <a href="ventaDetalle.php?id=<?php echo $venta['id']; ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> No hay ventas registradas
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>