<?php
include('db.php');
$db = new PgDB();
if($_REQUEST) {
    $username = $_REQUEST['username'];
    $qry = "SELECT 1 FROM usuario WHERE usuario.username = '$username'";
    $results = $db->query($qry);
    if(pg_num_rows($results) > 0){
        echo 'Este usuario ya existe.';
    }
    else{
        echo 'Disponible';
    }
}
?>
