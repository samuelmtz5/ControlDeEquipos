<?php
if (isset($_GET['id'])) {
    require('../../helpers/report.php');
    require('../../models/condicion.php');
    $condicion = new Condicion;

    if ($condicion->setId($_GET['id'])) {
        if ($rowCon = $condicion->readOne()) {
            $pdf = new Report;
            $pdf->startReport($rowCon['condicion']);
            if ($dataCon = $condicion->readEquiposCondicion()) {
                $pdf->SetFillColor(225);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(62, 10, ('Marca'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, ('Modelo'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, ('Activo'), 1, 1, 'C', 1);
                $pdf->SetFont('Arial', '', 11);
        
                foreach ($dataCon as $rowCon) {
                    $pdf->Cell(62, 10, $rowCon['nombremarca'], 1, 0, 'C');
                    $pdf->Cell(62, 10, $rowCon['modelo'], 1, 0, 'C');
                    $pdf->Cell(62, 10, $rowCon['activo'], 1, 1, 'C');
                }
            } else {
                $pdf->Cell(0, 10, ('No hay equipos para esta condicion'), 1, 1);
            }
            $pdf->Output();
        } else {
            header('location: ../../../views/admin/condicion.php');
        }
    } else {
        header('location: ../../../views/admin/condicion.php');
    }
} else {
    header('location: ../../../views/admin/condicion.php');
}
?>