<?php
include("../componentes/header.php");
?>
<div class="row justify-content-center">
        <div class="col-md-8">
            <form role="form" method="GET">
                <h3>BUSCAR</h3>

                <!-- Campo oculto para el ID -->
                
                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <input type="text" class="form-control" name="empleado" id="empleado" >
                           </div>

                <div class="mt-3">
                    <button type="submit" name="Buscar" id="Buscar" class="btn btn-primary">BUSCAR EMPLEADO</button>

                </div>
            </form>
            <table class="table">
                <thead class="thead-dark">
                <tr align="center">
                <tr>
                        <th>Nro</th>
                        <th>Cargo</th>
                        <th>CI</th>
                        <th>Nombre Completo</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Fecha Nacimiento</th>
                        <th>Genero</th>
                        <th>Intereses</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php
                    while ($r = mysqli_fetch_array($res)) {
                        ?>
                        <tr class="table">
                            <td><span class="badge bg-info text-primary px-3 rounded" ><?= $id++ ?></span></td>
                            <td><?= $r['cargo'] ?></td>
                            <td><?= $r['ci'] ?></td>
                            <td><?= $r['nombre'] ?>     <?= $r['paterno'] ?>     <?= $r['materno'] ?></td>
                            <td><?= $r['direccion'] ?></td>
                            <td><?= $r['telefono'] ?></td>
                            <td><?= $r['fechanacimiento'] ?></td>
                            <td><?= $r['genero'] ?></td>
                            <td><?= $r['intereses'] ?></td>

                            <td>
                                            <a href='../controlador/cargoModifica.php?id=<?php echo $r['id_cargo']; ?>' class="btn btn-success btn-sm">
                                                <i class="bi bi-pencil-fill"></i> Editar
                                            </a>
                                        </td>
                                        <td>
                                            <a href='../controlador/cargoEliminar.php?id=<?php echo $r['id_cargo']; ?>' class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash-fill"></i> Eliminar
                                            </a>
                                        </td>
                        </tr>
                        <?php
                    }
                    
                    ?>
                </tbody>



            </table>
            <a href="../controlador/cargoLista.php" class="btn btn-danger">ir principal</a>
        </div>
    </div>
</div>
<?php
include("../componentes/footer.php");
?>
