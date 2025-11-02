<?php include("../componentes/header.php"); ?>

<div class="container-xxl">
    <h4 class="fw-bold py-3 mb-4">Modificar Empleado</h4>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Modificación de Empleado</h5>
        </div>
        <div class="card-body">
            <form method="get" action="../controlador/empleadoModificar.php">
                <input type="hidden" name="id" value="<?= $r['id']; ?>">
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="id_cargo" required>
                            <?php foreach ($cargos as $cargo): ?>
                                <option value="<?= $cargo['id']; ?>" 
                                        <?= ($cargo['id'] == $r['cargo']['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($cargo['cargo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">CI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ci" 
                               value="<?= htmlspecialchars($r['ci']); ?>" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" 
                               value="<?= htmlspecialchars($r['nombre']); ?>" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Paterno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="paterno" 
                               value="<?= htmlspecialchars($r['paterno']); ?>" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Materno</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="materno" 
                               value="<?= htmlspecialchars($r['materno']); ?>" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="direccion" 
                               value="<?= htmlspecialchars($r['direccion']); ?>" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="telefono" 
                               value="<?= htmlspecialchars($r['telefono']); ?>" />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fechanacimiento" 
                               value="<?= $r['fecha_nacimiento']; ?>" required />
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Género</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="genero" required>
                            <option value="">Seleccione</option>
                            <option value="F" <?= ($r['genero'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
                            <option value="M" <?= ($r['genero'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Intereses</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="intereses" rows="3"><?= htmlspecialchars($r['intereses']); ?></textarea>
                    </div>
                </div>
                
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" name="modificarEmpleado">Modificar</button>
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