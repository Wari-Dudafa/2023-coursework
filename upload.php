<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload</title>
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
    <link rel="stylesheet" href="style.css">

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
                            include_once("connection.php");

                            if(isset($_POST['but_upload'])){
                                $maxsize = 104857600; //5MB
                    
                                $name = $_FILES['file']['name'];
                                $traget_dir = "tblvideos/";
                                $target_file = $traget_dir . $_FILES["file"]["name"];
                    
                                //file type
                                $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    
                                //acceptable extensions
                                $extensions_arr = array("mp4", "mov", "mpeg");
                    
                                //Checks the video extension
                                if (in_array($videoFileType, $extensions_arr)){
                    
                                    //now we compare file size
                                    if (($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]['size'] == 0)){
                                        echo "File too large.";
                                    }else {
                    
                                        //UPLOADING BIT
                                        //echo "Still working!";
                                        if (move_uploaded_file($_FILES['file']['tmp_name'],$target_file)) {
                                            
                                            //insert into database
                                            //***$query = "INSERT INTO tblVideos(filename, location) VALUES('".$name."','".$target_file."')";
                                            //***mysqli_query($con,$query);
                    
                    
                                            $stmt = $conn->prepare("INSERT INTO TblVideos (VideoID,VideoTitle,FileName,Location)VALUES (null,:videotitle,'".$name."','".$target_file."')");
                                            $stmt->bindParam(':videotitle', $_POST["Videotitle"]);
                                            $stmt->execute();
                                            $conn=null;
                                        
                                        }
                                    }
                                }else{
                                    echo "file error";
                                }
                    
                    
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

    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="well" style="background-color: #d3e7ff;">
                <h1><center>Upload</center></h1>
                    <form method="post" action="" enctype="multipart/form-data">
                        Video title: <input type="text" name="Videotitle" value=""><br>
                        <input type='file' name='file'><br>
                        <input type="submit" name="but_upload" value="upload"><br>
                    </form>
            </div>
        </div>
        <div class="col-sm-4"></div>
        
    </div>


    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>