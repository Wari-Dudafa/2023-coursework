<?php
    session_start();
    // Checks is a user is logged in
    if (!isset($_SESSION['CurrentUser'])) {   
        header("Location:user.php");
        echo "Please login to continue<br>";
    }

    // Get video id
    include_once("connection.php");
    $videoid = $_GET["VideoID"];

    // There is no video id for what ever reason
    if (!isset($videoid)) {
        header("Location:homepage.php");
    }

    // Gets video details
    $stmt = $conn->prepare("SELECT * FROM TblVideos WHERE VideoID LIKE :videoid ;" );
    $stmt->bindParam(':videoid', $_GET['VideoID']);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Gets video information
        $VideoTitle = $row['VideoTitle'];
        $userid = $row['UserID'];
        $location = $row['Location'];
        $location_t = $row['Location_thumbnail'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        <?php
            echo "$VideoTitle";
        ?>
    </title>
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

    <?php //Navbar
        include_once("navbar.php");
        echo $navbar[0];
        echo " " . $_SESSION["CurrentUser"] . " "; 
        echo $navbar[1];
    ?>

    <div class="main">
        <div class="container-fluid">                 
            <?php
                $getusername = $conn->prepare("SELECT * FROM TblUsers WHERE UserID = :Userid ;");
                $getusername->bindParam(':Userid', $userid);
                $getusername->execute();
                
                $row2 = $getusername->fetch(PDO::FETCH_ASSOC);
                $uploader = $row2['Username'] ?? 'uploader';

                //<insert user and video id into the data table
                    //< Get user id
                        $getuserid = $conn->prepare("SELECT * FROM TblUsers WHERE Username = :Username;");
                        $getuserid->bindParam(':Username', $_SESSION['CurrentUser']);
                        $getuserid->execute();

                        while ($row = $getuserid->fetch(PDO::FETCH_ASSOC)) {
                            $currentuserid = $row["UserID"];
                        }
                    //>

                    //< Cheching if user and video already exist in the databse

                        $alreadyexist = $conn->prepare("SELECT * FROM TblData WHERE UserID = :userid AND VideoID = :videoid;)");
                        $alreadyexist->bindParam(':userid', $currentuserid);
                        $alreadyexist->bindParam(':videoid', $_GET['VideoID']);
                        $alreadyexist->execute();
                
                        $count = $alreadyexist->rowCount();
                        unset($alreadyexist);
                        
                        // It does
                        if ($count == 0) {
                            $DefaultLikeIndicator = 3;
                            $data = $conn->prepare("INSERT INTO  TblData (UserID,VideoID,LikeIndicator)VALUES (:userid,:videoid,:DefaultLikeIndicator)");
                            $data->bindParam(':userid', $currentuserid);
                            $data->bindParam(':videoid', $_GET['VideoID']);
                            $data->bindParam(':DefaultLikeIndicator', $DefaultLikeIndicator);
                            $data->execute();
                        }
                    //>

                    //< Getting video view count
                        $viewcount = $conn->prepare("SELECT * FROM TblData WHERE VideoID = :videoid;)");
                        $viewcount->bindParam(':videoid', $_GET['VideoID']);
                        $viewcount->execute();
                
                        $views = $viewcount->rowCount();
                        unset($viewcount);
                    //>
                //>

                //<video displayer
                    echo "<div class='videoplaybuttons'>";
                    echo "<div class='col-sm-6'>";
                    echo "<div class='well' style='background-color: #d3e7ff;'>";
                    echo "<div class='well' style='background-color: #b3d5ff;'>";
                    echo substr("<h1>$VideoTitle</h1>",0 ,70);
                    echo "<h3 style='font-size:20px'>$uploader</h3>";
                    //<View counter
                        if ($views == 1) {
                            echo "<h3 style='font-size:15px'>$views view</h3>";
                        }
                        if ($views != 1) {
                            echo "<h3 style='font-size:15px'>$views views</h3>";
                        }
                    //>
                    
                    //< Likes/Dislikes

                        $likeindication = 1;
                        $dislikeindication = 2;

                        //< Get Dislikes
                            $likes = $conn->prepare("SELECT * FROM TblData WHERE LikeIndicator = :likeindication AND VideoID = :videoid;)");
                            $likes->bindParam(':likeindication', $likeindication);
                            $likes->bindParam(':videoid', $_GET["VideoID"]);
                            $likes->execute();
                    
                            $likecount = $likes->rowCount();
                            unset($likes);
                        //>

                        //< Get Likes
                            $dislikes = $conn->prepare("SELECT * FROM TblData WHERE LikeIndicator = :dislikeindication AND VideoID = :videoid;)");
                            $dislikes->bindParam(':dislikeindication', $dislikeindication);
                            $dislikes->bindParam(':videoid', $_GET["VideoID"]);
                            $dislikes->execute();
                    
                            $dislikecount = $dislikes->rowCount();
                            unset($dislikes);
                        //>

                        //< Likes
                            echo "<div class='col-sm-1'>";
                            echo "<form action='likeindicator.php' method='get'>";
                            echo "<div class='videoidform'>";
                            echo "<input type='text' name='videoid' value='".$videoid."'>";
                            echo "<input type='text' name='userid' value='".$currentuserid."'>";
                            echo "<input type='text' name='likeindicator' value='1'>";
                            echo "</div>";
                            echo "<button type='submit' class='btn btn-light'> <span class='glyphicon glyphicon-thumbs-up'></span> $likecount</button>";
                            echo "</form>";
                            echo "</div>";
                        //>

                        //< Dislikes
                            echo "<div class='col-sm-2'>";
                            echo "<form action='likeindicator.php' method='get'>";
                            echo "<div class='videoidform'>";
                            echo "<input type='text' name='videoid' value='".$videoid."'>";
                            echo "<input type='text' name='userid' value='".$currentuserid."'>";
                            echo "<input type='text' name='likeindicator' value='2'>";
                            echo "</div>";
                            echo "<button type='submit' class='btn btn-light'> <span class='glyphicon glyphicon-thumbs-down'></span> $dislikecount</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "<br>";
                        //>
                    //>
                    echo "</div>";
                    echo "<div class='embed-responsive embed-responsive-16by9'>";
                    echo "<center><video src='".$location."' controls width='640px' height='360px'></center>";
                    echo "</div>";
                    echo "<form action='comments.php' method='get'>";
                    echo "<div class='videoidform'>";
                    echo "<input type='text' name='videoid' value='".$videoid."'>";
                    echo "<input type='text' name='userid' value='".$currentuserid."'>";
                    echo "</div>";
                    echo "<h3 style='font-size:15px'>Comment:</h3>";
                    echo "<textarea name='comment' id='textbox' class='form-control' rows='1' cols='1'></textarea>";
                    echo "<span id='char_count'>0</span>";
                    echo "<center><div id='commentbutton'> <button type='submit' class='btn btn-info'>Comment</button> </div>";
                    echo "</form></center>";

                    //< Display comments
                        echo "<div class='well' style='background-color: #b3d5ff;'>";
                        echo "<div class='CommentScroll';'>";
                        
                        $getcomments = $conn->prepare("SELECT * FROM TblComments WHERE VideoID = :videoid ;");
                        $getcomments->bindParam(':videoid', $videoid);
                        $getcomments->execute();

                        while ($row5 = $getcomments->fetch(PDO::FETCH_ASSOC)) {
                            $comment = $row5['Comment'];
                            $commenterid = $row5['UserID'];

                            $getcommenter = $conn->prepare("SELECT * FROM TblUsers WHERE UserID = :userid ;");
                            $getcommenter->bindParam(':userid', $commenterid);
                            $getcommenter->execute();

                            while ($row6 = $getcommenter->fetch(PDO::FETCH_ASSOC)) {

                                $commenter = $row6['Username'];

                                echo "<div class='comment'>";
                                echo "<h3 style='font-size:14px'>".$commenter.":</h3>";
                                echo "<h3 style='font-size:13px'>".$comment."</h3>";
                                echo "</div>";
                            }
                        }
                        echo "</div>";
                        echo "</div>";
                    //>
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                //>
                
                //<Other displayed videos
                    $stmt = $conn->prepare("SELECT * FROM TblVideos ORDER BY videoid DESC");
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        //SQL
                            $VideoID = $row['VideoID'];
                            $location = $row['Location'];
                            $location_t = $row['Location_thumbnail'];
                            $VideoTitle = $row['VideoTitle'];
                            $userid = $row['UserID'];

                            $stmt2 = $conn->prepare("SELECT * FROM TblUsers WHERE UserID =:Userid ;");
                            $stmt2->bindParam(':Userid', $userid);
                            $stmt2->execute();

                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                            $uploader = $row2['Username'] ?? 'uploader';
                        //>

                        if ($VideoID == $_GET['VideoID']) {   
                            // Do nothing
                        }else{
                            echo "<form action='videopage.php' method='get'>";
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
                    }
                    $conn=null;
                //>    
            ?>
        </div>
    </div>
    
    <script src="charcount.js"></script>
</body>
</html>