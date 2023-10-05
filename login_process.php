<?php

session_start();
include('config.php');

// Collect form data
$email = $_POST['email'];
$password = $_POST['password'];


$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
       
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: prescription_upload.php"); 
    } else {
        echo "Incorrect password. <a href='login.php'>Try again</a>";
    }
} else {
    echo "User not found. <a href='login.php'>Try again</a>";
}


mysqli_close($conn);
?>
