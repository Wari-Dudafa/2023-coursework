<?php
    session_start();
    include_once ("connection.php");
    array_map("htmlspecialchars", $_POST);

    // Selects the point in the databse where the username inputted is in the database
    $stmt = $conn->prepare("SELECT * FROM tblusers WHERE Username =:Username ;" );
    $stmt->bindParam(':Username', $_POST['Username']);
    $stmt->execute();

    header('Location: user.php');
    $_SESSION['LoginFeedback']="2";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        // Password verification that compares a hash of the password to what is stored in the database
        if(password_verify($_POST["Password"], $row['Password'])) {
            $_SESSION['CurrentUser']=$row["Username"];
            header('Location: watchvideo.php');
            // Success
        } else {
            $_SESSION['LoginFeedback']="6";
            header('Location: user.php');
            // Fail
        }
    }
    $conn=null
?>