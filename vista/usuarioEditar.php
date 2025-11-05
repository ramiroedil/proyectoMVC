<?php include("../componentes/header.php"); ?>

<main class="main-wrapper">
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-user-edit"></i> Editar Usuario</h3>
            </div>
            <div class="card-body">
                <?php if (isset($usuarioEditar) && !empty($usuarioEditar)): ?>
                <form action="../controlador/usuarioEditar.php" method="post">
                    <input type="hidden" name="id" value="<?= $usuarioEditar['id'] ?>">
                    <input type="hidden" name="tipo_usuario_original" value="<?= $usuarioEditar['tipo_usuario'] ?>">
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['nombre']) ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Apellido Paterno:</label>
                            <input type="text" name="paterno" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['apellido_paterno']) ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Apellido Materno:</label>
                            <input type="text" name="materno" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['apellido_materno'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">CI:</label>
                            <input type="text" name="ci" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['ci']) ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombre de usuario:</label>
                            <input type="text" name="usuario" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['usuario']) ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['email']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono:</label>
                            <input type="text" name="telefono" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['telefono'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha de nacimiento:</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" 
                                   value="<?= isset($usuarioEditar['fecha_nacimiento']) ? substr($usuarioEditar['fecha_nacimiento'], 0, 10) : '' ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Género:</label>
                            <select name="genero" class="form-control">
                                <option value="">Seleccione...</option>
                                <option value="M" <?= ($usuarioEditar['genero'] ?? '') == 'M' ? 'selected' : '' ?>>Masculino</option>
                                <option value="F" <?= ($usuarioEditar['genero'] ?? '') == 'F' ? 'selected' : '' ?>>Femenino</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Dirección:</label>
                            <input type="text" name="direccion" class="form-control" 
                                   value="<?= htmlspecialchars($usuarioEditar['direccion'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado:</label>
                            <select name="estado" class="form-control">
                                <option value="1" <?= ($usuarioEditar['estado'] == true || $usuarioEditar['estado'] == 1) ? 'selected' : '' ?>>Activo</option>
                                <option value="0" <?= ($usuarioEditar['estado'] == false || $usuarioEditar['estado'] == 0) ? 'selected' : '' ?>>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" name="edit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Usuario
                        </button>
                        <a href="../controlador/usuarioLista.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
                <?php else: ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    No se pudieron cargar los datos del usuario.
                    <a href="../controlador/usuarioLista.php">Volver a la lista</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include("../componentes/footer.php"); ?>