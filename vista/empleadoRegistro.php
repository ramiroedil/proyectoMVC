<?php
include("../componentes/header.php");
?>
<div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Registro de Empleado</h5>
                    <small class="text-muted float-end">Registrando un nuevo empleado</small>
                </div>
                <div class="card-body">
                    <!-- la licenciada no tenia el action pero no funciona si lo quito aunque capaz y no es necesario por que este formulario tecnicamente essta en el controlador -->
                    <form method="post" action="../controlador/empleadoRegistroCo.php">
                        <div class="row sm-2">
                            <label for="largeSelect" class="col-sm-2 col-form-label">Cargo</label>
                            <div class="col-sm-10">
                                <!-- obtenemos loss cargos del objeto res y los cargamos al select -->
                                <select id="largeSelect" class="form-select form-select-lg" name="id_cargo">
                                    <option selected value="">Seleccione un cargo</option>
                                    <?php
                                    while ($r = mysqli_fetch_array($res)) {
                                        $i = 0;
                                        ?>
                                        <!-- id_c es el nombre mediante se carga el valor "id_cargo" al controlador ya que en la base de datoss ese campo es entero y lo que aparece en el sselect es el cargo -->
                                        <option name="id_c" value="<?= $r['id_cargo']; ?>"><?= $r['cargo']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">CI</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ci" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nombre" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Paterno</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"name="paterno" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Materno</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="materno" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Direccion</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="direccion" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Telefono</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="telefono" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Fecha de Nacimiento</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="fechanacimiento" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Genero</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="genero" id="genero">
                                    <option selected value="">Seleccione</option>
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col sm-2 col-form-label">Intereses</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3"
                                    name="intereses"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-end">
                            <div class="col md-2">
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-2">
                                <!-- y el boton tipo submit con nombre registrarEmpleado que esta al inicio del controlador -->
                                <button type="submit" class="btn btn-primary" name="registrarEmpleado"
                                    value="Registrar">Registrar</button>
                            </div>
                            <div class="col-md-2">
                                <a href="../controlador/empleadoLista.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php
include("../componentes/footer.php");
?>
