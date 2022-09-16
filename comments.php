<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
</head>
<body>
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
            $getcomments->bindParam(':videoid', $videoid);
            $getcomments->execute();

            while ($row5 = $getcomments->fetch(PDO::FETCH_ASSOC)){
                $comment = $row5['Comment'];
                echo "<h3 style='font-size:15px'>'".$comment."'</h3>";
                echo ($comment);
            }
        //>
        
        $conn=null;
        header("Location: videopage.php");
    ?>
</body>
</html>