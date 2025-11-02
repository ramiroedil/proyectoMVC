<?php
require_once(__DIR__ . '/../helpers/Session.php');

include("../componentes/header.php");
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-cash-register"></i> PROCESAR VENTA</h2>
                <a href="../vista/carrito_ventas.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Carrito
                </a>
            </div>

            <div class="row">
                <!-- SELECCIÓN DE CLIENTE -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5><i class="fas fa-user"></i> SELECCIONAR CLIENTE</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($cliente_seleccionado): ?>
                                <!-- Cliente ya seleccionado -->
                                <div class="alert alert-success">
                                    <h6><i class="fas fa-check-circle"></i> Cliente Seleccionado:</h6>
                                    <strong><?php echo htmlspecialchars($cliente_seleccionado['nombre']); ?></strong><br>
                                    <small>CI/NIT: <?php echo htmlspecialchars($cliente_seleccionado['ci']); ?></small>
                                    <form method="POST" class="mt-2">
                                        <button type="submit" name="cambiar_cliente" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Cambiar Cliente
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <!-- Selección desde lista -->
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <label class="form-label mb-0">Seleccionar de la lista:</label>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                                        <i class="fas fa-user-plus"></i> Nuevo Cliente
                                    </button>
                                </div>
                                
                                <div class="mb-3">
                                    <select class="form-select" name="cliente_lista" id="clienteSelect">
                                        <option value="">-- Seleccionar Cliente --</option>
                                        <?php foreach($clientes as $cliente): ?>
                                            <option value="<?php echo $cliente['id']; ?>" 
                                                    data-nombre="<?php echo htmlspecialchars($cliente['razon_social']); ?>"
                                                    data-ci="<?php echo htmlspecialchars($cliente['nit_ci']); ?>">
                                                <?php echo htmlspecialchars($cliente['razon_social']) . ' - ' . htmlspecialchars($cliente['nit_ci']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" class="btn btn-primary mt-2" onclick="seleccionarDeSelect()">
                                        <i class="fas fa-check"></i> Seleccionar
                                    </button>
                                </div>

                                <hr>

                                <!-- Búsqueda de cliente -->
                                <form method="POST" class="mb-3">
                                    <label class="form-label">Buscar Cliente por Nombre o CI/NIT:</label>
                                    <div class="input-group">
                                        <input type="text" name="busqueda_cliente" class="form-control" 
                                               value="<?php echo isset($_POST['busqueda_cliente']) ? htmlspecialchars($_POST['busqueda_cliente']) : ''; ?>"
                                               placeholder="Ingrese nombre o CI/NIT">
                                        <button type="submit" name="buscar_cliente" class="btn btn-info">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </form>

                                <!-- Resultados de búsqueda -->
                                <?php if (!empty($busqueda_resultado)): ?>
                                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                        <h6>Resultados de búsqueda:</h6>
                                        <?php foreach($busqueda_resultado as $cliente): ?>
                                            <div class="border-bottom py-2">
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="cliente_id" value="<?php echo $cliente['id']; ?>">
                                                    <input type="hidden" name="cliente_nombre" value="<?php echo htmlspecialchars($cliente['razon_social']); ?>">
                                                    <input type="hidden" name="cliente_ci" value="<?php echo htmlspecialchars($cliente['nit_ci']); ?>">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong><?php echo htmlspecialchars($cliente['razon_social']); ?></strong><br>
                                                            <small class="text-muted">CI/NIT: <?php echo htmlspecialchars($cliente['nit_ci']); ?></small>
                                                        </div>
                                                        <button type="submit" name="seleccionar_cliente" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Seleccionar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTONES DE ACCIÓN -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if ($cliente_seleccionado): ?>
                                <form method="POST" style="display: inline;">
                                    <button type="submit" name="procesar_venta" class="btn btn-success btn-lg">
                                        <i class="fas fa-check-circle"></i> PROCESAR VENTA
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Debe seleccionar un cliente para procesar la venta
                                </div>
                            <?php endif; ?>
                            
                            <a href="../vista/carrito_ventas.php" class="btn btn-secondary btn-lg ms-2">
                                <i class="fas fa-arrow-left"></i> Volver al Carrito
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVO CLIENTE -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="razonsocial" class="form-label">Razón Social</label>
                        <input type="text" class="form-control" name="razonsocial" id="razonsocial" required>
                    </div>
                    <div class="mb-3">
                        <label for="nit_ci" class="form-label">NIT o CI</label>
                        <input type="text" class="form-control" name="nit_ci" id="nit_ci" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="registrarClienteModal" class="btn btn-primary">Registrar y Seleccionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function seleccionarDeSelect() {
    const select = document.getElementById('clienteSelect');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.style.display = 'none';
        
        const inputId = document.createElement('input');
        inputId.name = 'cliente_id';
        inputId.value = selectedOption.value;
        
        const inputNombre = document.createElement('input');
        inputNombre.name = 'cliente_nombre';
        inputNombre.value = selectedOption.dataset.nombre;
        
        const inputCi = document.createElement('input');
        inputCi.name = 'cliente_ci';
        inputCi.value = selectedOption.dataset.ci;
        
        const inputAction = document.createElement('input');
        inputAction.name = 'seleccionar_cliente';
        inputAction.value = '1';
        
        form.appendChild(inputId);
        form.appendChild(inputNombre);
        form.appendChild(inputCi);
        form.appendChild(inputAction);
        
        document.body.appendChild(form);
        form.submit();
    } else {
        alert('Por favor seleccione un cliente');
    }
}
</script>

<?php include("../componentes/footer.php"); ?>