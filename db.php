<?php

class PgDB {
    var $con;
    function PgDb() {
        $this->con = pg_connect("host=localhost port=5432 dbname=pasantias user=postgres password=200193");
    }

    function query($qry) {
        return pg_query($qry);
    }
}

?>
