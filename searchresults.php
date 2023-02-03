<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search results</title>
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
    <!--This is the navbar-->
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
                                session_start();
                                // Checks if the user is logged in
                                if (!isset($_SESSION['CurrentUser'])) {   
                                    header("Location:user.php");
                                    echo "Please login to continue<br>";
                                } else {
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

    <div class="main">
        <div class="container-fluid">               
            <?php
                // Defines the search value
                $searchvalue = $_POST["search"];
                echo "<h3> Search results for: $searchvalue</h3>";
                include_once("connection.php");
                
                //Partial search to make sure the user can search for things even when spelled differently
                $partialsearch = "%" . $_POST['search'] . "%";
                $stmt = $conn->prepare("SELECT * FROM tblvideos WHERE Videotitle LIKE :search;" );
                $stmt->bindParam(':search', $partialsearch);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    // The video details of the videos that match the search
                    $VideoID = $row['VideoID'];
                    $location = $row['Location'];
                    $location_t = $row['Location_thumbnail'];
                    $VideoTitle = $row['VideoTitle'];
                    $userid = $row['UserID'];

                    // Gets the uploader
                    $stmt2 = $conn->prepare("SELECT * FROM tblusers WHERE UserID =:Userid;");
                    $stmt2->bindParam(':Userid', $userid);
                    $stmt2->execute();

                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $uploader = $row2['Username'];
                    
                    // Dsiplays the video thumbnails
                    echo "<form action='videopage.php' method='post'>";
                    echo "<div class='videoplaybuttons'>";
                    echo "<div class='col-sm-3'>";
                    echo "<button class='button button1'>";
                    echo "<img src='".$location_t."' controls width='240px' height='135px' alt='thumbnail'>";
                    echo substr("<h4>$VideoTitle</h4>",0 ,30);
                    echo "<p style='font-size:15px'>$uploader</p>";
                    echo "<div class='videoidform'>";
                    echo "<input type='text' name='VideoID' value='".$VideoID."'>";
                    echo "</div>";
                    echo "</div>";
                    echo "</button>";
                    echo "</div>";
                    echo '</form>';
                }
                $conn=null;    
            ?>
        </div>
    </div>

</body>
</html>