<?php
    session_start();
    if(isset($_SESSION['CurrentUser']))
    {
        unset($_SESSION['CurrentUser']);
    }
    $_SESSION['LoginFeedback']="7";
    header("Location: user.php");
?>
