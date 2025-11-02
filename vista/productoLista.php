<?php include("../componentes/header.php"); ?>

<div class="row pt-3 justify-content-center">
    <div class="col-md-2">
        <a href="../controlador/productoRegistro.php" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Nuevo Producto
        </a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/productoBuscar.php" class="btn btn-warning btn-sm">
            <i class="fas fa-search"></i> Buscar Producto
        </a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/productoListaMujer.php" class="btn btn-dark btn-sm">
            <i class="fas fa-female"></i> MUJER
        </a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/productoListaVaron.php" class="btn btn-primary btn-sm">
            <i class="fas fa-male"></i> VARON
        </a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/productoLista.php" class="btn btn-secondary btn-sm">
            <i class="fas fa-list"></i> TODOS
        </a>
    </div>
</div>

<div class="row pt-3 justify-content-center">
    <div class="col-md-12 text-center">
        <h1>LISTA DE PRODUCTOS</h1>
    </div>
</div>

<div class="table-responsive">
    <?php if (!empty($productos)): ?>
        <table class="table table-striped table-bordered" id="tblData">
            <thead class="table-dark">
                <tr>
                    <th>Nro</th>
                    <th>Código</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Tipo</th>
                    <th>Imagen</th>
                    <th colspan="2">Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $id = 1;
                foreach ($productos as $producto): 
                ?>
                    <tr>
                        <td><?= $id++; ?></td>
                        <td><?= htmlspecialchars($producto['codigo']); ?></td>
                        <td><?= htmlspecialchars($producto['proveedor']['empresa']); ?></td>
                        <td><?= htmlspecialchars($producto['nombre']); ?></td>
                        <td><?= htmlspecialchars($producto['descripcion']); ?></td>
                        <td>Bs <?= number_format($producto['precio_venta'], 2); ?></td>
                        <td>
                            <?php if ($producto['stock'] < 10): ?>
                                <span class="badge bg-danger"><?= $producto['stock']; ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?= $producto['stock']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($producto['tipo'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#mostrar_<?= $producto['id'] ?>">
                                <img src="../controlador/imagenes/<?= htmlspecialchars($producto['imagen']); ?>" 
                                     width="70px" height="70px" class="rounded">
                            </a>
                        </td>
                        <td>
                            <a href="../controlador/productoModificar.php?id=<?= $producto['id']; ?>" 
                               class="btn btn-success btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </td>
                        <td>
                            <a href="../controlador/productoEliminar.php?id=<?= $producto['id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Está seguro de eliminar este producto?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay productos registrados</div>
    <?php endif; ?>
</div>

<!-- MODALES PARA IMÁGENES -->
<?php foreach ($productos as $producto): ?>
    <div class="modal fade" id="mostrar_<?= $producto['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h4 class="modal-title text-white text-center w-100">
                        <?= htmlspecialchars($producto['nombre']); ?>
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img src="../controlador/imagenes/<?= htmlspecialchars($producto['imagen']); ?>" 
                         width="100%" height="100%" style="object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php include("../componentes/footer.php"); ?>