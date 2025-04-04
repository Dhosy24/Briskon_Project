<?php 
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
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
            $isSender = ($row['sender'] == $_SESSION['username']); // Check if logged-in user sent the message
            
            if ($isSender) {
                // Sent Messages (Right-aligned)
                echo '
                <div class="d-flex justify-content-end mb-2">
                    <div class=" text-black rounded p-2" style="max-width: 60%; background-color: #DBDCFE;">
                        <p class="mb-1">' . htmlspecialchars($row["message"]) . '</p>
                        <small class="d-block text-end" style="font-size: 10px;">' . date("h:i A", strtotime($row["created_at"])) . '</small>
                    </div>
                </div>';
            } else {
                // Received Messages (Left-aligned) - FIXED Styling
                echo '
                <div class="d-flex justify-content-start mb-2">
                    <div class="text-black rounded p-2" style="max-width: 60%; background-color: #DBDCFE">
                        <p class="mb-1">' . htmlspecialchars($row["message"]) . '</p>
                        <small class="d-block text-start" style="font-size: 10px;">' . date("h:i A", strtotime($row["created_at"])) . '</small>
                    </div>
                </div>';
            }
        }
    }

    // Mark messages as read
    $updateReadMsgs = "UPDATE chat_messages SET is_read = 1 WHERE sender='$sender' AND receiver='$receiver'";
    $conn->query($updateReadMsgs);
}
?>
