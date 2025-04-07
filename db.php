<?php

//Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname="actionbr_staging";

$conn= new mysqli($servername,$username,$password,$dbname);


if($conn -> error){
    die("Connection Failed:".$conn->connect_error);
}

?>