<?php
session_start();
require('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM pharmacy_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
           
            $_SESSION['pharmacy_user_id'] = $row['id'];
            $_SESSION['pharmacy_user_name'] = $row['name'];
            header('Location: pharmacy_dashboard.php');
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Practical Exam
Paper C</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme9.css">
</head>
<body>
    <div class="form-body">
        <div class="row">
        <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <h3>Pharmacy Login Form</h3>
                   
                    <img src="images/12.png" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <div class="website-logo-inside">
                            
                        </div>
                        <div class="page-links">
                            <a href="pharmacy_login.php" class="active">Login</a><a href="pharmacy_register.php">Register</a>
                        </div>
                        <form method="POST">
                            <input class="form-control" type="text" name="email" placeholder="E-mail Address" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> <a href="forget9.html">Forget password?</a>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>


</html>