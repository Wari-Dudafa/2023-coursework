<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>placeholder</title>
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['CurrentUser']))
    {   
        header("Location:user.php");
        echo "Please login to continue<br>";
    }else{
        //echo "Access granted<br>";
        echo "Current user: " . $_SESSION["CurrentUser"]."<br>";
    }
    ?>

    <button onclick="window.location.href='logout.php'">Logout</button><br>
    Placeholder
</body>
</html>