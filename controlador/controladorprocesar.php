<?php
require_once(__DIR__ . '/../modelo/ApiClient.php');
require_once(__DIR__ . '/../helpers/Session.php');

$api = new ApiClient();

// Obtener clientes activos
$response_clientes = $api->get('/cliente/active');
$clientes = $response_clientes['success'] ? $response_clientes['data'] : [];

// Buscar cliente si se envió el formulario
$cliente_seleccionado = null;
$busqueda_resultado = [];

if ($_POST) {
    if (isset($_POST['buscar_cliente'])) {
        $busqueda = trim($_POST['busqueda_cliente']);
        if (!empty($busqueda)) {
            $response_busqueda = $api->get('/cliente/search', ['query' => $busqueda]);
            if ($response_busqueda['success']) {
                $busqueda_resultado = $response_busqueda['data'];
            }
        }
    }
    
    if (isset($_POST['seleccionar_cliente'])) {
        $cliente_id = intval($_POST['cliente_id']);
        $cliente_nombre = $_POST['cliente_nombre'];
        $cliente_ci = $_POST['cliente_ci'];
        
        Session::set('cliente_venta', [
            'id' => $cliente_id,
            'nombre' => $cliente_nombre,
            'ci' => $cliente_ci
        ]);
        $cliente_seleccionado = Session::get('cliente_venta');
    }
    
    if (isset($_POST['procesar_venta'])) {
        $carrito = Session::get('carrito_ventas1', []);
        $cliente_venta = Session::get('cliente_venta');
        
        if (empty($carrito)) {
            ?>
            <script type="text/javascript">
                alert("El carrito está vacío");
                location.href = '../controlador/controladorVenta.php';
            </script>
            <?php
            exit();
        }
        
        if (empty($cliente_venta)) {
            ?>
            <script type="text/javascript">
                alert("Debe seleccionar un cliente");
                window.history.back();
            </script>
            <?php
            exit();
        }
        
        $usuario = Session::getUser();
        $empleado_id = $usuario['id_usuario'];
        $cliente_id = $cliente_venta['id'];
        
        // Preparar detalles de venta
        $detalles = [];
        foreach ($carrito as $item) {
            $detalles[] = [
                'productoId' => $item['id_producto'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'subtotal' => $item['subtotal']
            ];
        }
        
        // Enviar venta al backend
        $response_venta = $api->post('/venta', [
            'clienteId' => $cliente_id,
            'empleadoId' => $empleado_id,
            'metodo_pago' => 'EFECTIVO',
            'detalles' => $detalles
        ]);
        
        if ($response_venta['success']) {
            Session::delete('carrito_ventas1');
            Session::delete('cliente_venta');
            Session::set('venta_exitosa', $response_venta['data']['id']);
            header("Location: ../vista/ventaExitosa.php");
            exit();
        } else {
            ?>
            <script type="text/javascript">
                alert("Error al procesar venta: <?php echo addslashes($response_venta['error']); ?>");
                window.history.back();
            </script>
            <?php
            exit();
        }
    }
    
    // Registrar cliente desde modal
    if (isset($_POST['registrarClienteModal'])) {
        $razon = trim($_POST['razonsocial']);
        $ci = trim($_POST['nit_ci']);
        
        if (!empty($razon) && !empty($ci)) {
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
                ?>
                <script type="text/javascript">
                    window.location.reload();
                </script>
                <?php
                exit();
            }
        }
    }
}

// Si ya hay un cliente seleccionado en sesión
if (Session::has('cliente_venta')) {
    $cliente_seleccionado = Session::get('cliente_venta');
}

include("../vista/registroProcesarVenta.php");
?>