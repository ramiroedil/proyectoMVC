<?php
include("../componentes/header.php");
?>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Formulario / </span>Modificar Empleados</h4>

  <!-- Basic Layout & Basic with Icons -->
  <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-dark">
          <h5 class="text-white">Modificacion de Empleado</h5>
          <small class="text-muted float-end">Modificando un empleado</small>
        </div>
        <div class="card-body">
          <form method="get" action="../controlador/empleadoModificar.php">
            <div class="row mb-3">
              <input type="hidden" class="form-control" name="id" id="id" value="<?= $r['id_empleado'] ?>">
              <div class="row sm-2">
                <label for="largeSelect" class="col-sm-2 col-form-label">Cargo</label>
                <div class="col-sm-10">
                  <!-- obtenemos loss cargos del objeto res y los cargamos al select -->
                  <select id="largeSelect" class="form-select form-select-lg" name="id_cargo">
                    <?php
                    while ($ree = mysqli_fetch_array($res)) {
                      // Seleccionar el cargo actual del empleado
                      $selected = ($ree['id_cargo'] == $r['id_cargo']) ? 'selected' : '';
                    ?>
                      <option value="<?= $ree['id_cargo']; ?>" <?= $selected ?>><?= $ree['cargo']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">CI</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el CI..." name="ci"
                    value="<?= $r['ci'] ?>" />
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nombre</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el nombre del empleado..."
                    name="nombre" value="<?= $r['nombre'] ?>" />
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Paterno</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el paterno del empleado..."
                    name="paterno" value="<?= $r['paterno'] ?>" />
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Materno</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el materno del empleado..."
                    name="materno" value="<?= $r['materno'] ?>" />
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Direccion</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca la dirección del empleado..."
                    name="direccion" value="<?= $r['direccion'] ?>" />
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Telefono</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el teléfono del empleado..."
                    name="telefono" value="<?= $r['telefono'] ?>" />
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Fecha de Nacimiento</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" placeholder="..." name="fechanacimiento"
                    value="<?= $r['fechanacimiento'] ?>" />
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Genero</label>
                <div class="col-sm-10">
                  <select class="form-select" name="genero" id="genero">
                    <option value="">Seleccione</option>
                    <option value="F" <?= ($r['genero'] == 'F') ? 'selected' : '' ?>>Femenino</option>
                    <option value="M" <?= ($r['genero'] == 'M') ? 'selected' : '' ?>>Masculino</option>
                  </select>
                </div>
              </div>
              <br>
              <br>
              <br>
              <div class="row sm-2">
                <label class="col sm-2 col-form-label">Intereses</label>
                <div class="col-sm-10">
                  <textarea class="form-control" placeholder="Intereses..." rows="3"
                    name="intereses"><?= $r['intereses'] ?></textarea>
                </div>
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col md-2">

              </div>
              <div class="col-md-6"></div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary" name="modificarCargo" value="Modificar">Modificar</button>
              </div>
              <div class="col-md-2">
                <a href="../controlador/cargoLista.php" class="btn btn-danger">Cancelar</a>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <?php
  include("../componentes/footer.php");
  ?>