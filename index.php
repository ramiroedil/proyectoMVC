<?php
session_start();
require_once(__DIR__ . '/config/config.php');
require_once(__DIR__ . '/modelo/ApiClientPublic.php');


if (!isset($_SESSION['carrito_publico'])) {
    $_SESSION['carrito_publico'] = [];
}

$api = new ApiClientPublic();
$productos = [];
$categorias = [];
$activa = 'todas';
$error_message = '';

$response = $api->get('/producto/active');
if ($response['success']) {
    $productosAPI = $response['data'];
    
    $categorias_map = [];
    foreach ($productosAPI as $prod) {
        $catId = $prod['id_categoria'] ?? 'sin-categoria';
        $catNombre = $prod['categoria']['nombre'] ?? 'Sin categoría';
        
        if (!isset($categorias_map[$catId])) {
            $categorias_map[$catId] = $catNombre;
        }
        
        if (!isset($productos[$catId])) {
            $productos[$catId] = [];
        }
        $productos[$catId][] = $prod;
    }
    
    $categorias = $categorias_map;
} else {
    $error_message = $response['error'] ?? 'Error al cargar productos';
}

if (isset($_GET['cat'])) {
    $catParam = $_GET['cat'];
    if ($catParam === 'todas' || isset($productos[$catParam])) {
        $activa = $catParam;
    }
}

$productosActivos = [];
if ($activa === 'todas') {
    foreach ($productos as $items) {
        $productosActivos = array_merge($productosActivos, $items);
    }
} else {
    $productosActivos = $productos[$activa] ?? [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'agregar_carrito') {
        $producto_id = intval($_POST['producto_id']);
        $cantidad = intval($_POST['cantidad'] ?? 1);
        
        $producto_encontrado = null;
        foreach ($productosAPI as $prod) {
            if ($prod['id'] === $producto_id) {
                $producto_encontrado = $prod;
                break;
            }
        }
        
        if ($producto_encontrado && $cantidad > 0 && $cantidad <= $producto_encontrado['stock']) {
            $existe = false;
            foreach ($_SESSION['carrito_publico'] as &$item) {
                if ($item['id'] === $producto_id) {
                    $item['cantidad'] += $cantidad;
                    $existe = true;
                    break;
                }
            }
            
            if (!$existe) {
                $_SESSION['carrito_publico'][] = [
                    'id' => $producto_encontrado['id'],
                    'nombre' => $producto_encontrado['nombre'],
                    'precio' => $producto_encontrado['precio_venta'],
                    'cantidad' => $cantidad,
                    'imagen' => $producto_encontrado['imagen'],
                    'descripcion' => $producto_encontrado['descripcion']
                ];
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'carrito_count' => count($_SESSION['carrito_publico'])
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error: cantidad inválida o producto no disponible'
            ]);
        }
        exit();
    }
    // ACCIÓN: OBTENER CARRITO
    if ($_POST['action'] === 'obtener_carrito') {
        echo json_encode([
            'success' => true,
            'carrito' => $_SESSION['carrito_publico'],
            'count' => count($_SESSION['carrito_publico'])
        ]);
        exit();
    }
    
    // ACCIÓN: ELIMINAR DEL CARRITO
    if ($_POST['action'] === 'eliminar_carrito') {
        $producto_id = intval($_POST['producto_id']);
        $_SESSION['carrito_publico'] = array_filter($_SESSION['carrito_publico'], 
            function($item) use ($producto_id) {
                return $item['id'] !== $producto_id;
            }
        );
        $_SESSION['carrito_publico'] = array_values($_SESSION['carrito_publico']);
        
        echo json_encode([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'carrito_count' => count($_SESSION['carrito_publico'])
        ]);
        exit();
    }
}


include(__DIR__ . '/vista/portal-publico.php');
?>
<script src="assets/js/recuperar-carrito.js"></script>