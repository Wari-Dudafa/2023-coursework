<?php
    session_start();
    // Checks is a user is logged in
    if (!isset($_SESSION['CurrentUser'])) {   
        header("Location:user.php");
        echo "Please login to continue<br>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Placeholder</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body> 
    
    <?php
        include_once("navbar.php");
        echo $navbar[0];
        echo " " . $_SESSION["CurrentUser"] . " "; 
        echo $navbar[1];
    ?>

    <div class="container-fluid">    
        <h1>Placeholder</h1>
    </div>

</body>
</html>