<?php
include_once("connection.php");

#Database creation command: CREATE database dtbBranch;

header('Location: user.php');

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblVideos;
CREATE TABLE TblVideos 
(VideoID INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
VideoTitle VARCHAR(50) NOT NULL,
Likes INT(10) NOT NULL,
Dislikes INT(10) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblUsers;
CREATE TABLE TblUsers 
(UserID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Username VARCHAR(20) NOT NULL,
Password VARCHAR(500) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblUsersVideos;
CREATE TABLE TblUsersVideos 
(UserID INT(6) NOT NULL,
VideoID INT(9) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblTags;
CREATE TABLE TblTags 
(VideoID INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Tag INT(10) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();
?>
