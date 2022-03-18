<?php

function connect_db(){
    $hostdb = 'mysql';
    $namedb = 'library';
    $userdb = 'root';
    $passdb = 'root';
    $conn = new PDO("mysql:host=$hostdb; dbname=$namedb", $userdb, $passdb);
    $conn->exec("SET CHARACTER SET utf8");
    return $conn;
}

