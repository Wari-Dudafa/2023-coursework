<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload</title>
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
                    <!--Logo in the right corner-->
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
                            <!--Icons and dropdown menus-->
                            <li><a href="upload.php"> <span class="glyphicon glyphicon-upload"></span> Upload</a></li>
                            <li><a href="likedvideos.php"> <span class='glyphicon glyphicon-thumbs-up'></span> Liked videos</a></li>
                            <li><a href="logout.php"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <?php // Video upload handler
        include_once("connection.php");             

        if(isset($_POST['but_upload'])) {
            $maxsize = 10048576; // Approx 10MB

            $name = $_FILES['file']['name'];
            $traget_dir = "tblvideos/";// Target folder files will be uploaded to
            $target_file = $traget_dir . $_FILES["file"]["name"];// Name of file from the form
            $tag = $_POST["tag"];// Video tag

            //File type
            $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Acceptable extensions
            $extensions_arr = array("mp4", "mov", "mpeg");// accepted file types

            // Checks the video extension
            // For picture uploads skip this if and go to the next
            if (in_array($videoFileType, $extensions_arr)) {
                
                // Now we compare file size
                if (($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]['size'] == 0)) {
                    echo "<br>upload status: file too big";
                }else{
                    // Picture upload starts here
                    // Thumnbnail upload handler
                    if (move_uploaded_file($_FILES['file']['tmp_name'],$target_file)) {

                        $name_t = $_FILES['thumb']['name'];
                        $traget_dir_t = "tblvideos/";
                        $target_file_t = $traget_dir_t . $_FILES["thumb"]["name"];
            
                        // File type
                        $videoFileType_t = strtolower(pathinfo($target_file_t,PATHINFO_EXTENSION));
            
                        // Acceptable file types
                        $extensions_arr_t = array("png", "jpeg", "jpg");
            
                        // Checks the video extension
                        if (in_array($videoFileType_t, $extensions_arr_t)) {
            
                            // Now we compare file size
                            if (($_FILES['thumb']['size'] >= $maxsize) || ($_FILES["thumb"]['size'] == 0)) {
                                echo "File too large.";
                            }else{
            
                                // Starts uploading
                                if (move_uploaded_file($_FILES['thumb']['tmp_name'],$target_file_t)) {
                                    
                                    // Uploading data to table
                                    $stmt = $conn->prepare("INSERT INTO TblVideos (VideoID,VideoTitle,FileName,Location,FileName_thumbnail,Location_thumbnail,Tag)VALUES (null,:videotitle,'".$name."','".$target_file."','".$name_t."','".$target_file_t."','".$tag."')");
                                    $stmt->bindParam(':videotitle', $_POST["Videotitle"]);
                                    $stmt->execute();

                                    //<Uploaded by segment
                                        //<Gets user id
                                            $stmt1 = $conn->prepare("SELECT * FROM tblusers WHERE Username =:Username ;");
                                            $stmt1->bindParam(':Username', $_SESSION['CurrentUser']);
                                            $stmt1->execute();

                                            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC))
                                            {
                                                $userid=$row["UserID"];
                                            }
                                        //>
                                        
                                        //<Gets video id
                                            $stmt2 = $conn->prepare("SELECT MAX(VideoID) FROM tblvideos;");
                                            $stmt2->execute();

                                            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC))
                                            {
                                                $videoid=$row["MAX(VideoID)"];
                                                //echo " VideoID: '".$videoid."'";
                                            }
                                            
                                        //>

                                        //<Puts user id's into tblusersvideos
                                            $stmt_ = $conn->prepare("UPDATE TblVideos SET UserID = :userid WHERE VideoID = :videoid");
                                            $stmt_->bindParam(':userid', $userid);
                                            $stmt_->bindParam(':videoid', $videoid);
                                            $stmt_->execute();
                                            $conn=null;
                                        //>
                                    //>
                                    echo "<br>upload status: complete";
                                    //Head to a new page after your upload has completed
                                    header('Location: watchvideo.php');                                                
                                }
                            }
                        }
                    }
                }
            }
        }
        else{
            //If upload fails- this happend
            echo "<br>upload status: file error";
        }
    ?>

    <!--This is the form where u put in the video and thumbnail and tag-->
    <div class="main">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="well" style="background-color: #d3e7ff;">
                    <div class="well" style="background-color: #b3d5ff;">
                        <h1><center>Upload</center></h1>
                    </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">

                                <!--Video title input-->
                                <div class="form-group">
                                    <label for="videotitle">Video title*</label>
                                    <input type="text" name="Videotitle" class="form-control" id="videotitle" aria-describedby="emailHelp" placeholder="Enter Title">
                                </div>

                                <!--Tag form-->
                                <div class="form-group">
                                    <label for="selecttag">Select tag</label>
                                    <select id="tag" name="tag" class="form-control" id="selecttag">
                                        <option value="0">none</option>
                                        <option value="1">Education</option>
                                        <option value="2">Entertainment</option>
                                        <option value="3">Music</option>
                                        <option value="4">Politics</option>
                                        <option value="5">Sports</option>
                                        <option value="6">Travel</option>
                                        <option value="7">Comedy</option>
                                        <option value="8">Tutorials</option>
                                        <option value="9">Science and Technology</option>
                                    </select>
                                </div>

                                <!--Video file input-->
                                <div class="form-group">
                                    <label for="videoupload">Video upload*</label>
                                    <input type="file" name='file' class="form-control-file" id="videoupload">
                                </div>

                                <!--Thumbnail file input-->
                                <div class="form-group">
                                    <label for="thumbnailupload">Thumbnail upload*</label>
                                    <input type="file" name='thumb' class="form-control-file" id="thumbnailupload">
                                </div>

                                <center><input type="submit" class="btn btn-primary btn-lg" name="but_upload" value="upload"></center><br>
                            </div>
                        </form>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
    
    <!--Maroon footer-->
    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>