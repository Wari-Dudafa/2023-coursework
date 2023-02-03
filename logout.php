<?php
    session_start();
    $_SESSION['LoginFeedback']="7";

    // If The variable is not empty then empty it 
    if(isset($_SESSION['CurrentUser'])) {
        unset($_SESSION['CurrentUser']);
    }

    // Takes user back to login page
    header("Location: user.php");
?>