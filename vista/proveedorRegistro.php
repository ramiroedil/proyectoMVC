<?php
include("../componentes/header.php");
?>
<div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Registro de Proveedor</h5>
                    <small class="text-muted float-end">Registrando un nuevo proveedor</small>
                </div>
                <div class="card-body">
                    <!-- la licenciada no tenia el action pero no funciona si lo quito aunque capaz y no es necesario por que este formulario tecnicamente essta en el controlador -->
                    <form method="post" action="../controlador/proveedorRegistrar.php" enctype="multipart/form-data">
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">EMPRESA</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="empresa" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">contacto</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="contacto" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">MAIL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"name="mail" />
                            </div>
                        </div>
                        <br>
                        <div class="row sm-2">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">TELEFONO</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="telefono" />
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
                            <label class="col-sm-2 col-form-label" for="basic-default-name">LOGO</label>
                            <div class="col-sm-10">
                            <input type="file" name="logo">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col md-2">
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-2">
                                <!-- y el boton tipo submit con nombre registrarEmpleado que esta al inicio del controlador -->
                                <button type="submit" class="btn btn-primary" name="registrarProveedor"
                                    value="Registrar">Registrar</button>
                            </div>
                            <div class="col-md-2">
                                <a href="../controlador/ProveedorLista.php" class="btn btn-danger">Cancelar</a>
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
