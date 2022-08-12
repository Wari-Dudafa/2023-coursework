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
            $stmt = $conn->prepare("SELECT * FROM tblvideos ORDER BY videoid DESC");
            $stmt->execute();
            $conn=null;
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $location = $row['Location'];
                $VideoTitle = $row['VideoTitle'];
                $Likes = $row['Likes'];
                $Dislikes = $row['Dislikes'];

                echo "<div>";
                echo "<p>$VideoTitle</p>";
                echo "<p>likes: $Likes</p>";
                echo "<p>Dislikes: $Dislikes</p>";
                echo "<p>Uploaded by: --</p>";
                echo "<video src='".$location."' controls width='320px' height='200px'>";
                echo "</div>";
                break;

            }

        ?>

        <input type="button" value="Like" onclick="location='test.php'" />
        <input type="button" value="Dislike" onclick="location='test.php'" />
    </div>
</body>
</html>