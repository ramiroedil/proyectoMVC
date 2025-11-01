<?php
require_once '../dompdf/autoload.inc.php';
require_once '../modelo/conexion.php'; 

use Dompdf\Dompdf;
$conexion = new Conexion();
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
$dompdf = new Dompdf();
$imagenData = base64_encode(file_get_contents('../assets/images/profile/yo.jpg'));
$imagenBase64 = 'data:image/jpeg;base64,' . $imagenData;

$pdf = '<div style="text-align: center;">
            <img src="' . $imagenBase64 . '" width="100"><br>
            <h1>LISTA DE CARGOS</h1>
        </div>';
$pdf .= '<table border="1" cellspacing="0" cellpadding="5" style="width:100%; border-collapse: collapse; text-align: center;">
<thead>
  <tr>
    <th><h6>ID</h6></th>
    <th><h6>Cargo</h6></th>
  </tr>
  
</thead>
<tbody>';

$consulta = "SELECT * FROM cargo;";
$datos = $conexion->query($consulta);
$i = 1; 

while ($dato = $datos->fetch_assoc()) {
    $pdf .= '<tr>
        <td>' . $i++ . '</td>
        <td>' . htmlspecialchars($dato['cargo']) . '</td>
    </tr>';
}

$pdf .= '</tbody></table>';
$dompdf->loadHtml($pdf);
$dompdf->setPaper('A4', 'portrait'); 

$dompdf->render();
$dompdf->stream("lista_cargos.pdf", array("Attachment" => 0));

$conexion->close();
?>
