<?php
include("../componentes/header.php");
?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <a href="../controlador/usuarioRegistro.php?usuario=administrador" class="text-decoration-none text-dark">
            <div class="card text-center">
                <div class="card-header">
                    <img src="../imagenes/administrador.jpg" alt="Administrador" class="img-fluid rounded">
                </div>
                <div class="card-body">
                    <h5><i class="bi bi-pencil-fill"></i> Administrador</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="../controlador/usuarioRegistro.php?usuario=cajero" class="text-decoration-none text-dark">
            <div class="card text-center">
                <div class="card-header">
                    <img src="../imagenes/cajero.jpg" alt="Cajero" class="img-fluid rounded">
                </div>
                <div class="card-body">
                    <h5><i class="bi bi-pencil-fill"></i> Cajero</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="../controlador/usuarioRegistro.php?usuario=cliente" class="text-decoration-none text-dark">
            <div class="card text-center">
                <div class="card-header">
                    <img src="../imagenes/cliente.jpg" alt="Cliente" class="img-fluid rounded">
                </div>
                <div class="card-body">
                    <h5><i class="bi bi-pencil-fill"></i> Cliente</h5>
                </div>
            </div>
        </a>
    </div>
</div>
<?php
include("../componentes/footer.php");
?>

