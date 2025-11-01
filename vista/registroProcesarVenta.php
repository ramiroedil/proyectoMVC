<?php
session_start();
include_once("../modelo/clienteClase.php");
include_once("../modelo/ventaClase.php");

$cliente_seleccionado = null;
$busqueda_resultado = [];

if ($_POST) {
    if (isset($_POST['buscar_cliente'])) {
        $busqueda = trim($_POST['busqueda_cliente']);
        if (!empty($busqueda)) {
            $cliente_obj = new clientes("", "", "", "");
            
            include_once("../modelo/conexion.php");
            $db = new Conexion();
            $sql = $db->query("SELECT * FROM cliente WHERE (razonsocial LIKE '$busqueda%' OR nit_ci LIKE '$busqueda%') AND estado='activo'");
            $busqueda_resultado = $sql;
        }
    }
    
    if (isset($_POST['seleccionar_cliente'])) {
        $cliente_id = $_POST['cliente_id'];
        $cliente_nombre = $_POST['cliente_nombre'];
        $cliente_ci = $_POST['cliente_ci'];
        
        $_SESSION['cliente_venta'] = [
            'id' => $cliente_id,
            'nombre' => $cliente_nombre,
            'ci' => $cliente_ci
        ];
        $cliente_seleccionado = $_SESSION['cliente_venta'];
    }
    
    if (isset($_POST['procesar_venta']) && isset($_SESSION['cliente_venta']) && isset($_SESSION['carrito_ventas1'])) {
        // Aquí se procesaría la venta
        if (empty($_SESSION['carrito_ventas1'])) {
                throw new Exception("El carrito está vacío");
            }
            
            // Verificar que hay un cliente seleccionado
            if (empty($_SESSION['cliente_venta']['id'])) {
                throw new Exception("No se ha seleccionado un cliente");
            }
             $id_empleado = $_SESSION['usuarios']['id_usuario'] ?? 1; // Valor por defecto o manejar error
            
            $id_cliente = $_SESSION['cliente_venta']['id'];
            $fecha = date('Y-m-d');
            $venta = new Venta("", $id_empleado, $id_cliente, $fecha);
            
            // Procesar la venta
            $id_venta_nueva = $venta->procesarVenta($_SESSION['carrito_ventas1']);
            
        $_SESSION['mensaje_venta'] = "Venta procesada correctamente";
        $_SESSION['venta_exitosa'] = $id_venta_nueva;
        // Limpiar carrito y cliente
        unset($_SESSION['carrito_ventas1']);
        unset($_SESSION['cliente_venta']);
        header("Location: ../vista/ventaExitosa.php");
            exit();
            
    }
}

// Si ya hay un cliente seleccionado en sesión
if (isset($_SESSION['cliente_venta'])) {
    $cliente_seleccionado = $_SESSION['cliente_venta'];
}

// Función para calcular el total del carrito
function calcularTotal()
{
    $total = 0;
    if (isset($_SESSION['carrito_ventas1']) && is_array($_SESSION['carrito_ventas1'])) {
        foreach ($_SESSION['carrito_ventas1'] as $item) {
            if (isset($item['subtotal'])) {
                $total += floatval($item['subtotal']);
            }
        }
    }
    return $total;
}

include("../componentes/header.php");
?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-cash-register"></i> PROCESAR VENTA</h2>
                <a href="../controlador/controlaventaCarrito.php" class="btn btn-secondary">
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
                            <!-- Cliente ya seleccionado -->
                            <?php if ($cliente_seleccionado): ?>
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
                                <!-- Selección desde lista completa -->
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <label class="form-label mb-0">Seleccionar de la lista:</label>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                                        <i class="fas fa-user-plus"></i> Nuevo Cliente
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="cliente_lista" id="clienteSelect">
                                        <option value="">-- Seleccionar Cliente --</option>
                                        <?php while($cliente = $resul->fetch_assoc()): ?>
                                            <option value="<?php echo $cliente['id_cliente']; ?>" 
                                                    data-nombre="<?php echo htmlspecialchars($cliente['razonsocial']); ?>"
                                                    data-ci="<?php echo htmlspecialchars($cliente['nit_ci']); ?>">
                                                <?php echo htmlspecialchars($cliente['razonsocial']) . ' - ' . htmlspecialchars($cliente['nit_ci']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <button type="button" class="btn btn-primary mt-2" onclick="seleccionarDeSelect()">
                                        <i class="fas fa-check"></i> Seleccionar
                                    </button>
                                </div>

                                <hr>

                                <!-- Búsqueda de cliente -->
                                <form method="POST" class="mb-3">
                                    <label class="form-label">Buscar Cliente por CI o NIT:</label>
                                    <div class="input-group">
                                        <input type="text" name="busqueda_cliente" class="form-control" 
                                               value="<?php echo isset($_POST['busqueda_cliente']) ? htmlspecialchars($_POST['busqueda_cliente']) : ''; ?>">
                                        <button type="submit" name="buscar_cliente" class="btn btn-info">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                   </form>

                                <!-- Resultados de búsqueda -->
                                <?php if (!empty($busqueda_resultado)): ?>
                                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                        <h6>Resultados de búsqueda:</h6>
                                        <?php while($cliente = $busqueda_resultado->fetch_assoc()): ?>
                                            <div class="border-bottom py-2">
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="cliente_id" value="<?php echo $cliente['id_cliente']; ?>">
                                                    <input type="hidden" name="cliente_nombre" value="<?php echo htmlspecialchars($cliente['razonsocial']); ?>">
                                                    <input type="hidden" name="cliente_ci" value="<?php echo htmlspecialchars($cliente['nit_ci']); ?>">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong><?php echo htmlspecialchars($cliente['razonsocial']); ?></strong><br>
                                                            <small class="text-muted">CI/NIT: <?php echo htmlspecialchars($cliente['nit_ci']); ?></small>
                                                        </div>
                                                        <button type="submit" name="seleccionar_cliente" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Seleccionar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- RESUMEN DEL CARRITO -->
                <!-- <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5><i class="fas fa-shopping-cart"></i> RESUMEN DE COMPRA</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cant.</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($_SESSION['carrito_ventas1'] as $item): ?>
                                            <tr>
                                                <td>
                                                    <small><?php echo htmlspecialchars($item['nombre']); ?></small>
                                                </td>
                                                <td><?php echo $item['cantidad']; ?></td>
                                                <td>Bs <?php echo number_format($item['precio'], 2); ?></td>
                                                <td>Bs <?php echo number_format($item['subtotal'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="table-dark">
                                        <tr>
                                            <td colspan="3"><strong>TOTAL:</strong></td>
                                            <td><strong>Bs <?php echo number_format(calcularTotal(), 2); ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

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
                            
                            <a href="../vista/carrito.php" class="btn btn-secondary btn-lg ms-2">
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
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalNuevoClienteLabel">Registrar Nuevo Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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
        // Crear formulario dinámico para enviar los datos
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

// Mostrar mensaje si existe
<?php if (isset($_SESSION['mensaje_venta'])): ?>
    Swal.fire({
        title: 'Éxito',
        text: '<?php echo $_SESSION['mensaje_venta']; ?>',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    <?php unset($_SESSION['mensaje_venta']); ?>
<?php endif; ?>
</script>

<?php
// Procesar registro rápido de cliente desde el modal
if (isset($_POST['registrarClienteModal'])) {
    include_once("../modelo/clienteClase.php");
    $razon = trim($_POST['razonsocial']);
    $ci = trim($_POST['nit_ci']);
    if ($razon && $ci) {
        $nuevoCliente = new clientes("", $razon, $ci, "activo");
        if ($nuevoCliente->grabarCliente()) {
            // Obtener el ID del cliente recién creado
            include_once("../modelo/conexion.php");
            $db = new Conexion();
            $sql = $db->query("SELECT * FROM cliente WHERE razonsocial='$razon' AND nit_ci='$ci' ORDER BY id_cliente DESC LIMIT 1");
            if ($sql && $row = $sql->fetch_assoc()) {
                $_SESSION['cliente_venta'] = [
                    'id' => $row['id_cliente'],
                    'nombre' => $row['razonsocial'],
                    'ci' => $row['nit_ci']
                ];
                echo "<script>window.location.reload();</script>";
                exit();
            }
        } else {
            echo "<script>Swal.fire('Error','No se pudo registrar el cliente','error');</script>";
        }
    } else {
        echo "<script>Swal.fire('Error','Complete todos los campos','error');</script>";
    }
}
?>

<?php include("../componentes/footer.php"); ?>