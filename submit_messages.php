<?php 
session_start();
include('db.php');

if(!isset($_SESSION['f_name'])){
    exit("You are not logged in");
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];

    $sql = "INSERT INTO chat_messages (sender,receiver,message) VALUES ('$sender','$receiver','$message')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]); // Send success response
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]); // Send error response
    }

    $conn->close();
}
?>
