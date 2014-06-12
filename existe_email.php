<?php
include('db.php');
$db = new PgDB();
if($_REQUEST) {
    $email = $_REQUEST['email'];
    $qry = "SELECT 1 FROM usuario WHERE usuario.email = '$email'";
    $results = $db->query($qry);
    if(pg_num_rows($results) > 0){
        echo 'correo ya existente';
    }
    else{
        echo 'email disponible';
        echo 0;
    }
}
?>
