<?php
session_start();

require('../../lib/fpdf.php');
require_once('../../config/db.php'); 
require_once('../../config/Expedientes.php');   

if (!isset($_SESSION['id'])) {     
    header("Location: /public/login.php");     
    exit; 
}  

$db = new Database();
$conexion = $db->connect();
$expedientes = new Expedientes($conexion);

$id = $_GET['id'];
$datoExpediente = $expedientes->buscar(['id' => $id]);

// $pdf->SetFont(familia, estilo, tamaño)
// $pdf->Cell(ancho, alto, texto, borde, salto, alineacion, relleno, link)

foreach ($datoExpediente as $exp){ 
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->image('../../assets/images/logo.png', 150, 13, 45);

    $pdf->SetFont('helvetica','B',20);
    $pdf->Cell(80, 20, 'Datos del expediente', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(20, 8, 'Numero:');
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 8, utf8_decode($exp['numero']), 0, 1);

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(12, 8, utf8_decode('Año:'));
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 8, utf8_decode($exp['anio']), 0, 1);

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(17, 8, 'Sector:');
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 8, utf8_decode($exp['sector_nombre']), 0, 1);

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(12, 8, 'Tipo:');
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 8, utf8_decode($exp['tipo_nombre']), 0, 1);

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(17, 8, 'Estado:');
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 8, utf8_decode($exp['estado_nombre']), 0, 1);

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(18, 8, 'Asunto:');
    $pdf->SetFont('helvetica', '', 13);
    $pdf->MultiCell(0, 8, utf8_decode($exp['asunto'])); 

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(25, 8, 'Creado en:');
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 8, utf8_decode($exp['creado_en']), 0, 1);

    $pdf->SetFont('helvetica','B',12);
    $pdf->Cell(35, 8, 'Actualizado en:');
    $pdf->SetFont('helvetica', '', 13);
    $pdf->Cell(0, 8, utf8_decode($exp['actualizado_en']), 0, 1);

    $pdf->Output();
} ?>
