<?php include("../componentes/header.php"); ?>

<div class="col-xxl">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Registro de Empleado</h5>
        </div>
        <div class="card-body">
            <form method="post" action="../controlador/empleadoRegistroCo.php">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="id_cargo" required>
                            <option value="">Seleccione un cargo</option>
                            <?php foreach ($cargos as $cargo): ?>
                                <option value="<?= $cargo['id']; ?>"><?= htmlspecialchars($cargo['cargo']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">CI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ci" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Paterno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="paterno" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Materno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="materno" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="direccion" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telefono" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fechanacimiento" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Género</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="genero" required>
                            <option value="">Seleccione</option>
                            <option value="F">Femenino</option>
                            <option value="M">Masculino</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Intereses</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="intereses" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" name="registrarEmpleado">Registrar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="../controlador/empleadoLista.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../componentes/footer.php"); ?>