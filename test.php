<?php

require_once('db.php');

$db = new PgDB();

function contar($qry) {
    $result = $db->query($qry);
    return pg_fetch_row($result, 0)[0];
}

$solo_registrados = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m01_registrada IS NOT NULL AND pasantia.m02_aceptada IS NULL");
$solo_aceptadas = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m02_aceptada IS NOT NULL AND pasantia.m03_numero_asignado IS NULL");
$solo_numero_asignado = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m03_numero_asignado IS NOT NULL AND pasantia.m04_sellada IS NULL");
$solo_sellada = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m04_sellada IS NOT NULL AND pasantia.m05_entrego_copia IS NULL");
$solo_entrego_copia = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m05_entrego_copia IS NOT NULL AND pasantia.m06_entrego_borrador IS NULL");
$solo_entrego_borrador = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m06_entrego_borrador IS NOT NULL AND pasantia.m07_retiro_borrador IS NULL");
$solo_retiro_borrador = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m07_retiro_borrador IS NOT NULL AND pasantia.m08_entrega_final IS NULL");
$finalizaron = contar("SELECT COUNT(*) FROM pasantia WHERE pasantia.m08_entrega_final IS NOT NULL");

?>
