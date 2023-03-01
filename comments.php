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
    <title>Comments</title>
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
    <body onload="document.forms[1].submit()">

    <?php
        include_once("navbar.php");
        echo $navbar[0];
        echo " " . $_SESSION["CurrentUser"] . " "; 
        echo $navbar[1];
    ?>

    <?php // Comment handler
        include_once("connection.php");

        // Defines the variables to be posted into the databsae
        $userid = $_GET["userid"];
        $comment = $_GET["comment"];
        $videoid = $_GET["videoid"];

        if (!isset($comment)) {
            // Checks if the comment is empty or not for the sake of robustness
            header("Location:homepage.php");
        }

        $stmt = $conn->prepare("INSERT INTO TblComments (UserID,VIdeoID,Comment)VALUES (:userid,:videoid,:comment)");
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':videoid', $videoid);
        $stmt->execute();
        // Adds all the variables to the database

        //Defines a form with the video id so when it gets sent back to the videoplayer- it will play
        echo "<form id='commentposter' action='videopage.php' method='get'>";
        echo "<input type='text' name='VideoID' value='".$videoid."'>";
        echo '</form>';

        $conn=null;
    ?>
</body>
</html>