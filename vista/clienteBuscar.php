<?php include("../componentes/header.php"); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <form role="form" method="GET" action="../controlador/clienteBusqueda.php">
            <h3>BUSCAR CLIENTE</h3>
            <div class="form-group">
                <label for="cargo">CLIENTE</label>
                <input type="text" class="form-control" name="cliente" id="cliente">
            </div>
            <div class="mt-3">
                <button type="submit" name="Buscar" id="Buscar" class="btn btn-primary">BUSCAR</button>
            </div>
        </form>
        <?php if (!empty($datos)) { ?>
            <table class="table mt-4 table-striped table-bordered text-center">
                <thead class="table-dark">
                    <tr align="center">
                        <th scope="col">RAZON SOCIAL</th>
                        <th scope="col">NIT_CI</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col" colspan="2">OPERACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $re) { ?>
                        <tr align="center">
                            <td><?php echo $re[0]; ?></td>
                            <td><?php echo $re[1]; ?></td>
                            <td><?php echo $re[2]; ?></td>
                            <td><a href="clienteModifica.php?id=<?php echo $re['id_cliente']; ?>" class="btn btn-warning">Editar</a></td>
                            <td><a href="clienteEliminar.php?id=<?php echo $re['id_cliente']; ?>" class="btn btn-danger">Eliminar</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else if (isset($_GET["Buscar"])) { ?>
            <p class="mt-4 text-center text-danger">No se encontraron resultados.</p>
        <?php } ?>
        <a href="../controlador/clienteLista.php" class="btn btn-danger mt-3">Ir a Principal</a>
    </div>
</div>
<?php include("../componentes/footer.php"); ?>
