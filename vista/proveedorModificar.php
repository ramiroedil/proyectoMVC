<?php include("../componentes/header.php"); ?>

<main class="main-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl">
                <!-- CARD MODIFICACIÓN -->
                <div class="card mb-4 shadow">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-edit"></i> Modificar Proveedor
                        </h5>
                    </div>

                    <div class="card-body">
                        <!-- MENSAJES DE ERROR -->
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i>
                                <strong>Error:</strong> <?= $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- FORMULARIO -->
                        <form method="POST" action="../controlador/proveedorModificar.php" enctype="multipart/form-data" id="formProveedor">
                            <input type="hidden" name="id" value="<?= $r['id']; ?>">

                            <!-- SECCIÓN 1: INFORMACIÓN DE EMPRESA -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-building"></i> Información de Empresa
                                    </h6>
                                </div>

                                <!-- Nombre Empresa -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre Empresa <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="empresa" 
                                           placeholder="Ej: Empresa XYZ S.A."
                                           value="<?= htmlspecialchars($r['empresa'] ?? ''); ?>"
                                           required />
                                </div>

                                <!-- NIT -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIT</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="nit" 
                                           placeholder="Ej: 1234567890"
                                           value="<?= htmlspecialchars($r['nit'] ?? ''); ?>" />
                                    <small class="text-muted">Opcional</small>
                                </div>

                                <!-- Sitio Web -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sitio Web</label>
                                    <input type="url" 
                                           class="form-control" 
                                           name="sitio_web" 
                                           placeholder="https://www.ejemplo.com"
                                           value="<?= htmlspecialchars($r['sitio_web'] ?? ''); ?>" />
                                    <small class="text-muted">Opcional</small>
                                </div>
                            </div>

                            <!-- SECCIÓN 2: INFORMACIÓN DE CONTACTO -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-user"></i> Información de Contacto
                                    </h6>
                                </div>

                                <!-- Nombre Contacto -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre Contacto</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="contacto_nombre" 
                                           placeholder="Ej: Juan Pérez"
                                           value="<?= htmlspecialchars($r['contacto_nombre'] ?? ''); ?>" />
                                    <small class="text-muted">Opcional</small>
                                </div>

                                <!-- Cargo Contacto -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cargo</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="contacto_cargo" 
                                           placeholder="Ej: Gerente, Director"
                                           value="<?= htmlspecialchars($r['contacto_cargo'] ?? ''); ?>" />
                                    <small class="text-muted">Opcional</small>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control" 
                                           name="email" 
                                           placeholder="contacto@empresa.com"
                                           value="<?= htmlspecialchars($r['email'] ?? ''); ?>"
                                           required />
                                </div>

                                <!-- Teléfono -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="telefono" 
                                           placeholder="+591 70123456"
                                           value="<?= htmlspecialchars($r['telefono'] ?? ''); ?>"
                                           required />
                                </div>
                            </div>

                            <!-- SECCIÓN 3: UBICACIÓN -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-map-marker-alt"></i> Ubicación
                                    </h6>
                                </div>

                                <!-- Dirección -->
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Dirección <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="direccion" 
                                           placeholder="Calle, número, apto"
                                           value="<?= htmlspecialchars($r['direccion'] ?? ''); ?>"
                                           required />
                                </div>

                                <!-- Ciudad -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Ciudad</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="ciudad" 
                                           placeholder="La Paz, Cochabamba"
                                           value="<?= htmlspecialchars($r['ciudad'] ?? ''); ?>" />
                                    <small class="text-muted">Opcional</small>
                                </div>

                                <!-- País -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">País</label>
                                    <select class="form-select" name="pais">
                                        <option value="Bolivia" <?= (($r['pais'] ?? 'Bolivia') === 'Bolivia') ? 'selected' : ''; ?>>Bolivia</option>
                                        <option value="Argentina" <?= (($r['pais'] ?? '') === 'Argentina') ? 'selected' : ''; ?>>Argentina</option>
                                        <option value="Brasil" <?= (($r['pais'] ?? '') === 'Brasil') ? 'selected' : ''; ?>>Brasil</option>
                                        <option value="Chile" <?= (($r['pais'] ?? '') === 'Chile') ? 'selected' : ''; ?>>Chile</option>
                                        <option value="Colombia" <?= (($r['pais'] ?? '') === 'Colombia') ? 'selected' : ''; ?>>Colombia</option>
                                        <option value="Perú" <?= (($r['pais'] ?? '') === 'Perú') ? 'selected' : ''; ?>>Perú</option>
                                        <option value="Uruguay" <?= (($r['pais'] ?? '') === 'Uruguay') ? 'selected' : ''; ?>>Uruguay</option>
                                        <option value="Venezuela" <?= (($r['pais'] ?? '') === 'Venezuela') ? 'selected' : ''; ?>>Venezuela</option>
                                    </select>
                                </div>
                            </div>

                            <!-- SECCIÓN 4: LOGO -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-image"></i> Logo
                                    </h6>
                                </div>

                                <!-- Logo Actual -->
                                <?php if (!empty($r['logo'])): ?>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Logo Actual</label>
                                        <div>
                                            <img src="<?= htmlspecialchars($r['logo']); ?>" 
                                                 alt="Logo actual" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12 mb-3">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            Sin logo registrado
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Subir Nuevo Logo -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Actualizar Logo</label>
                                    <input type="file" 
                                           class="form-control" 
                                           name="logo" 
                                           accept="image/*"
                                           id="logoInput" />
                                    <small class="text-muted">
                                        Formatos: JPG, PNG, GIF, WebP | Máx: 5MB | Dejar vacío para no cambiar
                                    </small>
                                </div>

                                <!-- Vista previa del nuevo logo -->
                                <div class="col-md-12" id="logoPreview" style="display: none;">
                                    <label class="form-label">Vista previa del nuevo logo</label>
                                    <img id="logoImg" src="" alt="Vista previa" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            </div>

                            <!-- BOTONES DE ACCIÓN -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-warning" name="modificarProveedor">
                                            <i class="fas fa-save"></i> Guardar Cambios
                                        </button>
                                        <a href="../controlador/proveedorLista.php" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- ============================================================================ -->
<!-- JAVASCRIPT PARA VISTA PREVIA DE LOGO -->
<!-- ============================================================================ -->

<script>
    // Vista previa del nuevo logo
    document.getElementById('logoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('logoImg').src = event.target.result;
                document.getElementById('logoPreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('logoPreview').style.display = 'none';
        }
    });

    // Validación del formulario en cliente
    document.getElementById('formProveedor').addEventListener('submit', function(e) {
        const empresa = document.querySelector('input[name="empresa"]').value.trim();
        const email = document.querySelector('input[name="email"]').value.trim();
        const telefono = document.querySelector('input[name="telefono"]').value.trim();
        const direccion = document.querySelector('input[name="direccion"]').value.trim();

        if (!empresa || !email || !telefono || !direccion) {
            e.preventDefault();
            alert('⚠️ Por favor completa todos los campos requeridos (*)');
            return false;
        }

        // Validar email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('⚠️ El email no es válido');
            return false;
        }
    });
</script>

<!-- ============================================================================ -->
<!-- ESTILOS PERSONALIZADOS -->
<!-- ============================================================================ -->

<style>
    .main-wrapper {
        padding: 20px 0;
    }

    .card-header {
        background: #ffc107;
        border-bottom: 2px solid #ff9800;
    }

    h6 {
        color: #333;
        font-weight: 600;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .text-danger {
        color: #dc3545;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .col-md-6,
        .col-md-8,
        .col-md-4,
        .col-md-12 {
            margin-bottom: 1rem;
        }
    }
</style>

<?php include("../componentes/footer.php"); ?>