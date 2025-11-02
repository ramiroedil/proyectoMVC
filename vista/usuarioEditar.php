<?php include("../componentes/header.php"); ?>

<main class="main-wrapper">
    <div class="container">
        <h2>Editar Usuario</h2>
        <form action="../controlador/usuarioEditar.php" method="post">
            <input type="hidden" name="id" value="<?= $datos['id'] ?>">
            
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($datos['nombre']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label>Apellido Paterno:</label>
                <input type="text" name="paterno" class="form-control" value="<?= htmlspecialchars($datos['paterno']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label>Apellido Materno:</label>
                <input type="text" name="materno" class="form-control" value="<?= htmlspecialchars($datos['materno']) ?>">
            </div>
            
            <div class="mb-3">
                <label>CI:</label>
                <input type="text" name="ci" class="form-control" value="<?= htmlspecialchars($datos['ci']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label>Nombre de usuario:</label>
                <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($datos['username']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label>Fecha de nacimiento:</label>
                <input type="date" name="fecha" class="form-control" value="<?= $datos['fecha_nacimiento'] ?>">
            </div>
            
            <div class="mb-3">
                <label>Tipo de usuario:</label>
                <select name="tipo" class="form-control">
                    <option value="administrador" <?= $datos['tipo_usuario'] == 'administrador' ? 'selected' : '' ?>>Administrador</option>
                    <option value="cliente" <?= $datos['tipo_usuario'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                    <option value="cajero" <?= $datos['tipo_usuario'] == 'cajero' ? 'selected' : '' ?>>Cajero</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($datos['email']) ?>">
            </div>
            
            <div class="mb-3">
                <label>Estado:</label>
                <select name="estado" class="form-control">
                    <option value="activo" <?= $datos['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $datos['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            
            <button type="submit" name="edit" class="btn btn-primary">Actualizar Usuario</button>
            <a href="../controlador/usuarioLista.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</main>

<?php include("../componentes/footer.php"); ?>