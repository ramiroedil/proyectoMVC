<?php
require_once(__DIR__ . '/../helpers/Session.php');

// Validar que se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../controlador/controladorVenta.php");
    exit();
}

// Obtener datos del formulario
$id_producto = intval($_POST['id_producto'] ?? 0);
$nombre = $_POST['nombrep'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio = floatval($_POST['precio'] ?? 0);
$cantidad = intval($_POST['cantidad'] ?? 1);
$imagen = $_POST['imagen'] ?? '';

// Validar datos mínimos
if (empty($id_producto) || empty($nombre) || $precio <= 0 || $cantidad <= 0) {
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
    $carrito[] = [
        'id_producto' => $id_producto,
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio' => $precio,
        'cantidad' => $cantidad,
        'subtotal' => $precio * $cantidad,
        'imagen' => $imagen
    ];
}

Session::set('carrito_ventas1', $carrito);
Session::set('mensaje_carrito', "Producto agregado correctamente al carrito");

// Redirigir de vuelta a la página de productos
header("Location: ../controlador/controladorVenta.php");
exit();
?>