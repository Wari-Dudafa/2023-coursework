<?php
	session_start();
	$_SESSION['LoginFeedback']="3";
	include_once("connection.php");
	array_map("htmlspecialchars", $_POST);
	
	// Does a query to check if the username inputted is already in the databse
	$blankusername = $conn->prepare("select * from TblUsers where Username = :Username;)");
	$blankusername->bindParam(':Username', $_POST["Username"]);
	$blankusername->execute();

	// Does query have rows returned
	$count = $blankusername->rowCount();
	while ($row = $blankusername->fetch(PDO::FETCH_ASSOC)) {
		echo($row["Username"]."<br>");
	}
	
	if ($count > 0) {
		// The username already exists in the databse
		$_SESSION['LoginFeedback']="4";
		header('Location: user.php');
	}
	else{
		// The username does not exist
		unset($blankusername);

		if ($_POST["Username"]=="") {
			// Checks if the username is blank
			$_SESSION['LoginFeedback']="5";
			// Sends user back to login page
			header('Location: user.php');
		}else{
			// Adds the username and hashed password to the databse
			$hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);
			$stmt = $conn->prepare("INSERT INTO TblUsers (UserID,Username,Password)VALUES (null,:Username,:Password)");
			$stmt->bindParam(':Username', $_POST["Username"]);
			$stmt->bindParam(':Password', $hashed_password);
			$stmt->execute();
			$conn=null;
			// Sends user back to login page
			header('Location: user.php');
		}
	}
?>