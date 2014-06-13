
<?php
include('db.php');
$db = new PgDB();
if($_POST) {
    $email = $_POST['email'];
    $qry = "SELECT 1 FROM usuario WHERE usuario.email = '$email'";
    $results = $db->query($qry);
    if(pg_num_rows($results) > 0){
        echo 'No disponible';
    }
    else{
        echo 'Disponible';
    }
}
?>
