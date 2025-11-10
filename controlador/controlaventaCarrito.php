<?php
require_once(__DIR__ . '/../helpers/Session.php');

// ✅ DEBUG COMPLETO
error_log('═══════════════════════════════════════════');
error_log('📥 AGREGAR AL CARRITO');
error_log('POST recibido: ' . json_encode($_POST));
error_log('═══════════════════════════════════════════');

// Obtener datos del formulario
$id_producto = intval($_POST['id_producto'] ?? 0);
$nombre = $_POST['nombrep'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio = floatval($_POST['precio'] ?? 0);
$cantidad = intval($_POST['cantidad'] ?? 1);
$imagen = $_POST['imagen'] ?? '';  // ← AQUÍ ES DONDE ENTRA LA IMAGEN

// ✅ MÁS DEBUG
error_log('ID Producto: ' . $id_producto);
error_log('Nombre: ' . $nombre);
error_log('Imagen recibida: ' . $imagen);
error_log('Precio: ' . $precio);
error_log('Cantidad: ' . $cantidad);

// Validar datos mínimos
if (empty($id_producto) || empty($nombre) || $precio <= 0 || $cantidad <= 0) {
    error_log('❌ Error: Datos incompletos');
    Session::set('mensaje_carrito', "Error: Datos incompletos del producto");
    header("Location: ../controlador/controladorVenta.php");
    exit();
}

// Inicializar el carrito si no existe
if (!Session::has('carrito_ventas1')) {
    Session::set('carrito_ventas1', []);
}

$carrito = Session::get('carrito_ventas1');

// Verificar si el producto ya está en el carrito
$repetido = false;
foreach ($carrito as &$item) {
    if ($item['id_producto'] == $id_producto) {
        $item['cantidad'] += $cantidad;
        $item['subtotal'] = $item['precio'] * $item['cantidad'];
        $repetido = true;
        break;
    }
}
unset($item);

// Si no está repetido, agregar nuevo producto
if (!$repetido) {
    $producto_carrito = [
        'id_producto' => $id_producto,
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio' => $precio,
        'cantidad' => $cantidad,
        'subtotal' => $precio * $cantidad,
        'imagen' => $imagen  // ← AQUÍ SE GUARDA
    ];
    
    error_log('✅ Producto agregado: ' . json_encode($producto_carrito));
    
    $carrito[] = $producto_carrito;
}

Session::set('carrito_ventas1', $carrito);

// ✅ VERIFICA QUE SE GUARDÓ CORRECTAMENTE
error_log('📦 Carrito después de agregar:');
error_log(json_encode(Session::get('carrito_ventas1')));

Session::set('mensaje_carrito', "Producto agregado correctamente al carrito");

header("Location: ../controlador/controladorVenta.php");
exit();
?>