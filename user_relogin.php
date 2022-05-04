<!DOCTYPE html>
<html>
<head>
    
    <title>Login/Sign up</title>
    <link rel="icon" type="image/x-icon" href="BranchLogo.png">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
<nav>

  <div class="topnav">
      <div class="icon">   
          <a href="placeholder.php"> <!--Change me to a homepage-->
                  <img src="BranchLogo.png" alt="my picture" height="45" width="45" />
              </a>
      </div>

  </div>
</nav>
  <h1><center>Login failed please try again</center></h1>
  <div class="loginsignup">
    <div class="loginsignupchild">
      <h1>Sign up</h1>
      <form action="adduser.php" method="post">
        Username:<input type="text" name="Username" style="margin-bottom: 10px;"><br>
        Password:<input type="password" name="Password" style= "margin-bottom: 10px;"><br>
        <input type="submit" value="Sign up">
      </form>
    </div>

    <div class="loginsignupchild">
    <h1>Log in</h1>
      <form action="loginuser.php" method="post">
        Username:<input type="text" name="Username" style="margin-bottom: 10px;"><br>
        Password:<input type="password" name="Password" style="margin-bottom: 10px;"><br>
        <input type="submit" value="Login">
      </form>
    </div>
  </div>

  <footer>
      <!---->
    </footer>
 
</body>
</html>
