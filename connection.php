<?php

    // Variables for the database connections
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtbBranch";

    try {
        // Connection variable
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        // Cnnnection fail
    }
?>
