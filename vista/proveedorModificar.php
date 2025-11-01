<?php
include("../componentes/header.php");
?>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Formulario / </span>Modificar Proveedores</h4>

  <!-- Basic Layout & Basic with Icons -->
  <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Modificacion de Proveedores</h5>
          <small class="text-muted float-end">Modificando un proveedor</small>
        </div>
        <div class="card-body">
          <form method="get" action="../controlador/proveedorModificar.php" enctype="multipart/form-data">
            <div class="row mb-3">
              <input type="hidden" class="form-control" name="id" id="id" value="<?= $r['id_proveedor'] ?>">
              <div class="row sm-2">
                <label for="largeSelect" class="col-sm-2 col-form-label">Empresa</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca la empresa..." name="empresa"
                    value="<?= $r['empresa'] ?>" />
                </div>
              </div>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Contacto</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el contacto..." name="contacto"
                    value="<?= $r['contacto'] ?>" />
                </div>
              </div>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Correo</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el correo..." name="mail"
                    value="<?= $r['mail'] ?>" />
                </div>
              </div>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Telefono</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca el telefono..." name="telefono"
                    value="<?= $r['telefono'] ?>" />
                </div>
              </div>
              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Direccion</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Introduzca la direccion..." name="direccion"
                    value="<?= $r['direccion'] ?>" />
                </div>
              </div>
              
                <?php if (!empty($r['logo'])): ?>
                <div class="input-style-1">
                <span class="position-absolute top-0 start-0 m-2">Foto actual del producto:</span>
                <label class="position-relative d-block" style="height: 220px;">
                    <div class="d-flex justify-content-center align-items-center h-100">
                      <img src="../controlador/imagenes/<?= htmlspecialchars($r['logo']) ?>" alt="Foto del producto"
                        style="width: 200px; height: 200px;" class="img-fluid">
                    </div>
                  </label>
                </div>
              <?php endif; ?>

              <div class="row sm-2">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Logo</label>
                <div class="col-sm-10">
                  <div class="col-sm-10">
                    <input accept=".jpg, .png, .jpeg" class="form-control" type="file" id="logo" name="logo"
                      value="<?= $r['logo'] ?>" />
                  </div>
                </div>
                <div class="row justify-content-end">
                  <div class="col md-2">

                  </div>
                  <div class="col-md-6"></div>
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" name="modificarProveedor"
                      value="Modificar">Modificar</button>
                  </div>
                  <div class="col-md-2">
                    <a href="../controlador/proveedorLista.php" class="btn btn-danger">Cancelar</a>
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