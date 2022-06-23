<!DOCTYPE html>
<html lang="en">
<head>
	<title>adduser</title>
	<link rel="icon" type="image/x-icon" href="BranchLogo.png">
</head>
<body>
	<?php
		session_start();
		$_SESSION['LoginFeedback']="3";
		//header('Location: user.php');
		include_once("connection.php");
		array_map("htmlspecialchars", $_POST);

		
		$blankuserame = $conn->prepare("select * from TblUsers where Username = :Username;)");
		$blankuserame->bindParam(':Username', $_POST["Username"]);
		$blankuserame->execute();
		#does query have rows returned

		if username = any_username_in_database{
			$_SESSION['LoginFeedback']="4";
			//header('Location: user.php');
		}
		else
		{
			if ($_POST["Username"]==""){
				echo ("no");
				$_SESSION['LoginFeedback']="5";
				//header('Location: user.php');
			}else{
				$hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);

				$stmt = $conn->prepare("INSERT INTO TblUsers (UserID,Username,Password)VALUES (null,:Username,:Password)");

				$stmt->bindParam(':Username', $_POST["Username"]);
				$stmt->bindParam(':Password', $hashed_password);
				$stmt->execute();
				$conn=null;

				echo $_POST["Username"]."<br>";
				echo $hashed_password."<br>";
			}
		}
		echo "" . $_SESSION["LoginFeedback"];
	?>

</body>
</html>