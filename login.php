<?php 
session_start();
include('db.php');

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }

}
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container-fluid min-vh-100 bg-black d-flex justify-content-center align-items-center" >
        <div class="d-flex flex-column border border-white bg-white align-items-center rounded-5" style="width: 500px; height: 600px;">
            <div class="d-flex flex-row">
                <img src="pics/download.png" alt="logo" class="pt-3 d-flex align-items-center" style="height: 75px; width: 200px;">
            </div>
            <div class="d-flex flex-column border border-dark bg-black  rounded-5" style="width: 480px; height: 515px;margin-top: 10px;margin-bottom: 10px;">
                <div class="d-flex" style="color: white; padding-left: 25px; padding-top:45px;">
                    <h5>Start for free</h5>
                </div>
                <div class=" space-between" style="color: white; padding-left: 25px; padding-top: 15px; font-size: 35px; font-weight: bold; font-family: poppins ; ">
                    <p>Login</p>
                </div>

                <!-- show login error message here if it doesnt redirect  -->
                <div style="height: 30px; text-align: center; font-size: 18px; margin-top: 10px;">
                    <?php if (isset($error)): ?>
                        <p class="error" style="color: red; margin: 0;"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>
                </div>
                <!-- The error message ends over -->
                <!-- form starts-->
                <form action="" method="post">
                    <div class=" d-flex justify-content-center align-items-center" style="padding-top: 30px;">
                        <input type="text" class=" form-control rounded-5   border border-dark" style="width: 400px;" placeholder="Enter Username" name="username">
                    </div>
                    <div class=" d-flex justify-content-center align-items-center pt-3">
                        <input type="password" class=" form-control rounded-5   border border-dark" style="width: 400px;" placeholder="Enter Password" name="password">
                    </div>
                    <div class=" d-flex justify-content-center align-items-center pt-5">
                        <button id="btn1" type="submit" class=" btn  rounded-5" style="background-color: #007bff; color:white;">Submit</button>
                    </div>
                </form>
                <!-- And form ends here -->

                <div class="d-flex justify-content-center align-items-center pt-1">
                    <div class="d-flex flex-row pt-3" style="color: white;">
                        <p>New User?</p>
                        <a href="Registration.php" class="link-text" style="padding-left: 10px;">Register</a>
                </div>
                </div>                
            </div>
        </div>
    </div>
    <!-- Link to Bootstrap JS (Optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
