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

    <!--Design-->
        <div class="top_navbar">
            <nav class="navbar navbar-inverse" style="background-color: #002f63;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="watchvideo.php"><img src="BranchLogo.png" alt="icon" width="45" height="45"></a> 
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <!--<li><a href="upload.php"> <span class="glyphicon glyphicon-upload"></span> Upload</a></li>-->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>
                                <?php
                                    session_start();
                                    if (!isset($_SESSION['CurrentUser']))
                                    {   
                                        header("Location:user.php");
                                        echo "Please login to continue<br>";
                                    }else{
                                        //echo "Access granted<br>";
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

    <?php //Like indicator handler
        include_once("connection.php");

        $userid = $_POST["userid"];
        $likeindicator = $_POST["likeindicator"];
        $videoid = $_POST["videoid"];

        echo "UserID: $userid <br>";
        echo "Like indicator: $likeindicator <br>";
        echo "VideoID: $videoid <br>";

        echo "<form id='likeindicatorposter' action='videopage.php' method='post'>";
        echo "<input type='text' name='VideoID' value='".$videoid."'>";
        echo '</form>';

        $stmt = $conn->prepare("UPDATE TblData SET LikeIndicator = :likeindicator WHERE VideoID = :videoid AND UserID = :userid");
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':videoid', $videoid);
        $stmt->bindParam(':likeindicator', $likeindicator);
        $stmt->execute();
        $conn=null;
    ?>
</body>
</html>