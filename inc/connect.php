<?php
    date_default_timezone_set("Africa/Lagos");
    $host     = "localhost";
    $username = "root";
    $password = "";
    $dbname   = "e_class";
    $charset  = "utf8mb4";
    try {
        $dsn = 'mysql:host='.$host.';dbname='.$dbname.";charset=".$charset;
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: ".$e->getMessage();
    }