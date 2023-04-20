<?php
    $con=pg_connect("host=database-1.cxjhu3idchez.eu-north-1.rds.amazonaws.com port=5432 dbname=Grays user=postgres password=teamgrays");
    if(!$con)
    {
        echo "connection fail";
    }
?>