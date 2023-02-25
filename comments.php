<?php
    session_start();
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

    <!--Design-->
        <div class="top_navbar">
            <nav class="navbar navbar-inverse" style="background-color: #002f63;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="watchvideo.php"><img src="BranchLogo.png" alt="icon" width="45" height="45"></a> 
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>
                                <?php
                                    // Checking if the user is logged in
                                    if (!isset($_SESSION['CurrentUser'])) {   
                                        header("Location:user.php");
                                        echo "Please login to continue<br>";
                                    } else {
                                        // Access granted
                                        echo "" . $_SESSION["CurrentUser"];
                                    }
                                ?>
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form class="navbar-form navbar-left" action="searchresults.php" method="post">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search branch..." name="search">
                                            <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                            </div>
                                        </div>
                                </form>
                                </li>
                                <li><a href="upload.php"> <span class="glyphicon glyphicon-upload"></span> Upload</a></li>
                                <li><a href="likedvideos.php"> <span class='glyphicon glyphicon-thumbs-up'></span> Liked videos</a></li>
                                <li><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    <!---->

    <?php // Comment handler
        include_once("connection.php");

        // Defines the variables to be posted into the databsae
        $userid = $_POST["userid"];
        $comment = $_POST["comment"];
        $videoid = $_POST["videoid"];

        if (!isset($comment)) {
            // Checks if the comment is empty or not for the sake of robustness
            header("Location:watchvideo.php");
        }

        $stmt = $conn->prepare("INSERT INTO TblComments (UserID,VIdeoID,Comment)VALUES (:userid,:videoid,:comment)");
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':videoid', $videoid);
        $stmt->execute();
        // Adds all the variables to the database

        //Defines a form with the video id so when it gets sent back to the videoplayer- it will play
        echo "<form id='commentposter' action='videopage.php' method='post'>";
        echo "<input type='text' name='VideoID' value='".$videoid."'>";
        echo '</form>';

        $conn=null;
    ?>
</body>
</html>