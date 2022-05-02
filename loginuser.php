<?php
include_once ("connection.php");
print_r($_POST);
array_map("htmlspecialchars", $_POST);
$hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT * FROM tblusers WHERE Username =:Username ;" );
$stmt->bindParam(':Username', $_POST['Username']);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{ 
    if($row['Password']== $hashed_password){
        //header('Location: placeholder.php');
        echo $_POST["Username"]."<br>";
        echo $hashed_password."<br>";
        
    }else{
        //header('Location: user_relogin.php');
        echo $_POST["Username"]."<br>";
        echo $hashed_password."<br>";
    }
}
$conn=null
?>
