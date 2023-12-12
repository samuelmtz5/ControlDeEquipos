<?php
if (isset($_GET['id'])) {
    require('../../helpers/report.php');
    require('../../models/tipos.php');
    $tipos = new Tipos;

    if ($tipos->setId($_GET['id'])) {
        if ($rowTipos = $tipos->readOne()) {
            $pdf = new Report;
            $pdf->startReport('Equipos del tipo '.$rowTipos['tipoequipo']);
            if ($dataEquipos = $tipos->readEquiposTipo()) {
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
            $pdf->Output();
        } else {
            header('location: ../../../views/admin/tipos.php');
        }
    } else {
        header('location: ../../../views/admin/tipos.php');
    }
} else {
    header('location: ../../../views/admin/tipos.php');
}
?>