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

            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'new')" id="defaultOpen" >New videos</button>
                <button class="tablinks" onclick="openCity(event, 'recommended')" >Recommended videos</button>
                <button class="tablinks" onclick="openCity(event, 'liked')">Liked videos</button>
            </div>
                                
            <?php
                echo "<div id='recommended' class='tabcontent'>";
                //<Reccomended videos
                    echo "<div class='video_container'>";
                    echo "<h3> Recommended for you:</h3>";
                    include_once("connection.php");

                    $tagsarray = array();
                    $recovideosarray = array();
                    $likesofrecovideosarray = array();
                    $currentarraypointer = 0;

                    //<Getting tag data
                        $stmt = $conn->prepare("SELECT * FROM TblUsers WHERE Username =:username;");
                        $stmt->bindParam(':username', $_SESSION['CurrentUser']);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $stmt = $conn->prepare("SELECT * FROM TblData WHERE UserID =:Userid ;");
                        $stmt->bindParam(':Userid', $row['UserID']);
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $VideoID = $row['VideoID'];

                            $stmt1 = $conn->prepare("SELECT * FROM TblVideos WHERE VideoID =:videoid;");
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
                        $stmt = $conn->prepare("SELECT * FROM TblVideos ORDER BY videoid DESC");
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
                                $stmt2 = $conn->prepare("SELECT * FROM TblUsers WHERE UserID =:Userid ;");
                                $stmt2->bindParam(':Userid', $userid);
                                $stmt2->execute();
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $uploader = $row2['Username'] ?? 'uploader';
                            //>
    
                            //<Displayer
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
                            $stmt = $conn->prepare("SELECT * FROM TblVideos WHERE Tag =:tag ;");
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
                                $stmt = $conn->prepare("SELECT * FROM TblVideos WHERE VideoID =:videoid ;");
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
                                    $stmt2 = $conn->prepare("SELECT * FROM TblUsers WHERE UserID =:userid ;");
                                    $stmt2->bindParam(':userid', $userid);
                                    $stmt2->execute();
                                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $uploader = $row2['Username'] ?? 'uploader';
                                //>

                                //<Displayer
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
                                //>
                                $currentarraypointer++;
                            }
            
                        //>
                    }

                    echo "</div>";
                //>
                echo "</div>";

                echo "<div id='new' class='tabcontent'>";
                //<New videos
                    echo "<div class='video_container'>";
                    echo "<h3> New videos:</h3>";
                    $stmt = $conn->prepare("SELECT * FROM TblVideos ORDER BY videoid DESC");
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
                            $stmt2 = $conn->prepare("SELECT * FROM TblUsers WHERE UserID =:Userid ;");
                            $stmt2->bindParam(':Userid', $userid);
                            $stmt2->execute();
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $uploader = $row2['Username'] ?? 'uploader';
                        //>

                        //<Displayer
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
                        //>
                    }
                    echo "</div>";
                //>
                echo "</div>";

                echo "<div id='liked' class='tabcontent'>";
                //<Liked videos
                    echo "<div class='video_container'>";
                    echo "<h3> Liked videos:</h3>";

                    // The status of all liked videos
                    $likeindicator = 1;
    
                    // Select the user id
                    $stmt = $conn->prepare("SELECT * FROM TblUsers WHERE Username=:username;" );
                    $stmt->bindParam(':username', $_SESSION["CurrentUser"]);
                    $stmt->execute();
    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
                        // Select videos id that are liked by the user
                        $userid = $row['UserID'];
                        $stmt1 = $conn->prepare("SELECT * FROM TblData WHERE UserId =:userid AND LikeIndicator = :likeindicator;" );
                        $stmt1->bindParam(':userid', $userid);
                        $stmt1->bindParam(':likeindicator', $likeindicator);
                        $stmt1->execute();
    
                        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    
                            // Select the relevant data for the video based of the id gottem in the last step
                            $_VideoID = $row1['VideoID'];
                            $stmt2 = $conn->prepare("SELECT * FROM TblVideos WHERE VideoID =:videoid;" );
                            $stmt2->bindParam(':videoid', $_VideoID);
                            $stmt2->execute();
    
                            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                // Gets all the relevant data like thumbnaisl
                                $VideoID = $row2['VideoID'];
                                $location = $row2['Location'];
                                $location_t = $row2['Location_thumbnail'];
                                $VideoTitle = $row2['VideoTitle'];
                                $userid = $row2['UserID'];
    
                                $stmt3 = $conn->prepare("SELECT * FROM TblUsers WHERE UserID =:Userid;");
                                $stmt3->bindParam(':Userid', $userid);
                                $stmt3->execute();
    
                                // Gets uploader
                                $row4 = $stmt3->fetch(PDO::FETCH_ASSOC);
    
                                $uploader = $row4['Username'] ?? 'uploader';
    
                                // Display the video
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
                    }
                    $conn=null;    

                    echo "</div>";
                //>
                echo "</div>";
                $conn=null;    
            ?>
        </div>
    </div>

    <script>
        // Lets me hide the login page when signing up is on and vice versa
        document.getElementById("defaultOpen").click();

        function openCity(evt, Name) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            document.getElementById(Name).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

</body>
</html>