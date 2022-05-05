<!DOCTYPE html>
<html lang="en">
<head>
    <title>placeholder</title>
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
</head>
<body>

    <a href="placeholder.php"> <!--Change me to a homepage-->
        <img src="BranchLogo.png" alt="my picture" height="45" width="45" />
    </a>

    <a href="upload.php"><?php
        session_start();
        if (!isset($_SESSION['CurrentUser']))
        {   
            header("Location:user.php");
            echo "Please login to continue<br>";
        }else{
            //echo "Access granted<br>";
            echo "Current user: " . $_SESSION["CurrentUser"]."<br>";
        }
    ?></a>
    <a href="logout.php">Logout</a>

    <form action="search_results.php" method="post">
        <input type="text" placeholder="Search..." name="search">
        <button type="submit"><i class="fa">&#x1F50E;&#xFE0E;</i></button>
    </form>


    <h1>Homepage placeholder</h1>

    <footer>
        <!--<p></p>-->
    </footer>
</body>
</html>
