<?php
include_once ("connection.php");
//header('Location: login.php');
print_r($_POST);
array_map("htmlspecialchars", $_POST);
$stmt = $conn->prepare("SELECT * FROM tblusers WHERE Username =:Username ;" );
$stmt->bindParam(':Username', $_POST['Username']);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{ 
    if($row['Password']== $_POST['Password']){
        header('Location: placeholder.php');
        
    }else{
        header('Location: user_relogin.php');
    }
}
$conn=null
?>