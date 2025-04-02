<?php
session_start(); // Start session once at the beginning
include("db.php");

// Redirect if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$user = isset($_GET['user']) ? ucfirst($_GET['user']) : "Default User";
$selectedImage = isset($_GET['image']) ? $_GET['image'] : "pics/default.png";

$username = $_SESSION['username']; // Username is already set
$selectedUser='';


    if (isset($_GET['user'])) {
        $selectedUser = $_GET['user'];
        $selectedUser = mysqli_real_escape_string($conn, $selectedUser);
    } else {
        $selectedUser = "Select a User"; // Default if no user is selected
    }



// SQL query to get all users except the logged-in user

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS (Latest Version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid min-vh-100 m-0 overflow:hidden bg-black">
        <div class="row h-100">
            <!-- list View -->
            <div class="col-md-2 col-sm-4 col-12 sidebar p-3 d-flex flex-column h-100 align-items-center  rounded-2 border border-dark">
                <img src="Pics/briskon-logo-1-1.png" alt="Briskon-logo" class="image-fluid pt-2" style="width: 60%;"><hr class="bg-black w-75">

                <ul class="list-group list-unstyled gap-2 d-flex flex-column align-items-center w-100 hover fs-6">
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-tv custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Dashboard</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-bullhorn custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Announcements</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-user custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Employee Details</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-address-book custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Employee Directory</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-book-open custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">My Attendance</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-plane-departure custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Apply Leave</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-clock custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Leave History</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-chart-line custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">My Projects</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-calendar custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Holiday List</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100" id="chat-menu">
                        <i class="fa-solid fa-comments custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Chats</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fas fa-file-alt custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">Documents</span>
                    </li>
                    <li class="p-2 fw-bold d-flex align-items-center gap-3 w-100">
                        <i class="fa-solid fa-user-circle custom-10"></i> 
                        <span class="m-0 p-0 text-start custom-90">My Accounts</span>
                    </li>
                </ul>                
            </div>

            <div class="col-md-3 col-sm-4 col-12 sidebar p-3  d-flex flex-row align-items-center  flex-grow-1  rounded-2 border border-dark"style="height: 100px;">
                <div class="d-flex flex-column m-0  p-3 rounded-4 h-100 w-25" style="align-self: flex-start;">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="basic-addon1" style="background-color: #DBDCFE;">
                            <i class="fas fa-search"></i> <!-- Font Awesome search icon -->
                        </span>
                        <input type="text" class="form-control custom-input" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                    
                    <div class="icon-container text-center mt-10px d-flex justify-content-evenly align-items-center w-100 mt-2">
                        <i class="fas fa-users"></i>
                        <i class="fas fa-trash"></i>
                        <i class="fas fa-bars"></i>
                    </div>

                   <!-- User List Section -->
                   <div id="user-list">
                   <ul class="list-group list-group-flush" style="max-height: 525px; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none; ">
                        <?php
                        // Query: Fetch all users except the logged-in user
                        $sql = "SELECT username FROM users WHERE username != '$username'";
                        $result = $conn->query($sql);

                        // Get available images
                        $imageFiles = glob("pics/*.{png,jpg,jpeg,gif}", GLOB_BRACE);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $userItem = ucfirst($row['username']);
                                
                                // Ensure there is at least one image
                                if (count($imageFiles) > 0) {
                                    // Compute a consistent index using md5 hash
                                    $index = hexdec(substr(md5($userItem), 0, 8)) % count($imageFiles);
                                    $assignedImage = $imageFiles[$index];
                                } else {
                                    $assignedImage = "Pics/default.png";
                                }

                                echo "<li class='list-group-item mb-2 p-2 rounded hover-effect' style='background-color: #EEEFFA;'>
                                        <a href='index.php?user=" . urlencode($userItem) . "&image=" . urlencode($assignedImage) . "' 
                                        class='text-dark text-decoration-none d-block'>
                                            <div class='d-flex align-items-center'>
                                                <img src='$assignedImage' alt='$userItem' class='rounded-circle me-3' style='width: 40px; height: 40px; object-fit: cover; border: 2px solid #d1d1ff;'>
                                                <div class='d-flex flex-column'>
                                                    <h6 class='mb-0 fw-bold'>$userItem</h6>
                                                    <p class='text-muted mb-0'>
                                                        <i class='fas fa-circle text-success' style='font-size: 10px;'></i> Online
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>";
                            }
                        } else {
                            echo "<li class='list-group-item'>No users available</li>";
                        }
                        ?>
                    </ul>

                    </div>




                </div>
                
                <!-- this is the third division the chat -->
                <div class="d-flex flex-column m-0  back  p-3 rounded-4 h-100 ms-2 flex-grow-1 chat-box" style="align-self: flex-start; background-color:aliceblue;" id="chat-box">
                    <!-- Add content for the header  div -->
                    <div id="chat-header" class="d-flex align-items-center justify-content-between gap-3 rounded-3" style="background-color: #DBDCFE; padding: 10px;">
                    <!-- Left-side content -->
                        <div class="d-flex align-items-center gap-3">
                            <img id="chat-image" src="<?php echo htmlspecialchars($selectedImage); ?>" alt="Profile-pic" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            <div class="d-flex flex-column">
                            <h1 id="chat-name" class="mb-0 fw-bold">
                                <?php 
                                    echo htmlspecialchars($selectedUser); 
                                ?>
                            </h1>
                            </div>
                        </div>
                
                            <!-- Right-side logout button -->
                        <div class="dropdown">
                            <button class="btn btn-light " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none;">
                                <i class="fas fa-ellipsis-v" style="font-size: 24px; cursor: pointer;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                                    
                <!-- chat View area -->
                <div id="chat-view" class="flex-grow-1 overflow-auto p-2 border rounded chat-view" style="height: 300px; background-color: #f8f9fa;">
                    <!-- Messages will be dynamically added here --> 
                </div>
            
                    <!-- footer section which contains input field -->
                    <form id="chat-form" method="POST">
                        <footer class="mt-auto" id="mt-auto">
                            <div class="d-flex align-items-center p-2 w-100" style="background-color: #f8f9fa; border-top: 1px solid #ddd;">
                                <input type="hidden" id="sender" name="sender" value="<?php echo $username?>">
                                <input type="hidden" id="receiver" name="receiver" value="<?php echo $selectedUser?>">
                                <!-- File Upload Icon (Same Height as Input) -->
                                <span class="input-group-text d-flex align-items-center justify-content-center p-2" style="background-color: #DBDCFE; border-radius: 20px 0 0 20px; height: 40px;">
                                    <label for="file-upload" class="mb-0">
                                        <i class="fas fa-paperclip" style="cursor: pointer;"></i>
                                    </label>
                                    <input type="file" id="file-upload" class="d-none">
                                </span>

                                <!-- Message Input Field (Single Line) -->
                                <input type="text" id="message" name="message" class="form-control inp flex-grow-1 border-0" placeholder="Type a message..."
                                    style="border-radius: 0; outline: none; height: 40px;">

                                <!-- Send Button (Same Height as Input) -->
                                <button id="send-btn" class="btn d-flex align-items-center justify-content-center p-2" type="submit"
                                        style="background-color: #DBDCFE; border-radius: 0 20px 20px 0; height: 40px;">
                                    <i class="fas fa-paper-plane"></i>
                                </button>

                            </div>
                        </footer>
                    </form>




                                
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- Bootstrap JavaScript (For Components Like Dropdowns, Modals, etc.) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>
</body>
</html> 
