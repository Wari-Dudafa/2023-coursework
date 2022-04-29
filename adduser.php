<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>adduser</title>
</head>
<body>
	
</body>
</html>


<?php
header('Location: user_createdsuccefully.php');
include_once("connection.php");
array_map("htmlspecialchars", $_POST);
$hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO TblUsers (UserID,Username,Password)VALUES (null,:Username,:Password)");

$stmt->bindParam(':Username', $_POST["Username"]);
$stmt->bindParam(':Password', $hashed_password);
$stmt->execute();
$conn=null;

echo $_POST["Username"]."<br>";
echo $hashed_password."<br>";

?>
