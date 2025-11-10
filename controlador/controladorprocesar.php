<?php
/**
 * Controlador de Venta - Procesar Venta
 * Maneja la lógica de seleccionar cliente y procesar venta
 */

require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

$api = new ApiClient();

// Variables de estado
$cliente_seleccionado = null;
$busqueda_resultado = [];
$error_mensaje = null;
$exito_mensaje = null;
$clientes = [];

// Obtener clientes activos
try {
    $response_clientes = $api->get('/cliente/active');
    if ($response_clientes['success']) {
        $clientes = $response_clientes['data'] ?? [];
    }
} catch (Exception $e) {
    // Loguear error silenciosamente, continuar con lista vacía
    error_log("Error al obtener clientes: " . $e->getMessage());
}

// Si ya hay cliente seleccionado en sesión
if (Session::has('cliente_venta')) {
    $cliente_seleccionado = Session::get('cliente_venta');
}

/**
 * PROCESAR: Cambiar cliente
 */
if (isset($_POST['cambiar_cliente'])) {
    Session::delete('cliente_venta');
    $cliente_seleccionado = null;
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

/**
 * PROCESAR: Buscar cliente
 */
if (isset($_POST['buscar_cliente'])) {
    $busqueda = trim($_POST['busqueda_cliente'] ?? '');
    if (!empty($busqueda)) {
        try {
            $response_busqueda = $api->get('/cliente/search', ['query' => $busqueda]);
            if ($response_busqueda['success']) {
                $busqueda_resultado = $response_busqueda['data'] ?? [];
                if (empty($busqueda_resultado)) {
                    $error_mensaje = "No se encontraron clientes con esos datos";
                }
            } else {
                $error_mensaje = $response_busqueda['error'] ?? 'Error en la búsqueda';
            }
        } catch (Exception $e) {
            $error_mensaje = "Error al buscar clientes: " . $e->getMessage();
        }
    } else {
        $error_mensaje = "Ingrese un término de búsqueda";
    }
}

/**
 * PROCESAR: Seleccionar cliente
 */
if (isset($_POST['seleccionar_cliente'])) {
    $cliente_id = intval($_POST['cliente_id'] ?? 0);
    $cliente_nombre = trim($_POST['cliente_nombre'] ?? '');
    $cliente_ci = trim($_POST['cliente_ci'] ?? '');
    
    if ($cliente_id > 0 && !empty($cliente_nombre)) {
        Session::set('cliente_venta', [
            'id' => $cliente_id,
            'nombre' => $cliente_nombre,
            'ci' => $cliente_ci
        ]);
        $cliente_seleccionado = Session::get('cliente_venta');
        $exito_mensaje = "Cliente seleccionado correctamente";
        $busqueda_resultado = []; // Limpiar búsqueda
    } else {
        $error_mensaje = "Datos de cliente inválidos";
    }
}

/**
 * PROCESAR: Registrar nuevo cliente desde modal
 */
if (isset($_POST['registrarClienteModal'])) {
    $razon = trim($_POST['razonsocial'] ?? '');
    $ci = trim($_POST['nit_ci'] ?? '');
    
    if (empty($razon)) {
        $error_mensaje = "La razón social es requerida";
    } elseif (empty($ci)) {
        $error_mensaje = "El NIT/CI es requerido";
    } else {
        try {
            $response_nuevo = $api->post('/cliente', [
                'razon_social' => $razon,
                'nit_ci' => $ci
            ]);
            
            if ($response_nuevo['success']) {
                $nuevo_cliente = $response_nuevo['data'];
                Session::set('cliente_venta', [
                    'id' => $nuevo_cliente['id'],
                    'nombre' => $nuevo_cliente['razon_social'],
                    'ci' => $nuevo_cliente['nit_ci']
                ]);
                $cliente_seleccionado = Session::get('cliente_venta');
                $exito_mensaje = "Cliente registrado y seleccionado correctamente";
                // Refrescar lista de clientes
                $response_clientes = $api->get('/cliente/active');
                if ($response_clientes['success']) {
                    $clientes = $response_clientes['data'] ?? [];
                }
            } else {
                $error_mensaje = $response_nuevo['error'] ?? 'Error al registrar cliente';
            }
        } catch (Exception $e) {
            $error_mensaje = "Error al registrar cliente: " . $e->getMessage();
        }
    }
}

/**
 * PROCESAR: Procesar venta
 * CRÍTICO - Validaciones completas
 */
if (isset($_POST['procesar_venta'])) {
    $carrito = Session::get('carrito_ventas1', []);
    $cliente_venta = Session::get('cliente_venta');
    
    // Validación 1: Carrito no vacío
    if (empty($carrito)) {
        $error_mensaje = "El carrito está vacío. Agregue productos antes de procesar.";
    } 
    // Validación 2: Cliente seleccionado
    elseif (empty($cliente_venta)) {
        $error_mensaje = "Debe seleccionar un cliente para procesar la venta.";
    } 
    // Validación 3: Usuario autenticado
    else {
        try {
            $usuario = Session::getUser();
            
            if (empty($usuario) || !isset($usuario['id_usuario'])) {
                $error_mensaje = "Sesión no válida. Por favor, inicie sesión nuevamente.";
            } else {
                // Validación 4: Detalles válidos
                $detalles_validos = true;
                $detalles = [];
                
                foreach ($carrito as $item) {
                    $id_producto = intval($item['id_producto'] ?? 0);
                    $cantidad = intval($item['cantidad'] ?? 0);
                    $precio = floatval($item['precio'] ?? 0);
                    
                    // Validar cada item
                    if ($id_producto <= 0 || $cantidad <= 0 || $precio < 0) {
                        $detalles_validos = false;
                        break;
                    }
                    
                    // Agregar detalle SIN subtotal (lo calcula el backend)
                    $detalles[] = [
                        'productoId' => $id_producto,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precio
                        // ❌ NO incluir 'subtotal'
                    ];
                }
                
                if (!$detalles_validos) {
                    $error_mensaje = "El carrito contiene datos inválidos. Revise los productos.";
                } else {
                    // Preparar datos de venta
                    $empleado_id = intval($usuario['id_usuario']);
                    $cliente_id = intval($cliente_venta['id']);
                    $metodo_pago = $_POST['metodo_pago'] ?? 'EFECTIVO';
                    $observaciones = trim($_POST['observaciones'] ?? '');
                    
                    // Validar método de pago
                    $metodos_validos = ['EFECTIVO', 'TARJETA', 'TRANSFERENCIA', 'CHEQUE'];
                    if (!in_array($metodo_pago, $metodos_validos)) {
                        $metodo_pago = 'EFECTIVO';
                    }
                    
                    // Enviar venta al backend
                    try {
                        $response_venta = $api->post('/venta', [
                            'clienteId' => $cliente_id,
                            'empleadoId' => $empleado_id,
                            'metodo_pago' => $metodo_pago,
                            'observaciones' => $observaciones,
                            'detalles' => $detalles
                        ]);
                        
                        if ($response_venta['success']) {
                            // Venta procesada exitosamente
                            $venta_data = $response_venta['data'];
                            
                            // Limpiar sesión
                            Session::delete('carrito_ventas1');
                            Session::delete('cliente_venta');
                            Session::set('venta_exitosa', [
                                'id' => $venta_data['id'],
                                'numero_venta' => $venta_data['numero_venta'],
                                'total' => $venta_data['total']
                            ]);
                            
                            // Redirigir
                            ?>
                            <script type="text/javascript">
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Venta Procesada',
                                    text: 'Número de venta: <?php echo htmlspecialchars($venta_data['numero_venta']); ?>',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {
                                    window.location.href = '../vista/ventaExitosa.php';
                                });
                            </script>
                            <?php
                            exit();
                        } else {
                            // Error del backend - extraer mensaje específico
                            $error = $response_venta['error'] ?? 'Error desconocido';
                            
                            // Diferenciar tipos de error
                            if (stripos($error, 'Stock insuficiente') !== false) {
                                $error_mensaje = $error; // Mostrar el error específico de stock
                            } elseif (stripos($error, 'no encontrado') !== false) {
                                $error_mensaje = "Uno de los productos no existe o fue eliminado.";
                            } elseif (stripos($error, 'inactivo') !== false) {
                                $error_mensaje = "Uno de los productos está inactivo.";
                            } else {
                                $error_mensaje = $error;
                            }
                        }
                    } catch (Exception $e) {
                        $error_mensaje = "Error al procesar venta: " . $e->getMessage();
                    }
                }
            }
        } catch (Exception $e) {
            $error_mensaje = "Error inesperado: " . $e->getMessage();
        }
    }
}

// Incluir vista
include("../vista/registroProcesarVenta.php");
?>