<?php
    if(isset($_SESSION['CurrentUser']))
    {
        unset($_SESSION['CurrentUser']);
    }
    session_start();
    $_SESSION['LoginFeedback']="1";
    header("Location: user.php");
?>