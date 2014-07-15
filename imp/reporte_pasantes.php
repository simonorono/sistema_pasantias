<?php
require('../mc_table.php');
include('../db.php');

function transform($r) {
    if ($r["m01_registrada"] != null) {
        $r["m01_registrada"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m01_registrada"]), 'd/m/Y');
    }
    else {
        $r["m01_registrada"] = "---";
    }

    if ($r["m02_aceptada"] != null) {
        $r["m02_aceptada"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m02_aceptada"]), 'd/m/Y');
    }
    else {
        $r["m02_aceptada"] = "---";
    }

    if ($r["m03_numero_asignado"] != null) {
        $r["m03_numero_asignado"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m03_numero_asignado"]), 'd/m/Y');
    }
    else {
        $r["m03_numero_asignado"] = "---";
    }

    if ($r["m04_sellada"] != null) {
        $r["m04_sellada"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m04_sellada"]), 'd/m/Y');
    }
    else {
        $r["m04_sellada"] = "---";
    }

    if ($r["m05_entrego_copia"] != null) {
        $r["m05_entrego_copia"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m05_entrego_copia"]), 'd/m/Y');
    }
    else {
        $r["m05_entrego_copia"] = "---";
    }

    if ($r["m06_entrego_borrador"] != null) {
        $r["m06_entrego_borrador"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m06_entrego_borrador"]), 'd/m/Y');
    }
    else {
        $r["m06_entrego_borrador"] = "---";
    }

    if ($r["m07_retiro_borrador"] != null) {
        $r["m07_retiro_borrador"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m07_retiro_borrador"]), 'd/m/Y');
    }
    else {
        $r["m07_retiro_borrador"] = "---";
    }

    if ($r["m08_entrega_final"] != null) {
        $r["m08_entrega_final"] = date_format (DateTime::createFromFormat('Y-m-d', $r["m08_entrega_final"]), 'd/m/Y');
    }
    else {
        $r["m08_entrega_final"] = "---";
    }
    //var_dump($r);die();
    if ($r["m09_carga_nota"] != null) {
        if ($r["aprobada"] == "t") {
            $r["m09_carga_nota"] = "Aprobada";
        } else {
            $r["m09_carga_nota"] = "Reprobada";
        }
    }
    else {
        $r["m09_carga_nota"] = "---";
    }

    return $r;
}

$pdf=new PDF_MC_Table('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetMargins(10,10);

$db = new PgDB();

//QUERY PARA LOS ESTUDIANTES DEL PERIODO ACTIVO
$query = "SELECT periodo.tipo, periodo.anio, nombre, apellido, cedula, aprobada, m01_registrada ::timestamp::date, m02_aceptada ::timestamp::date, m03_numero_asignado ::timestamp::date,
m04_sellada::timestamp::date, m05_entrego_copia ::timestamp::date, m06_entrego_borrador ::timestamp::date, m07_retiro_borrador ::timestamp::date,
m08_entrega_final ::timestamp::date, m09_carga_nota ::timestamp::date, aprobada
FROM usuario INNER JOIN pasantia ON usuario.id = pasantia.usuario_id AND usuario.tipo = 'estudiante' INNER JOIN periodo ON periodo.id = pasantia.periodo_id AND periodo.activo = TRUE ORDER BY cedula ";


//QUERY PARA EL PERIDO ACTIVO
$queryPer = "SELECT tipo, anio FROM periodo WHERE activo = TRUE";
$recoPer = pg_query($queryPer);
$rowPer = pg_fetch_array($recoPer);


$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(0,5,utf8_decode("\nRepública Bolivariana de Venezuela\nUniversidad del Zulia\nFacultad Experimental de Ciencias\nDivisión de Programas Especiales\nSistema de Pasantías\n"), 0, "C", 0);
$pdf->MultiCell(258,5,utf8_decode("\nReporte de Pasantes Registrados"), 0, "C", 0);
$pdf->MultiCell(258,5,utf8_decode("\n$rowPer[tipo] - $rowPer[anio]"), 0, "C", 0);
$pdf->Ln();

$pdf->Image("logotipo.jpg",20,12,-280);

$pdf->SetFont('Arial', 'B', '10');
$pdf->SetWidths(array(25,20,22,22,25,25,25,25,25,25,25));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C','C'));
$pdf->Row(array("\nNombre", "\nC.I", "\nRegistrada", "\nAceptada", "Fecha Numero asignado", "\nSellada", "\nEntrega de copia",
                "\nEntrega de borrador", "\nRetiro borrador", "\nEntrega Final", "\nCarga de Nota"));

$reco = pg_query($query);

while($row = pg_fetch_array($reco))
{
    $pdf->SetFont('Arial','',10);
    $pdf->SetWidths(array(25,20,22,22,25,25,25,25,25,25,25));
    $pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C'));
    $row = transform($row);

    $pdf->Row(array("$row[nombre]\n$row[apellido]", "\n$row[cedula]", "\n$row[m01_registrada]", "\n$row[m02_aceptada]",
                    "\n$row[m03_numero_asignado]", "\n$row[m04_sellada]","\n$row[m05_entrego_copia]", "\n$row[m06_entrego_borrador]",
                    "\n$row[m07_retiro_borrador]", "\n$row[m08_entrega_final]", "\n$row[m09_carga_nota]"));
}

$pdf->Output("reporte_pasantes.pdf" ,"D");
?>
