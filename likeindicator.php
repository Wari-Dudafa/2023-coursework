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
    <title>Like Indicator</title>
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

    <div class="videoidform">
        <?php // Like indicator handler
            include_once("connection.php");

            // Defines variables to add to the database
            $userid = $_GET["userid"];
            $likeindicator = $_GET["likeindicator"];
            $videoid = $_GET["videoid"];

            // Let's me test that all the recieved data is correct
            echo "UserID: $userid <br>";
            echo "Like indicator: $likeindicator <br>";
            echo "VideoID: $videoid <br>";

            // Creates a form so a redirect back to the video player will play the correct video
            echo "<form id='likeindicatorposter' action='videopage.php' method='get'>";
            echo "<input type='text' name='VideoID' value='".$videoid."'>";
            echo '</form>';

            // Updates the databse to change the like indicator
            $stmt = $conn->prepare("UPDATE TblData SET LikeIndicator = :likeindicator WHERE VideoID = :videoid AND UserID = :userid");
            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':videoid', $videoid);
            $stmt->bindParam(':likeindicator', $likeindicator);
            $stmt->execute();
            $conn=null;
        ?>
    </div>
</body>
</html>