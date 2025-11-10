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

            <!-- MOSTRAR MENSAJES DE ERROR/ÉXITO -->
            <?php if (!empty($error_mensaje)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> 
                    <strong>Error:</strong> <?php echo htmlspecialchars($error_mensaje); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($exito_mensaje)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> 
                    <strong>Éxito:</strong> <?php echo htmlspecialchars($exito_mensaje); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

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
                                    <small class="text-muted">
                                        NIT/CI: <?php echo htmlspecialchars($cliente_seleccionado['ci'] ?? 'No especificado'); ?>
                                    </small>
                                    <form method="POST" class="mt-2">
                                        <button type="submit" name="cambiar_cliente" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Cambiar Cliente
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <!-- Selección desde lista -->
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <label class="form-label mb-0"><strong>Seleccionar de la lista:</strong></label>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                                        <i class="fas fa-user-plus"></i> Nuevo Cliente
                                    </button>
                                </div>
                                
                                <!-- Selector de clientes -->
                                <div class="mb-3">
                                    <select class="form-select" name="cliente_lista" id="clienteSelect">
                                        <option value="">-- Seleccionar Cliente --</option>
                                        <?php if (!empty($clientes)): ?>
                                            <?php foreach($clientes as $cliente): ?>
                                                <option value="<?php echo $cliente['id']; ?>" 
                                                        data-nombre="<?php echo htmlspecialchars($cliente['razon_social'] ?? $cliente['nombre']); ?>"
                                                        data-ci="<?php echo htmlspecialchars($cliente['nit_ci'] ?? $cliente['ci']); ?>">
                                                    <?php echo htmlspecialchars($cliente['razon_social'] ?? $cliente['nombre']); ?> 
                                                    - <?php echo htmlspecialchars($cliente['nit_ci'] ?? $cliente['ci']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <button type="button" class="btn btn-primary mt-2" onclick="seleccionarDeSelect()">
                                        <i class="fas fa-check"></i> Seleccionar
                                    </button>
                                </div>

                                <hr>

                                <!-- Búsqueda de cliente -->
                                <form method="POST" class="mb-3">
                                    <label class="form-label"><strong>Buscar Cliente por Nombre o CI/NIT:</strong></label>
                                    <div class="input-group">
                                        <input type="text" 
                                               name="busqueda_cliente" 
                                               class="form-control" 
                                               value="<?php echo isset($_POST['busqueda_cliente']) ? htmlspecialchars($_POST['busqueda_cliente']) : ''; ?>"
                                               placeholder="Ingrese nombre o CI/NIT">
                                        <button type="submit" name="buscar_cliente" class="btn btn-info">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </form>

                                <!-- Resultados de búsqueda -->
                                <?php if (!empty($busqueda_resultado)): ?>
                                    <div class="border rounded p-2" style="max-height: 300px; overflow-y: auto;">
                                        <h6>Resultados de búsqueda (<?php echo count($busqueda_resultado); ?>):</h6>
                                        <?php foreach($busqueda_resultado as $cliente): ?>
                                            <div class="border-bottom py-2">
                                                <form method="POST" style="display: inline; width: 100%;">
                                                    <input type="hidden" name="cliente_id" value="<?php echo $cliente['id']; ?>">
                                                    <input type="hidden" name="cliente_nombre" value="<?php echo htmlspecialchars($cliente['razon_social'] ?? $cliente['nombre']); ?>">
                                                    <input type="hidden" name="cliente_ci" value="<?php echo htmlspecialchars($cliente['nit_ci'] ?? $cliente['ci']); ?>">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong><?php echo htmlspecialchars($cliente['razon_social'] ?? $cliente['nombre']); ?></strong><br>
                                                            <small class="text-muted">
                                                                NIT/CI: <?php echo htmlspecialchars($cliente['nit_ci'] ?? $cliente['ci']); ?>
                                                            </small>
                                                        </div>
                                                        <button type="submit" name="seleccionar_cliente" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Seleccionar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php elseif (isset($_POST['buscar_cliente']) && empty($busqueda_resultado)): ?>
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle"></i> No se encontraron clientes con esos datos
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONFIGURACIÓN DE VENTA -->
            <?php if ($cliente_seleccionado): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5><i class="fas fa-cog"></i> CONFIGURACIÓN DE VENTA</h5>
                        </div>
                        <div class="card-body">
                            <!-- ✅ FORMULARIO PRINCIPAL - ENCAPSULA TODO -->
                            <form method="POST" id="formProcesarVenta">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="metodo_pago" class="form-label"><strong>Método de Pago:</strong></label>
                                        <select class="form-select" name="metodo_pago" id="metodo_pago" required>
                                            <option value="">-- Seleccionar Método --</option>
                                            <option value="EFECTIVO">💵 Efectivo</option>
                                            <option value="TARJETA">💳 Tarjeta de Crédito/Débito</option>
                                            <option value="TRANSFERENCIA">🏦 Transferencia Bancaria</option>
                                            <option value="CHEQUE">📄 Cheque</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="observaciones" class="form-label"><strong>Observaciones (opcional):</strong></label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="observaciones" 
                                               id="observaciones" 
                                               placeholder="Notas sobre la venta"
                                               maxlength="255">
                                    </div>
                                </div>

                                <!-- BOTÓN PROCESAR DENTRO DEL FORMULARIO -->
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" name="procesar_venta" class="btn btn-success btn-lg" id="btnProcesarVenta">
                                            <i class="fas fa-check-circle"></i> PROCESAR VENTA
                                        </button>
                                        <a href="../vista/carrito_ventas.php" class="btn btn-secondary btn-lg ms-2">
                                            <i class="fas fa-arrow-left"></i> Volver al Carrito
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <!-- BOTONES SIN CLIENTE SELECCIONADO -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Debe seleccionar un cliente para procesar la venta
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODAL NUEVO CLIENTE -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoClienteLabel">
                        <i class="fas fa-user-plus"></i> Registrar Nuevo Cliente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="razonsocial" class="form-label">
                            Razón Social <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               name="razonsocial" 
                               id="razonsocial" 
                               placeholder="Nombre o razón social del cliente" 
                               required
                               maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="nit_ci" class="form-label">
                            NIT o CI <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               name="nit_ci" 
                               id="nit_ci" 
                               placeholder="Número de identificación" 
                               required
                               maxlength="50">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" name="registrarClienteModal" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar y Seleccionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
/**
 * Seleccionar cliente desde el select
 */
function seleccionarDeSelect() {
    const select = document.getElementById('clienteSelect');
    const selectedOption = select.options[select.selectedIndex];
    
    if (!selectedOption.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Selección Requerida',
            text: 'Por favor, seleccione un cliente de la lista',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // Crear formulario dinámico
    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';
    
    // Agregar campos
    const fields = {
        'cliente_id': selectedOption.value,
        'cliente_nombre': selectedOption.dataset.nombre,
        'cliente_ci': selectedOption.dataset.ci,
        'seleccionar_cliente': '1'
    };
    
    for (const [name, value] of Object.entries(fields)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
}

/**
 * Validar formulario antes de procesar venta
 */
document.addEventListener('DOMContentLoaded', function() {
    const formProcesar = document.getElementById('formProcesarVenta');
    if (formProcesar) {
        formProcesar.addEventListener('submit', function(e) {
            const selectMetodo = document.getElementById('metodo_pago');
            
            // Validar que método de pago esté seleccionado
            if (!selectMetodo.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Método de Pago Requerido',
                    text: 'Debe seleccionar un método de pago',
                    confirmButtonText: 'OK'
                });
                return false;
            }
            
            // Si todo está bien, permitir envío del formulario
            // El controlador procesará y redirigirá
        });
    }
});
</script>

<?php include("../componentes/footer.php"); ?>