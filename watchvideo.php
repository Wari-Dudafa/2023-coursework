<?php
    session_start();
    // Checks if the user is logged in
    if (!isset($_SESSION['CurrentUser'])) {   
        header("Location:user.php");
        echo "Please login to continue<br>";
    }
?>
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

    <?php
        include_once("navbar.php");
        echo $navbar[0];
        echo " " . $_SESSION["CurrentUser"] . " "; 
        echo $navbar[1];
    ?>

    <div class="main">   
        <div class="container-fluid">
                                
            <?php
                //<Reccomended videos
                    echo "<div class='recommended_videos'>";
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

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $VideoID = $row['VideoID'];

                            $stmt1 = $conn->prepare("SELECT * FROM tblvideos WHERE VideoID =:videoid;");
                            $stmt1->bindParam(':videoid', $VideoID);
                            $stmt1->execute();

                            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                                //<Gets video details
                                    $tag = $row1['Tag'];

                                    if ($currentarraypointer < 10) {
                                        $tagsarray[$currentarraypointer] = $tag;
                                        $currentarraypointer++;
                                    }
                                //>

                            }
                        }
                        $currentarraypointer = 0;
                    //>

                    //New users will have no watch history
                    if(!isset($tagsarray[0])) {
                        $stmt = $conn->prepare("SELECT * FROM tblvideos ORDER BY videoid DESC");
                        $stmt->execute();
    
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
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
                    } else{

                        //<Array of tags in video
                            if (!isset($populartag)) {
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

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                $VideoID = $row['VideoID'];

                                if ($currentarraypointer < 10) {
                                    $recovideosarray[$currentarraypointer] = $VideoID;
                                    $currentarraypointer++;
                                }

                            }
                            $currentarraypointer = 0;
                        //>

                        //<Get likes and the sorting data
                            while($currentarraypointer < 10) {
                                $likes = $conn->prepare("SELECT * FROM TblData WHERE LikeIndicator = 1 AND VideoID = :videoid;)");
                                $likes->bindParam(':videoid', $recovideosarray[$currentarraypointer]);
                                $likes->execute();

                                $likesofrecovideosarray[$currentarraypointer] = $likes->rowCount();
                                $currentarraypointer++;
                                
                            }
                            $currentarraypointer = 0;
                        

                            $reconvideosdata = array(
                                // Array of videos to be reccomended and their like counter
                                array($likesofrecovideosarray[0],$recovideosarray[0]),
                                array($likesofrecovideosarray[1],$recovideosarray[1]),
                                array($likesofrecovideosarray[2],$recovideosarray[2]),
                                array($likesofrecovideosarray[3],$recovideosarray[3]),
                                array($likesofrecovideosarray[4],$recovideosarray[4]),
                                array($likesofrecovideosarray[5],$recovideosarray[5]),
                                array($likesofrecovideosarray[6],$recovideosarray[6]),
                                array($likesofrecovideosarray[7],$recovideosarray[7]),
                                array($likesofrecovideosarray[8],$recovideosarray[8]),
                                array($likesofrecovideosarray[9],$recovideosarray[9]),
                            );

                            // A funtion to perform the bubble sort algorithm on the array
                            function bubble_sort($arr) {
                                // Gets the length of the array
                                $size = count($arr)-1;

                                for ($i=0; $i<$size; $i++) {
                                    for ($j=0; $j<$size-$i; $j++) {
                                        $k = $j+1;
                                        if ($arr[$k] < $arr[$j]) {
                                            // Swap elements at indices: $j, $k
                                            list($arr[$j], $arr[$k]) = array($arr[$k], $arr[$j]);
                                        }
                                    }
                                }
                                // Returns the array that is sorted
                                return $arr;
                            }

                            $sorted_reconvideosdata = bubble_sort($reconvideosdata);
                        //>

                        //<Display videos
                            
                            while ($currentarraypointer < 7) {
                                $j = 9 - $currentarraypointer;
                                $stmt = $conn->prepare("SELECT * FROM tblvideos WHERE VideoID =:videoid ;");
                                $stmt->bindParam(':videoid', $sorted_reconvideosdata[$j][1]);
                                $stmt->execute();

                                //<Gets video details
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $VideoID = $row['VideoID'];
                                    $location = $row['Location'];
                                    $location_t = $row['Location_thumbnail'];
                                    $VideoTitle = $row['VideoTitle'];
                                    $userid = $row['UserID'];
                                //>

                                //<Gets the uploader
                                    $stmt2 = $conn->prepare("SELECT * FROM tblusers WHERE UserID =:userid ;");
                                    $stmt2->bindParam(':userid', $userid);
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
                                $currentarraypointer++;
                            }
            
                        //>
                    }

                    echo "</div>";
                //>

                //<New videos
                    echo "<div class='new_videos'>";
                    echo "<h3> New videos:</h3>";
                    $stmt = $conn->prepare("SELECT * FROM tblvideos ORDER BY videoid DESC");
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

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

</body>
</html>