<?php
session_start();
include_once ("connection.php");
print_r($_POST)."<br>";
array_map("htmlspecialchars", $_POST);
$hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT, ['cost' => 15]);

$stmt = $conn->prepare("SELECT * FROM tblusers WHERE Username =:Username ;" );
$stmt->bindParam(':Username', $_POST['Username']);
$stmt->execute();
header('Location: user.php');
$_SESSION['LoginFeedback']="2";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{ 
    //if($row['Password'] == $hashed_password){
    if(password_verify($_POST["Password"], $row['Password'])){
        $_SESSION['CurrentUser']=$row["Username"];
        header('Location: placeholder.php');
        echo "Success<br>";
        echo $_POST["Username"]."<br>";
        echo $hashed_password."<br>";
        
    }else{
        header('Location: user.php');
        $_SESSION['LoginFeedback']="6";
        echo "Fail<br>";
        echo $_POST["Username"]."<br>";
        echo $hashed_password."<br>";
    }
}

$conn=null

?>
