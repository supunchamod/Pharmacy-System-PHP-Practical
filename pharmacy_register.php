<?php
session_start();
require('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contactNo = $_POST['contactNo'];
    $dob = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

   
    $sql = "INSERT INTO pharmacy_users (name, email, address, contact_no, dob, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $name, $email, $address, $contactNo, $dob, $password);

    if ($stmt->execute()) {
      
        header('Location: pharmacy_login.php');
        exit();
    } else {
        echo "Registration failed: " . $conn->error;
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
                    <h3>Pharmacy Registration Form</h3>
                   
                    <img src="images/12.png" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                    
                        <div class="page-links">
                            <a href="pharmacy_login.php">Login</a><a href="pharmacy_register.php" class="active">Register</a>
                            
                        </div>
                          <form method="POST">
                             <input class="form-control" type="text" id="name" placeholder="Enter name" name="name" required>
                             <input class="form-control" type="email" id="email" placeholder="Enter email" name="email" required>
                             <input class="form-control" type="text" id="address" placeholder="Enter address" name="address" required>
                             <input class="form-control" type="text" id="contact_no" placeholder="Enter contact_no" name="contact_no" required>
                             <input class="form-control" type="date" id="dob" name="dob"  required>
                             <input class="form-control" type="password" id="password" placeholder="Enter password" name="password" required>
                            

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Register</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>


</html>