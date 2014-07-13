<?php

require_once('db.php');

function contar($qry) {

	$db = new PgDB();

    $result = $db->query($qry);
    return pg_fetch_row($result, 0)[0];
}

?>
