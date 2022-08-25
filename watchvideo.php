<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
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

    <nav class="navbar navbar-inverse" style="background-color: #002f63;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="watchvideo.php"><img src="BranchLogo.png" alt="icon" width="45" height="45"></a> 
            </div>
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
                        <li><a href="upload.php"> <span class="glyphicon glyphicon-upload"></span> Upload</a></li>
                        <li><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container-fluid">                            
        <?php


            include_once("connection.php");
            $stmt = $conn->prepare("SELECT * FROM tblvideos ORDER BY videoid DESC");
            $stmt->execute();
            $conn=null;


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $location = $row['Location'];
                $location_t = $row['Location_thumbnail'];
                $VideoTitle = $row['VideoTitle'];
                $Likes = $row['Likes'];
                $Dislikes = $row['Dislikes'];

                echo "<form action='videopage.php' method='post'>";
                echo "<div class='videoplaybuttons'>";
                echo "<div class='col-sm-3'>";
                echo "<button class='button button1'>";
                echo "<img src='".$location_t."' controls width='240px' height='135px' alt='thumbnail'>";
                echo substr("<h4>$VideoTitle</h4>",0 ,30);
                echo "<p style='font-size:15px'>Uploader</p>";
                echo "</div>";
                echo "</button>";
                echo "</div>";
                echo '</form>';
            }

        ?>
    </div>
    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>

<!--echo "<button type='button'> <span class='glyphicon glyphicon-thumbs-up'></span> $Likes  </button>";
echo "<video src='".$location."' controls width='320px' height='180px'>";
echo "<button type='button'> <span class='glyphicon glyphicon-thumbs-down'></span> $Dislikes  </button><br>";-->