<?php

    session_start();

    $DB_Host = 'database-1.cxjhu3idchez.eu-north-1.rds.amazonaws.com';
    $DB_Name = 'Grays';
    $DB_User = 'postgres';
    $DB_Password = 'teamgrays';

    $con = pg_connect("host=$DB_Host dbname=$DB_Name user=$DB_User password=$DB_Password");
?>