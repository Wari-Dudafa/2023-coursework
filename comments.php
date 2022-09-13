<?php
    include_once("connection.php");

    $userid = $_POST["userid"];
    $comment = $_POST["comment"];
    $videoid = $_POST["videoid"];

    echo("UserID:" .$userid. "<br>");
    echo("Comment:" .$comment. "<br>");
    echo("VideoID:" .$videoid. "<br>");

    $stmt = $conn->prepare("INSERT INTO TblComments (UserID,VIdeoID,Comment)VALUES (:userid,:videoid,:comment)");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':videoid', $videoid);
    $stmt->execute();

    //< Display comments
        $getcomments = $conn->prepare("SELECT * FROM tblcomments WHERE VideoID = :videoid ;");
        $getcomments->bindParam(':videoid', $_POST['VideoID']);
        $getcomments->execute();

        while ($row5 = $stmt->fetch(PDO::FETCH_ASSOC)){
            $comment = $row5['Comment'];
            echo "<h3 style='font-size:15px'>'".$comment."'</h3>";
            echo ($comment);
        }
    //>
    
    $conn=null;
    //header("Location: videopage.php");***
?>