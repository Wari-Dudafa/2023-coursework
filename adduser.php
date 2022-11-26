<?php
	session_start();
	$_SESSION['LoginFeedback']="3";
	include_once("connection.php");
	array_map("htmlspecialchars", $_POST);
	
	$blankusername = $conn->prepare("select * from TblUsers where Username = :Username;)");
	$blankusername->bindParam(':Username', $_POST["Username"]);
	$blankusername->execute();
	//does query have rows returned

	$count = $blankusername->rowCount();
	echo($count);
	while ($row = $blankusername->fetch(PDO::FETCH_ASSOC))
		{
		echo($row["Username"]."<br>");
		}
	
	if ($count > 0){
		$_SESSION['LoginFeedback']="4";
		header('Location: user.php');
	}
	else
	{
		unset($blankusername);

		if ($_POST["Username"]==""){
			echo ("no");
			$_SESSION['LoginFeedback']="5";
			header('Location: user.php');
		}else{
			$hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);
			$stmt = $conn->prepare("INSERT INTO TblUsers (UserID,Username,Password)VALUES (null,:Username,:Password)");
			$stmt->bindParam(':Username', $_POST["Username"]);
			$stmt->bindParam(':Password', $hashed_password);
			$stmt->execute();
			$conn=null;
			echo $_POST["Username"]."<br>";
			echo $hashed_password."<br>";
			header('Location: user.php');
		}
	}
	echo "" . $_SESSION["LoginFeedback"];
?>