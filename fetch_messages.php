<?php 
session_start();
include('db.php');

if (!isset($_SESSION['f_name'])) {
    exit("You are not logged in");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

    $sql = "SELECT * FROM chat_messages 
            WHERE (sender='$sender' AND receiver='$receiver') 
               OR (sender='$receiver' AND receiver='$sender') 
            ORDER BY created_at";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $isSender = ($row['sender'] == $_SESSION['f_name']); // Check if logged-in user sent the message
            
            if ($isSender) {
                // Sent Messages (Right-aligned)
                echo '
                <div class="d-flex justify-content-end pe-3 mb-3">
                    <div class=" text-white rounded p-2" style="max-width: 60%; background-color:rgb(159, 128, 208);">
                        <p class="mb-1">' . htmlspecialchars($row["message"]) . '</p>
                        <small class="d-block text-end" style="font-size: 10px;">' . date("h:i A", strtotime($row["created_at"])) . '</small>
                    </div>
                </div>';
            } else {
                // Received Messages (Left-aligned)     
                echo '
                <div class="d-flex justify-content-start ps-3 mb-3">
                    <div class="text-white rounded p-2 " style="max-width: 60%; background-color:rgb(159, 128, 208);">
                        <p class="mb-1">' . htmlspecialchars($row["message"]) . '</p>
                        <small class="d-block text-start" style="font-size: 10px;">' . date("h:i A", strtotime($row["created_at"])) . '</small>
                    </div>
                </div>';
            }
        }
    }

 
}
?>
