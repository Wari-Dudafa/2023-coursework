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

    <?php //Navbar
        include_once("navbar.php");
        echo $navbar[0];
        echo " " . $_SESSION["CurrentUser"] . " "; 
        echo $navbar[1];
    ?>

    <div class="main">
        <div class="container-fluid">               
            <?php
                // Defines the search value
                $searchvalue = $_GET["search"];
                echo "<h3> Search results for: $searchvalue</h3>";
                include_once("connection.php");
                
                //Partial search to make sure the user can search for things even when spelled differently
                $partialsearch = "%" . $_GET['search'] . "%";
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

                    $uploader = $row2['Username'] ?? 'uploader';
                    
                    // Dsiplays the video thumbnails
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
                $conn=null;    
            ?>
        </div>
    </div>

</body>
</html>