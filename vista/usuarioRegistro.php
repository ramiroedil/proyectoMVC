<?php include("../componentes/header.php"); ?>

<div class="row justify-content-center">
    <div class="col-md-12">
        <h2 class="text-center mb-4">Seleccione el Tipo de Usuario a Registrar</h2>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-4">
        <a href="../controlador/usuarioRegistro.php?usuario=administrador" class="text-decoration-none">
            <div class="card text-center hover-shadow">
                <div class="card-header bg-danger text-white">
                    <h5><i class="fas fa-user-shield fa-3x mb-2"></i></h5>
                </div>
                <div class="card-body">
                    <h4 class="text-danger">Administrador</h4>
                    <p class="text-muted">Acceso completo al sistema</p>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-4">
        <a href="../controlador/usuarioRegistro.php?usuario=cajero" class="text-decoration-none">
            <div class="card text-center hover-shadow">
                <div class="card-header bg-warning text-dark">
                    <h5><i class="fas fa-cash-register fa-3x mb-2"></i></h5>
                </div>
                <div class="card-body">
                    <h4 class="text-warning">Cajero</h4>
                    <p class="text-muted">Gestión de ventas</p>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-4">
        <a href="../controlador/usuarioRegistro.php?usuario=cliente" class="text-decoration-none">
            <div class="card text-center hover-shadow">
                <div class="card-header bg-info text-white">
                    <h5><i class="fas fa-user fa-3x mb-2"></i></h5>
                </div>
                <div class="card-body">
                    <h4 class="text-info">Cliente</h4>
                    <p class="text-muted">Usuario estándar</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-md-4 text-center">
        <a href="../controlador/usuarioLista.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Lista de Usuarios
        </a>
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>

<?php include("../componentes/footer.php"); ?>