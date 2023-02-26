<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "root";
$dbName = "ptiwiki";
$conn = new mysqli($dbHost, $dbUser, $dbPassword);


//add manager and users
$p = password_hash('m', PASSWORD_DEFAULT);
$addManager = "INSERT INTO users (username, compte, password)
VALUES ('manager', 'manager', '$p');
";
$p1 = password_hash('u1', PASSWORD_DEFAULT);
$addUser1 = "INSERT INTO users (username, compte, password)
VALUES ('user1', 'user', '$p1');
";
$p2 = password_hash('u2', PASSWORD_DEFAULT);
$addUser2 = "INSERT INTO users (username, compte, password)
VALUES ('user2', 'user', '$p2');
";
$p3 = password_hash('u3', PASSWORD_DEFAULT);
$addUser3 = "INSERT INTO users (username, compte, password)
VALUES ('user3', 'user', '$p3');
";



if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// if database doesn't exist, create it
if (!mysqli_select_db($conn, $dbName)){
    $db_sql = "CREATE DATABASE ".$dbName;
    mysqli_query($conn, $db_sql);
    header("Location: logout.php");
} 


// create users table
$tbl_sql = "CREATE TABLE IF NOT EXISTS users(
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(100) NOT NULL,
    compte VARCHAR(40) NOT NULL,  
    password CHAR(60) NOT NULL)";


if(!mysqli_query($conn,"DESCRIBE users")) {
    mysqli_query($conn, $tbl_sql);
    mysqli_query($conn, $addManager);
    mysqli_query($conn, $addUser1);
    mysqli_query($conn, $addUser2);
    mysqli_query($conn, $addUser3);
}