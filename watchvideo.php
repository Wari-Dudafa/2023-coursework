<!DOCTYPE html>
<html lang="en">
<head>
    <title>Branch</title>
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

    <div class="main">   
        <div class="container-fluid">
                                
            <?php
                //<Reccomended videos
                    echo "<div class='reccomended_videos'>";
                    echo "<h3> Recommended for you:</h3>";
                    include_once("connection.php");

                    $tagsarray = array();
                    $recovideosarray = array();
                    $likesofrecovideosarray = array();
                    $currentarraypointer = 0;

                    //<Getting tag data
                        $stmt = $conn->prepare("SELECT * FROM tblusers WHERE Username =:username;");
                        $stmt->bindParam(':username', $_SESSION['CurrentUser']);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $stmt = $conn->prepare("SELECT * FROM tbldata WHERE UserID =:Userid ;");
                        $stmt->bindParam(':Userid', $row['UserID']);
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                            $VideoID = $row['VideoID'];

                            $stmt1 = $conn->prepare("SELECT * FROM tblvideos WHERE VideoID =:videoid;");
                            $stmt1->bindParam(':videoid', $VideoID);
                            $stmt1->execute();

                            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){

                                //<Gets video details
                                    $tag = $row1['Tag'];

                                    if ($currentarraypointer < 10){
                                        $tagsarray[$currentarraypointer] = $tag;
                                        $currentarraypointer++;
                                    }
                                //>

                                /*
                                echo "<form action='videopage.php' method='post'>";
                                echo "<div class='videoplaybuttons'>";
                                echo "<div class='col-sm-3'>";
                                echo "<button class='button button1'>";
                                echo "<img src='".$location_t."' controls width='240px' height='135px' alt='thumbnail'>";
                                echo substr("<h4>$VideoTitle</h4>",0 ,30);
                                echo "<p style='font-size:15px'>$uploader</p>";
                                echo "<p style='font-size:15px'>$tag</p>";//Get rid of this when reccomendations are completed
                                echo "<div class='videoidform'>";
                                echo "<input type='text' name='VideoID' value='".$VideoID."'>";
                                echo "</div>";
                                echo "</div>";
                                echo "</button>";
                                echo "</div>";
                                echo '</form>';
                                */
                            }
                        }
                        $currentarraypointer = 0;
                    //>

                    //<Array of tags in video
                        if (isset($populartag)){
                            function populartag($tagsarray) {
                                $values = array();
                                foreach ($tagsarray as $v) {
                                    if (isset($values[$v])) {
                                        $values[$v] ++;
                                    } else {
                                        $values[$v] = 1;
                                    }
                                } 
                                arsort($values);
                                $modes = array();
                                $x = $values[key($values)];
                                reset($values); 
                                foreach ($values as $key => $v) {
                                    if ($v == $x) {
                                        $modes[] = $key;
                                    } else {
                                        break;
                                    }
                                } 
                                return $modes;
                            }
                            
                            $populartag = populartag($tagsarray)[0];
                        } else {
                            $populartag = 0;
                        }
                    //>

                    //<Get most watched tag
                        $stmt = $conn->prepare("SELECT * FROM tblvideos WHERE Tag =:tag ;");
                        $stmt->bindParam(':tag', $populartag);
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                            //<Gets video details
                                $VideoID = $row['VideoID'];
                                $location = $row['Location'];
                                $location_t = $row['Location_thumbnail'];
                                $VideoTitle = $row['VideoTitle'];
                                $userid = $row['UserID'];
                                $tag = $row['Tag'];
                            //>

                            //<Gets the uploader
                                $stmt2 = $conn->prepare("SELECT * FROM tblusers WHERE UserID =:Userid ;");
                                $stmt2->bindParam(':Userid', $userid);
                                $stmt2->execute();
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $uploader = $row2['Username'];
                            //>

                            if ($currentarraypointer < 10){
                                $recovideosarray[$currentarraypointer] = $VideoID;
                                $currentarraypointer++;
                            }

                            //<Displayer
                                echo "<form action='videopage.php' method='post'>";
                                echo "<div class='videoplaybuttons'>";
                                echo "<div class='col-sm-3'>";
                                echo "<button class='button button1'>";
                                echo "<img src='".$location_t."' controls width='240px' height='135px' alt='thumbnail'>";
                                echo substr("<h4>$VideoTitle</h4>",0 ,30);
                                echo "<p style='font-size:15px'>$tag - $uploader</p>";
                                echo "<div class='videoidform'>";
                                echo "<input type='text' name='VideoID' value='".$VideoID."'>";
                                echo "</div>";
                                echo "</div>";
                                echo "</button>";
                                echo "</div>";
                                echo '</form>';
                            //>
                        }
                        $currentarraypointer = 0;
                    //>

                    //<Get likes
                        while($currentarraypointer < 10){
                            $likes = $conn->prepare("SELECT * FROM TblData WHERE LikeIndicator = 1 AND VideoID = :videoid;)");
                            $likes->bindParam(':videoid', $recovideosarray[$currentarraypointer]);
                            $likes->execute();

                            $likesofrecovideosarray[$currentarraypointer] = $likes->rowCount();
                            $currentarraypointer++;
                            
                        }
                        $currentarraypointer = 0;
                    //>

                    echo "VideoID ";
                    print_r($recovideosarray);
                    echo "<br>";
                    echo "LikeCounter ";
                    print_r($likesofrecovideosarray);

                    echo "</div>";
                //>

                //<New videos
                    echo "<div class='new_videos'>";
                    echo "<h3> New videos:</h3>";
                    $stmt = $conn->prepare("SELECT * FROM tblvideos ORDER BY videoid DESC");
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                        //<Gets video details
                            $VideoID = $row['VideoID'];
                            $location = $row['Location'];
                            $location_t = $row['Location_thumbnail'];
                            $VideoTitle = $row['VideoTitle'];
                            $userid = $row['UserID'];
                        //>

                        //<Gets the uploader
                            $stmt2 = $conn->prepare("SELECT * FROM tblusers WHERE UserID =:Userid ;");
                            $stmt2->bindParam(':Userid', $userid);
                            $stmt2->execute();
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $uploader = $row2['Username'];
                        //>

                        //<Displayer
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
                        //>
                    }
                    echo "</div>";
                //>
                $conn=null;    
            ?>
        </div>
    </div>
    
    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>