<?php
include("../modelo/usuario.php");

if (isset($_POST['id_usuario']) && isset($_POST['estado'])) {
    $id = $_POST['id_usuario'];
    $nuevoEstado = $_POST['estado'];
    $usuario = new Usuario("","","","","","","","","","",
    $id,
    $nuevoEstado);
    $resultado = $usuario->actualizarEstado($id, $nuevoEstado);

    if ($resultado) {
        echo json_encode(["success" => true, "estado" => $nuevoEstado]);
    } else {
        echo json_encode(["success" => false, "error" => "No se pudo actualizar."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Datos incompletos."]);
}
?>
