<?php include("../componentes/header.php"); ?>

<div class="container-fluid">
    <h2>LISTADO DE VENTAS</h2>
    
    <div class="card">
        <div class="card-body">
            <?php if (!empty($ventas)): ?>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Empleado</th>
                            <th>Total</th>
                            <th>Método Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?php echo $venta['id']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($venta['fecha'])); ?></td>
                                <td><?php echo htmlspecialchars($venta['cliente']['razon_social']); ?></td>
                                <td><?php echo htmlspecialchars($venta['empleado']['nombre']); ?></td>
                                <td>Bs <?php echo number_format($venta['total'], 2); ?></td>
                                <td><?php echo $venta['metodo_pago']; ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="verDetalle(<?php echo $venta['id']; ?>)">
                                        Ver Detalle
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No hay ventas registradas</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>
```
