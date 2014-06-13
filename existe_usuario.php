
<?php

include('db.php');
$db = new PgDB();
if($_POST) {
    $username = $_POST['username'];
    $qry = "SELECT 1 FROM usuario WHERE usuario.username ='$username'";
    $results = $db->query($qry);
    if(pg_num_rows($results) > 0){
        echo 'No disponible';
    }
    else{
        echo 'Disponible';
    }
}

?>
