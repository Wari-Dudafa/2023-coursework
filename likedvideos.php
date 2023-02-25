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
    <title>Liked videos</title>
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

    <div class="main">
        <div class="container-fluid">         
            <h2>Your liked videos:</h2>      

            <?php
                include_once("connection.php");
                // The status of all liked videos
                $likeindicator = 1;

                // Select the user id
                $stmt = $conn->prepare("SELECT * FROM tblusers WHERE Username=:username;" );
                $stmt->bindParam(':username', $_SESSION["CurrentUser"]);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    // Select videos id that are liked by the user
                    $userid = $row['UserID'];
                    $stmt1 = $conn->prepare("SELECT * FROM tbldata WHERE UserId =:userid AND LikeIndicator = :likeindicator;" );
                    $stmt1->bindParam(':userid', $userid);
                    $stmt1->bindParam(':likeindicator', $likeindicator);
                    $stmt1->execute();

                    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                        // Select the relevant data for the video based of the id gottem in the last step
                        $_VideoID = $row1['VideoID'];
                        $stmt2 = $conn->prepare("SELECT * FROM tblvideos WHERE VideoID =:videoid;" );
                        $stmt2->bindParam(':videoid', $_VideoID);
                        $stmt2->execute();

                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            // Gets all the relevant data like thumbnaisl
                            $VideoID = $row2['VideoID'];
                            $location = $row2['Location'];
                            $location_t = $row2['Location_thumbnail'];
                            $VideoTitle = $row2['VideoTitle'];
                            $userid = $row2['UserID'];

                            $stmt3 = $conn->prepare("SELECT * FROM tblusers WHERE UserID =:Userid;");
                            $stmt3->bindParam(':Userid', $userid);
                            $stmt3->execute();

                            // Gets uploader
                            $row4 = $stmt3->fetch(PDO::FETCH_ASSOC);

                            $uploader = $row4['Username'];

                            // Display the video
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
                    }
                }
                $conn=null;    
            ?>
        </div>
    </div>

</body>
</html>