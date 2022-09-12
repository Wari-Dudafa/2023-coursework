<?php
    include_once("connection.php");

    $userid = $_POST["userid"];
    $comment = $_POST["comment"];
    $videoid = $_POST["videoid"];

    echo($userid. "<br>");
    echo($comment. "<br>");
    echo($videoid. "<br>");

    $stmt = $conn->prepare("INSERT INTO TblComments (UserID,VIdeoID,Comment)VALUES (:userid,:videoid,:comment)");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':videoid', $videoid);
    $stmt->execute();
    $conn=null;

    header("Location: videopage.php");
?>