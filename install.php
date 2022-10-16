<?php
include_once("connection.php");

#Database creation command: CREATE database dtbBranch;

header('Location: user.php');

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblVideos;
CREATE TABLE TblVideos 
(VideoID INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
VideoTitle VARCHAR(250) NOT NULL,
FileName VARCHAR(250) NOT NULL,
Location VARCHAR(250) NOT NULL,
FileName_thumbnail VARCHAR(250) NOT NULL,
Location_thumbnail VARCHAR(250) NOT NULL,
UserID INT(10) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblUsers;
CREATE TABLE TblUsers 
(UserID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Username VARCHAR(20) NOT NULL,
Password VARCHAR(500) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblData;
CREATE TABLE TblData 
(UserID INT(6) NOT NULL,
VideoID INT(9) NOT NULL,
LikeIndicator Int(1) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblComments;
CREATE TABLE TblComments 
(UserID INT(6) NOT NULL,
VideoID INT(9) NOT NULL,
Comment VARCHAR(250) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();

$stmt = $conn->prepare("DROP TABLE IF EXISTS TblTags;
CREATE TABLE TblTags 
(VideoID INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Tag INT(10) NOT NULL)");
$stmt->execute();
$stmt->closeCursor();
?>