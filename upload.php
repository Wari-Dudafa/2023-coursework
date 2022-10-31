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
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="well" style="background-color: #d3e7ff;">
                    <div class="well" style="background-color: #b3d5ff;">
                        <h1><center>Upload</center></h1>
                    </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <p>Video:</p><input type='file' name='file'><br>
                            <p>VideoTitle: </p><input type="text" name="Videotitle" value="">
                            <label for="tag">Add tags:</label>
                            <select id="tag" name="tag">
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
                            <p>Thumbnail:</p><input type='file' name='thumb'><br>
                            <center><input type="submit" name="but_upload" value="upload"></center><br>
                        </form>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>

    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>