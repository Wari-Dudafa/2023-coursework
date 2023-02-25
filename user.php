<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login/Sign up</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        body {font-family: Arial;}

        /* Style the tab */
        .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #d3e7ff;
        border-radius: 15px;
        }

        /* Style the buttons inside the tab */
        .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
        background-color: aliceblue;
        }

        /* Create an active/current tablink class */
        .tab button.active {
        background-color: #bad9ff;
        }

        /* Style the tab content */
        .tabcontent {
        display: none;
        padding: 6px 12px;
        border-top: none;
        }
    </style>
</head>
<body> 

    <!--Navbar-->
    <div class="top_navbar">
        <nav class="navbar navbar-inverse" style="background-color: #002f63;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="watchvideo.php"><img src="BranchLogo.png" alt="icon" width="45" height="45"></a> 
                </div>
            </div>
        </nav>
    </div>

    <div class="col-sm-3"></div>

    <div class="col-sm-6">
        <div class="main">
            <div class="LoginFeedback">
                <center>
                    <?php
                        // User login feedback

                        if (!isset($_SESSION['LoginFeedback'])) {   
                            $_SESSION['LoginFeedback']="1";}
                            // If the session variable is empty, set it to 1

                        if ($_SESSION['LoginFeedback']=="1") {   
                            echo "";
                            // No feedback (Default)
                        }if ($_SESSION['LoginFeedback']=="2") {
                            echo "<h3 style='color: #ff2626;'> Login failed, wrong username";
                            // Username does not exist in the databse
                        }if ($_SESSION['LoginFeedback']=="3") {
                            echo "<h3 style='color: #149e08;'> Account created successfully, please login";
                            // Account created succesfully
                        }if ($_SESSION['LoginFeedback']=="4") {
                            echo "<h3 style='color: #ff2626;'> Username already exists";
                            // Username already exists so signup is voided
                        }if ($_SESSION['LoginFeedback']=="5") {
                            echo "<h3 style='color: #ff2626;'> Username is empty";
                            // Username has been left blank
                        }if ($_SESSION['LoginFeedback']=="6") {
                            echo "<h3 style='color: #ff2626;'> Login failed, wrong password";
                            // Password inputted in incorrect
                        }if ($_SESSION['LoginFeedback']=="7") {
                            echo "<h3 style='color: #149e08;'> Successfully logged out";
                            // Logout has been done succesfully
                        }
                    ?>
                </h3></center>
            </div>

            <!--Tabs that let u switch between upload and sign up-->
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'login')" id="defaultOpen" >Login</button>
                <button class="tablinks" onclick="openCity(event, 'signup')">Sign up</button>
            </div>

            <div id="signup" class="tabcontent">
                <div class="well" style="background-color: aliceblue;">
                    <h2><center>Sign up</center></h2><br>
                    <!--Sign up form-->
                    <div class="form-group">
                        <form action="adduser.php" method="post">
                            <center>      

                                <!--Input username-->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="text" name="Username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
                                </div>

                                <!--Input password-->
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" name="Password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    <small id="emailHelp" class="form-text text-muted">Try to remember your username and password</small>
                                </div>

                                <input type="submit" class="btn btn-primary btn-lg" value="Sign up">

                            </center>
                        </form>
                    </div>
                </div>
            </div>

            <div id="login" class="tabcontent">
                <div class="well" style="background-color: aliceblue;">
                    <h2><center>Login</center></h2><br>
                    <!--Login form-->
                    <div class="form-group">
                        <form action="loginuser.php" method="post">
                            <center>         

                                <!--Input username-->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="text" name="Username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
                                </div>

                                <!--Input password-->
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" name="Password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>

                                <input type="submit" class="btn btn-primary btn-lg" value="Login">

                                <!--Things to click at the botttom of the page-->
                                <div class="thingsatthebottomoftheloginpage">
                                    
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Remeber me</label>
                                    </div>

                                    <a href="#" data-toggle="popover" title="" data-content="For security reasons, we dont store your password so try to rememeber it.">Forgot your password?</a><br>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        <div>
    <div>

    <div class="col-sm-3"></div>

    <script>
        // Lets me hide the login page when signing up is on and vice versa
        document.getElementById("defaultOpen").click();

        function openCity(evt, Name) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            document.getElementById(Name).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

    <script>
        // The hint pop up that appears
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();   
        });
    </script>

    <!--Maroon footer-->
    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>