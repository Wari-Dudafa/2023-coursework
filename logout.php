<?php
    if(isset($_SESSION['CurrentUser']))
    {
        unset($_SESSION['CurrentUser']);
    }
    header("Location: user.php");
?>
