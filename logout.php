<?php
    if(isset($_SESSION['CurrentUser']))
    {
        unset($_SESSION['CurrentUser']);
    }
    session_start();
    $_SESSION['LoginFeedback']="7";
    header("Location: user.php");
?>
