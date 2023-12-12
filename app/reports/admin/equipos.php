<?php
require('../../helpers/report.php');
require('../../models/tipos.php');

$pdf = new Report;
$pdf->startReport('Equipos por Tipo');
$tipo = new Tipos;

if ($dataTipo = $tipo->readAll()) {
    foreach ($dataTipo as $rowTipo) {
        $pdf->SetFillColor(175);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(0, 10, ('Tipo: '.$rowTipo['tipoequipo']), 1, 1, 'C', 1);

        if ($tipo->setId($rowTipo['idtipoequipo'])) {
            if ($dataEquipos = $tipo->readEquiposTipo()) {
                $pdf->SetFillColor(225);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(62, 10, ('Marca'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, ('Modelo'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, ('Activo'), 1, 1, 'C', 1);
                $pdf->SetFont('Arial', '', 11);
        
                foreach ($dataEquipos as $rowTipo) {
                    $pdf->Cell(62, 10, $rowTipo['nombremarca'], 1, 0, 'C');
                    $pdf->Cell(62, 10, $rowTipo['modelo'], 1, 0, 'C');
                    $pdf->Cell(62, 10, $rowTipo['activo'], 1, 1, 'C');
                }
            } else {
                $pdf->Cell(0, 10, ('No hay equipos para este tipo'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, ('Tipo incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, ('No hay tipos para mostrar'), 1, 1);
}

$pdf->Output();
?>