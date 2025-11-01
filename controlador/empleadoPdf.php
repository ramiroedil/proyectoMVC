<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../modelo/empleadosClase.php");
require('../assets/fpdf186/fpdf.php');


class PDF extends FPDF
{
// Cabecera de página
function Header()
{

  $this->Image('../assets/images/playa1.jpg',240,05,40);
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
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(20);
$pdf->SetXY(10,10);
   $pdf->SetFont('Arial','B',15);
   $pdf->Cell(250,20,'Lista Empleados',0,0,'C');
   // Salto de línea
   $pdf->Ln(20);
$pdf->SetX(25);
$pdf->SetFont('Helvetica','B',9);
//180 toda la tabla
//celda (ancho, largo, contenido, borde, salto de linea, alineacion, pintar)
$pdf->Cell(10,10,'Nro','B',0,'C',0);
$pdf->Cell(25,10,'Cargo','B',0,'C',0);
$pdf->Cell(30,10,'CI','B',0,'C',0);
$pdf->Cell(50,10,'Nombre Completo','B',0,'C',0);
$pdf->Cell(22,10,'Direccion','B',0,'C',0);
$pdf->Cell(20,10,'Telefono','B',0,'C',0);
$pdf->Cell(20,10,'Nacimiento','B',0,'C',0);
$pdf->Cell(20,10,'Genero','B',0,'C',0);
$pdf->Cell(50,10,'Intereses','B',1,'C',0);
$pdf->Ln(0.5);

//formato r g b
$pdf->SetFillColor(233,229,235);
$pdf->SetDrawColor(160,151,149);
$i=1;
$empleado = new Empleado("","","","","","","","","","","");
$datos = $empleado->lista();
$pdf->SetFont('Helvetica','',9);
while ($dato = $datos->fetch_assoc()) {
//for($i=1;$i<=40;$i++){
  $pdf->Ln(0.2);
  $pdf->SetX(25);
  $pdf->Cell(10,10,$i,'B',0,'C',1);
  $pdf->Cell(25,10,$dato['cargo'],'B',0,'L',1);
  $pdf->Cell(30,10,$dato['ci'],'B',0,'C',1);
  $pdf->Cell(50, 10, $dato['nombre'] . ' ' . $dato['paterno'] . ' ' . $dato['materno'], 'B', 0, 'L', 1);

  $pdf->Cell(22,10,$dato['direccion'],'B',0,'L',1);
  $pdf->Cell(20,10,$dato['telefono'],'B',0,'C',1);
  $pdf->Cell(20,10,$dato['fechanacimiento'],'B',0,'C',1);
  $pdf->Cell(20,10,$dato['genero'],'B',0,'C',1);
  $pdf->Cell(50,10,$dato['intereses'],'B',1,'C',1);
  $i++;
}

//$pdf->AddPage();

$pdf->Output();
?>