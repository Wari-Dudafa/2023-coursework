<?php
    include_once("connection.php");

    // Database creation command: "CREATE database dtbBranch"

    // Creates the table for the video data to be stored in
    $TblVideos = $conn->prepare("DROP TABLE IF EXISTS TblVideos;
    CREATE TABLE TblVideos 
    (VideoID INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    VideoTitle VARCHAR(250) NOT NULL,
    FileName VARCHAR(250) NOT NULL,
    Location VARCHAR(250) NOT NULL,
    FileName_thumbnail VARCHAR(250) NOT NULL,
    Location_thumbnail VARCHAR(250) NOT NULL,
    Tag INT(2) NOT NULL,
    UserID INT(10) NOT NULL)");
    $TblVideos->execute();
    $TblVideos->closeCursor();

    // Creates the table for the user data to be stored in
    $TblUsers = $conn->prepare("DROP TABLE IF EXISTS TblUsers;
    CREATE TABLE TblUsers 
    (UserID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(20) NOT NULL,
    Password VARCHAR(500) NOT NULL)");
    $TblUsers->execute();
    $TblUsers->closeCursor();

    // Creates the table for like information and watch history to be stored in
    $TblData = $conn->prepare("DROP TABLE IF EXISTS TblData;
    CREATE TABLE TblData 
    (UserID INT(6) NOT NULL,
    VideoID INT(9) NOT NULL,
    LikeIndicator Int(1) NOT NULL)");
    $TblData->execute();
    $TblData->closeCursor();

    // Creates the table for the comments to be stored in
    $TblComments = $conn->prepare("DROP TABLE IF EXISTS TblComments;
    CREATE TABLE TblComments 
    (UserID INT(6) NOT NULL,
    VideoID INT(9) NOT NULL,
    Comment VARCHAR(250) NOT NULL)");
    $TblComments->execute();
    $TblComments->closeCursor();

    // Once the tables are made then go to the login page
    header('Location: user.php');
?>