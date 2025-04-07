<?php
session_start();
include('db.php');

if(isset($_SESSION['f_name'])){
    header("Location:index.php");
    exit();
}


if($_SERVER["REQUEST_METHOD"]=="POST"){

    $f_name = $_POST['username'];
    $password = $_POST['password'];


     // check if the user is already there

     $stmt = $conn->prepare("SELECT * from employees WHERE f_name =?");
     $stmt->bind_param("s",$f_name);
     $stmt->execute();
     $result = $stmt->get_result();

     if($result->num_rows>0){
        $error = "User name already exists";
     }
     else{
        $stmt = $conn->prepare("INSERT INTO employees(f_name,password) VALUES(?,?)");
        $stmt->bind_param("ss",$f_name,$password);
        if($stmt->execute()){
            $_SESSION['f_name']= $f_name;
            header("Location:index.php");
        }else{
            $error = "Registration failed";
        }
     }
     $stmt->close();
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container-fluid min-vh-100 bg-black d-flex justify-content-center align-items-center">
        <div class="d-flex flex-column border border-white bg-white align-items-center rounded-5" style="width: 500px; height: 600px;">
            <div class="d-flex flex-row">
                <img src="pics/download.png" alt="logo" class="pt-3 d-flex align-items-center" style="height: 75px; width: 200px;">
            </div>

            <form method="POST" class="d-flex flex-column border border-dark bg-black rounded-5" 
                style="width: 480px; height: 515px; margin-top: 10px; margin-bottom: 10px; padding: 20px;">

                <div class="d-flex pt-2" style="color: white;">
                    <h5>Start for free</h5>
                </div>

                <div class="space-between pt-3" style="color: white; font-size: 35px; font-weight: bold;">
                    <p>Create Your Account</p>
                </div>

                <?php if (!empty($error_message)) { ?>
                    <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                <?php } ?>

                <div class="d-flex justify-content-center align-items-center pt-4">
                    <input type="text" name="username" class="form-control rounded-5 border border-dark" 
                        style="width: 400px;" placeholder="Enter Username" required>
                </div>

                <div class="d-flex justify-content-center align-items-center pt-4">
                    <input type="password" name="password" class="form-control rounded-5 border border-dark" 
                        style="width: 400px;" placeholder="Enter Password" required>
                </div>

                <div class="d-flex justify-content-center align-items-center pt-5">
                    <button type="submit" name="register" class="btn btn-primary rounded-5">Sign Up</button>
                </div>

                <div class="d-flex justify-content-center align-items-center pt-1">
                    <div class="d-flex flex-row pt-3" style="color: white;">
                        <p>Already have an account?</p>
                        <a href="login.php" class="link-text" style="padding-left: 10px;">Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
