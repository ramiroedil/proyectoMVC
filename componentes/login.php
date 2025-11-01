<?php
session_start();
include("../modelo/conexion.php");

if (isset($_POST['user']) && isset($_POST['pasw'])) {
    $u = $_POST['user'];
    $p = $_POST['pasw'];
    $conexion = new Conexion();

    $consulta = "SELECT * FROM usuarios WHERE nombreusuario = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $u);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) != 0) {
        $uActual = mysqli_fetch_assoc($resultado);
        // echo "<pre>";
        // echo "Contraseña ingresada (POST): " . $p . "\n";
        // echo "Hash almacenado en BD: " . $uActual['pasword'] . "\n";
        // var_dump(password_verify($p, $uActual['pasword']));
        // echo "</pre>";
        // exit(); 

        if (password_verify($p, $uActual['pasword'])) {
            // Guardar todos los datos relevantes en la sesión
            $_SESSION['usuario'] = [
                'id_usuario' => $uActual['id_usuario'],
                'nombreusuario' => $uActual['nombreusuario'],
                'nombre' => $uActual['nombre'],
                'email' => $uActual['email'],
                'tipousuario' => $uActual['tipousuario'],
                'estado' => $uActual['estado']
            ];
            // Generar token único para sesión exclusiva
            $token = md5(uniqid(rand(), true));
            $update = "UPDATE usuarios SET token = ? WHERE id_usuario = ?";
            $stmt2 = mysqli_prepare($conexion, $update);
            mysqli_stmt_bind_param($stmt2, "si", $token, $uActual['id_usuario']);
            mysqli_stmt_execute($stmt2);
            $_SESSION['token'] = $token;
            header("Location: ../inicio.php");
            exit();
        } else {
            header("Location: ../index.php?sw=1");
            exit();
        }
    } else {
        header("Location: ../index.php?sw=2");
        exit();
    }
} else {
    header("Location: ../index.php?sw=1");
    exit();
}
?>