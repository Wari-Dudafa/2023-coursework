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
                <center><h3 style="color: #ff0000;"><?php
                    session_start();
                    //echo "" . $_SESSION["LoginFeedback"];
                    if (!isset($_SESSION['LoginFeedback']))
                    {   
                        $_SESSION['LoginFeedback']="1";}

                    if ($_SESSION['LoginFeedback']=="1")
                    {   
                        echo "";
                    }if ($_SESSION['LoginFeedback']=="2")
                    {
                        echo "Login failed, wrong username";
                    }if ($_SESSION['LoginFeedback']=="3")
                    {
                        echo "Account created successfully, please login";
                    }if ($_SESSION['LoginFeedback']=="4")
                    {
                        echo "Username already exists";
                    }if ($_SESSION['LoginFeedback']=="5")
                    {
                        echo "Username is empty";
                    }if ($_SESSION['LoginFeedback']=="6")
                    {
                        echo "Login failed, wrong password";
                    }if ($_SESSION['LoginFeedback']=="7")
                    {
                        echo "Successfully logged out";
                    }
                ?></h3></center>
            </div>

            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'login')" id="defaultOpen" >Login</button>
                <button class="tablinks" onclick="openCity(event, 'signup')">Sign up</button>
            </div>

            <div id="signup" class="tabcontent">
                <div class="well" style="background-color: aliceblue;">
                    <h2><center>Sign up</center></h2><br>
                    <div class="form-group">
                        <form action="adduser.php" method="post">
                            <center>      

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="text" name="Username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" name="Password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    <small id="emailHelp" class="form-text text-muted">Try to remeber your username and password</small>
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
                    <div class="form-group">
                        <form action="loginuser.php" method="post">
                            <center>         

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="text" name="Username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" name="Password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>

                                <input type="submit" class="btn btn-primary btn-lg" value="Login">

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
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
        });
    </script>

    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>