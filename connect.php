<?php
/**
 * Use this file to connect to the database 
 */
try {
    $dbh = new PDO( //change the following 3 lines to connect to a server
        "mysql:host=localhost;dbname=emp_finder", 
        "root",
        "root"
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
