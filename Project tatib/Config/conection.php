<?php
$serverName = "DESKTOP-F6C9C3F\DBMS2023";
$database = "tatib";
$username = "sa";
$password = "database";

try {
    // Create a PDO connection
    $dsn = "sqlsrv:Server=$serverName;Database=$database";
    $conn = new PDO($dsn, $username, $password);

    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successful   ly!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>
