<!DOCTYPE html>
<html>
<head>
    
    <title>Login/Sign up</title>
    
</head>
<body>
    <p1> Account created succesfully, please login </p><br>
      
<form action="adduser.php" method="post">
  Username:<input type="text" name="Username"><br>
  Password:<input type="password" name="Password"><br>
  <input type="submit" value="Sign up">
</form>

<form action="loginuser.php" method="post">
  Username:<input type="text" name="Username"><br>
  Password:<input type="password" name="Password"><br>
  <input type="submit" value="Login">
</form>
 
</body>
</html>
