<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login/Sign up</title>
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
    <link rel="stylesheet" href="style.css">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body> 

    <nav class="navbar navbar-inverse" style="background-color: #002f63;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#"><img src="BranchLogo.png" alt="icon" width="45" height="45"></a> 
            </div>
        </div>
    </nav>


    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-5">
            <div class="well" style="background-color: #d3e7ff;">
                <h1><center>Sign up</center></h1>
                <form action="adduser.php" method="post">
                    <center>Username:<input type="text" name="Username" style="margin-bottom: 10px;"><br>
                    Password:<input type="password" name="Password" style= "margin-bottom: 10px;"><br>
                    <input type="submit" value="Sign up"></center>
                </form>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="well" style="background-color: #d3e7ff;">
                <h1><center>Login</center></h1>
                    <form action="loginuser.php" method="post">
                        <center> Username:<input type="text" name="Username" style="margin-bottom: 10px;"><br>
                        Password:<input type="password" name="Password" style="margin-bottom: 10px;"><br>
                        <input type="submit" value="Login"></center>
                    </form>
            </div>
        </div>
        <div class="col-sm-1"></div>
  </div>

    <nav class="navbar navbar-inverse navbar-fixed-bottom" style="background-color: #970830;">

</body>
</html>