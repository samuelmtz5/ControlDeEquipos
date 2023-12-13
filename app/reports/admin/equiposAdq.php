<?php
if (isset($_GET['id'])) {
    require('../../helpers/report.php');
    require('../../models/adquisicion.php');
    $adquisicion = new Adquisicion;

    if ($adquisicion->setId($_GET['id'])) {
        if ($rowAdq = $adquisicion->readOne()) {
            $pdf = new Report;
            $pdf->startReport($rowAdq['adquisicion']);
            if ($dataAdq = $adquisicion->readEquiposAdq()) {
                $pdf->SetFillColor(225);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(62, 10, ('Marca'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, ('Modelo'), 1, 0, 'C', 1);
                $pdf->Cell(62, 10, ('Activo'), 1, 1, 'C', 1);
                $pdf->SetFont('Arial', '', 11);
        
                foreach ($dataAdq as $rowAdq) {
                    $pdf->Cell(62, 10, $rowAdq['nombremarca'], 1, 0, 'C');
                    $pdf->Cell(62, 10, $rowAdq['modelo'], 1, 0, 'C');
                    $pdf->Cell(62, 10, $rowAdq['activo'], 1, 1, 'C');
                }
            } else {
                $pdf->Cell(0, 10, ('No hay equipos para esta adquisicion'), 1, 1);
            }
            $pdf->Output();
        } else {
            header('location: ../../../views/admin/adquisicion.php');
        }
    } else {
        header('location: ../../../views/admin/adquisicion.php');
    }
} else {
    header('location: ../../../views/admin/adquisicion.php');
}
?>