<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../modelo/productoClase.php");
require('../assets/fpdf186/fpdf.php');


class PDF extends FPDF
{
// Cabecera de página
function Header()
{
   // Logo
   $this->Image('../assets/images/playa1.jpg',160,10,40);
   $this->Image('../assets/images/waves.png',0,0,100);
}

// Pie de página
function Footer()
{
   // Posición: a 1,5 cm del final
   $this->SetY(-15);
   // Arial italic 8
   $this->SetFont('Arial','B',8);
   // Número de página
   //utf-8 depreciado
   $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Página '.$this->PageNo().'/{nb}'), 0, 0, 'C');


}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(20);
$pdf->SetXY(15,50);
   $pdf->SetFont('Arial','B',15);
   $pdf->Cell(180,20,'Lista de Productos',0,0,'C');
   // Salto de línea
   $pdf->Ln(20);
$pdf->SetX(15);
$pdf->SetFont('Helvetica','B',9);
//180 toda la tabla
//celda (ancho, largo, contenido, borde, salto de linea, alineacion, pintar)
$pdf->Cell(15,10,'Nro','B',0,'C',0);
$pdf->Cell(20,10,'Porveedor','B',0,'L',0);
$pdf->Cell(25,10,'Producto','B',0,'L',0);
$pdf->Cell(40,10,'Descripcion','B',0,'L',0);
$pdf->Cell(20,10,'Precio ','B',0,'L',0);
$pdf->Cell(20,10,'Stock','B',0,'L',0);
$pdf->Cell(20,10,'Tipo','B',0,'L',0);
$pdf->Cell(25,10,'Imagen','B',1,'L',0);
$pdf->Ln(0.5);

//formato r g b
$pdf->SetFillColor(233,229,235);
$pdf->SetDrawColor(160,151,149);
$i=1;
$proveedor = new Producto("","","","","","","","","");
$datos = $proveedor->lista();
$pro=$proveedor->obtenerProducto();
$pdf->SetFont('Helvetica','',9);
while ($dato = $datos->fetch_assoc()) {
  $pdf->Ln(0.2);
  $pdf->SetX(15);
  $pdf->Cell(15,10,$i,'B',0,'C',1);
  $pdf->Cell(20,10,$dato['empresa'],'B',0,'L',1);
  $pdf->Cell(25,10,$dato['nombreproducto'],'B',0,'L',1);
  $pdf->Cell(40,10,$dato['descripcion'],'B',0,'L',1);
  $pdf->Cell(20,10,$dato['precio'],'B',0,'L',1);
  $pdf->Cell(20,10,$dato['stock'],'B',0,'L',1);
  $pdf->Cell(20,10,$dato['tipo'],'B',0,'L',1);
  $imagePath = 'imagenes/'.$dato['imagen'];
    if (file_exists($imagePath)) {
        $info = getimagesize($imagePath);
        if ($info && $info['mime'] === 'image/jpeg') {
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->Cell(25,10,"",1,1); 
            $pdf->Image($imagePath, $x+1, $y+1, 8, 8);
        } else {
            $pdf->Cell(20,10,"No JPEG",1,1);
        }
    } else {
        $pdf->Cell(20,10,"No Image",1,1);
    }

  $i++;
}

$pdf->Output();
?>