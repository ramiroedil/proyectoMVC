<?php
include_once("conexion.php");
class Venta
{
    private $id_venta;
    private $id_empleado;
    private $id_cliente;
    private $fecha;

    public function __construct($id_venta, $id_empleado, $id_cliente, $fecha)
    {
        $this->setIdVenta($id_venta);
        $this->setIdEmpleado($id_empleado);
        $this->setIdCliente($id_cliente);
        $this->setFecha($fecha);
    }

    public function procesarVenta($productos)
    {
        $db = new Conexion();
        try {
            // 1. Insertar la venta principal
            $sql_venta = $db->query("INSERT INTO venta (id_empleado, id_cliente, fecha) 
                                   VALUES ('$this->id_empleado', '$this->id_cliente', '$this->fecha')");
            // 2. Obtener el ID de la venta recién insertada
            $result = $db->query("SELECT LAST_INSERT_ID() as id_venta");
            $row = $result->fetch_assoc();
            $id_venta_nueva = $row['id_venta'];
            // 3. Insertar los detalles de la venta y actualizar stock
            foreach ($productos as $producto) {
                $id_producto = $producto['id_producto'];
                $cantidad = $producto['cantidad'];
                $costo = $producto['subtotal'];
                // Verificar stock disponible
                $stock_result = $db->query("SELECT stock FROM producto WHERE id = '$id_producto'");
                $stock_row = $stock_result->fetch_assoc();
                $stock_actual = $stock_row['stock'];
                if ($stock_actual < $cantidad) {
                    throw new Exception("Stock insuficiente para el producto ID: $id_producto");
                }
                // Insertar detalle de venta
                $sql_detalle = $db->query("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, costo) 
                                         VALUES ('$id_venta_nueva', '$id_producto', '$cantidad', '$costo')");

                if (!$sql_detalle) {
                    throw new Exception("Error al insertar detalle de venta para producto ID: $id_producto");
                }

                // Actualizar stock del producto
                $nuevo_stock = $stock_actual - $cantidad;
                $sql_stock = $db->query("UPDATE producto SET stock = '$nuevo_stock' WHERE id = '$id_producto'");

                if (!$sql_stock) {
                    throw new Exception("Error al actualizar stock del producto ID: $id_producto");
                }
            }

            // Confirmar transacción
            $db->query("COMMIT");
            return $id_venta_nueva;

        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $db->query("ROLLBACK");
            throw $e;
        }
    }

    public function obtenerVenta()
    {
        $db = new Conexion();
        $sql = $db->query("SELECT v.*, c.razonsocial, c.nit_ci, e.nombre, e.paterno, e.materno 
                          FROM venta v 
                          INNER JOIN cliente c ON v.id_cliente = c.id_cliente 
                          INNER JOIN empleado e ON v.id_empleado = e.id_empleado 
                          WHERE v.id_venta = '$this->id_venta'");
        return $sql;
    }

    public function obtenerDetalleVenta()
    {
        $db = new Conexion();
        $sql = $db->query("SELECT dv.*, p.nombreproducto, p.descripcion, p.precio 
                          FROM detalle_venta dv 
                          INNER JOIN producto p ON dv.id_producto = p.id 
                          WHERE dv.id_venta = '$this->id_venta'");
        return $sql;
    }

    public function listarVentas()
    {
        $db = new Conexion();
        $sql = $db->query("SELECT v.*, c.razonsocial, c.nit_ci, e.nombre, e.paterno, e.materno 
                          FROM venta v 
                          INNER JOIN cliente c ON v.id_cliente = c.id_cliente 
                          INNER JOIN empleado e ON v.id_empleado = e.id_empleado 
                          ORDER BY v.fecha DESC, v.id_venta DESC");
        return $sql;
    }

    public function buscarVentasPorFecha($fecha_inicio, $fecha_fin)
    {
        $db = new Conexion();
        $sql = $db->query("SELECT v.*, c.razonsocial, c.nit_ci, e.nombre, e.paterno, e.materno 
                          FROM venta v 
                          INNER JOIN cliente c ON v.id_cliente = c.id_cliente 
                          INNER JOIN empleado e ON v.id_empleado = e.id_empleado 
                          WHERE v.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' 
                          ORDER BY v.fecha DESC, v.id_venta DESC");
        return $sql;
    }

    public function buscarVentasPorCliente($id_cliente)
    {
        $db = new Conexion();
        $sql = $db->query("SELECT v.*, c.razonsocial, c.nit_ci, e.nombre, e.paterno, e.materno 
                          FROM venta v 
                          INNER JOIN cliente c ON v.id_cliente = c.id_cliente 
                          INNER JOIN empleado e ON v.id_empleado = e.id_empleado 
                          WHERE v.id_cliente = '$id_cliente' 
                          ORDER BY v.fecha DESC, v.id_venta DESC");
        return $sql;
    }

    public function calcularTotalVenta()
    {
        $db = new Conexion();
        $sql = $db->query("SELECT SUM(costo) as total FROM detalle_venta WHERE id_venta = '$this->id_venta'");
        $row = $sql->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function eliminarVenta()
    {
        $db = new Conexion();

        // Iniciar transacción
        $db->query("START TRANSACTION");

        try {
            // 1. Obtener los productos de la venta para restaurar el stock
            $detalles = $this->obtenerDetalleVenta();

            while ($detalle = $detalles->fetch_assoc()) {
                $id_producto = $detalle['id_producto'];
                $cantidad = $detalle['cantidad'];

                // Restaurar stock
                $db->query("UPDATE producto SET stock = stock + $cantidad WHERE id = '$id_producto'");
            }

            // 2. Eliminar detalles de venta
            $db->query("DELETE FROM detalle_venta WHERE id_venta = '$this->id_venta'");

            // 3. Eliminar venta principal
            $db->query("DELETE FROM venta WHERE id_venta = '$this->id_venta'");

            // Confirmar transacción
            $db->query("COMMIT");
            return true;

        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $db->query("ROLLBACK");
            return false;
        }
    }

    // Getters y Setters
    public function setIdVenta($id_venta)
    {
        $this->id_venta = $id_venta;
    }
    public function getIdVenta()
    {
        return $this->id_venta;
    }

    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }
    public function getIdEmpleado()
    {
        return $this->id_empleado;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
}
?>