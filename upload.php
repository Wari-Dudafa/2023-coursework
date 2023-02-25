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

    <?php
        include_once("navbar.php");
        echo $navbar[0];
        echo " " . $_SESSION["CurrentUser"] . " "; 
        echo $navbar[1];
    ?>

    <!--This is the form where u put in the video and thumbnail and tag-->
    <div class="main">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="well" style="background-color: #d3e7ff;">
                    <div class="well" style="background-color: #b3d5ff;">
                        <h1><center>Upload</center></h1>
                    </div>
                        <form method="post" action="uploadhandler.php" enctype="multipart/form-data">
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
                                    <br>
                                    <P>Accepted file tpes are: "mp4", "mov", "mpeg" and "mkv"</P>
                                    <P>Files must be below: 10Mb</P>
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
            <div class="col-sm-3"></div>
        </div>
    </div>
    
    <!--Maroon footer-->
    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>