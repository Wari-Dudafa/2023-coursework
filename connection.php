<?php

    // Variables for the local database connections
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtbBranch";

    // Variables for the serverside database connections
    //$servername = "fdb32.awardspace.net";
    //$username = "4023696_dtbbranch";
    //$password = "C]_S8WwO8Tb8p0xT";
    //$dbname = "4023696_dtbbranch";

    try {
        // Connection variable
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        header("Location:user.php");
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        // Connnection fail
    }
?>