<!DOCTYPE html>
<html lang="en">
<head>
    <title>Watch video</title>
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
</head>
<body>
    <div>
        <?php

            include_once("connection.php");
            $fetchVideos = mysqli_query($con, "SELECT * FROM tblvideos ORDER BY videoid DESC");
            while ($row = mysqli_fetch_assoc($fetchVideos)) {
                $location = $row['location'];
                
                echo "<div>";
                echo "<video src='".$location."' controls width='320px' height='200px'>";
                echo "</div>";
            }

        ?>
    </div>
    
</body>
</html>