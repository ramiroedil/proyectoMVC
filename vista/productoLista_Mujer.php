<?php include("../componentes/header.php"); ?>

<div class="row pt-3 justify-content-center">
    <div class="col-md-2">
        <a href="../controlador/productoListaMujer.php" class="btn btn-dark btn-sm">MUJER</a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/productoListaVaron.php" class="btn btn-primary btn-sm">VARON</a>
    </div>
    <div class="col-md-2">
        <a href="../controlador/productoLista.php" class="btn btn-secondary btn-sm">TODOS</a>
    </div>
</div>

<div class="row pt-3">
    <div class="col-12 text-center">
        <h1>PRODUCTOS DE MUJER</h1>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nro</th>
                <th>Proveedor</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
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
                    <td><?= htmlspecialchars($producto['proveedor']['empresa']); ?></td>
                    <td><?= htmlspecialchars($producto['nombre']); ?></td>
                    <td><?= htmlspecialchars($producto['descripcion']); ?></td>
                    <td>Bs <?= number_format($producto['precio_venta'], 2); ?></td>
                    <td><?= $producto['stock']; ?></td>
                    <td>
                        <img src="../controlador/imagenes/<?= htmlspecialchars($producto['imagen']); ?>" 
                             width="70px" height="70px" class="rounded">
                    </td>
                    <td>
                        <a href="../controlador/productoModificar.php?id=<?= $producto['id']; ?>" 
                           class="btn btn-success btn-sm">Editar</a>
                    </td>
                    <td>
                        <a href="../controlador/productoEliminar.php?id=<?= $producto['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Está seguro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("../componentes/footer.php"); ?>