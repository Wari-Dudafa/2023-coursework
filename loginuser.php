<?php
    session_start();
    include_once ("connection.php");
    array_map("htmlspecialchars", $_POST);

    $stmt = $conn->prepare("SELECT * FROM tblusers WHERE Username =:Username ;" );
    $stmt->bindParam(':Username', $_POST['Username']);
    $stmt->execute();

    header('Location: user.php');
    $_SESSION['LoginFeedback']="2";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    { 
        if(password_verify($_POST["Password"], $row['Password'])){
            $_SESSION['CurrentUser']=$row["Username"];
            header('Location: watchvideo.php');
            // Success
            
        }else{
            $_SESSION['LoginFeedback']="6";
            header('Location: user.php');
            // Fail
            
        }
    }
    $conn=null
?>