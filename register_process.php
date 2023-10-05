<?php

include('config.php');

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$contact_no = $_POST['contact_no'];
$dob = $_POST['dob'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 


$sql = "INSERT INTO users (name, email, address, contact_no, dob, password) VALUES ('$name', '$email', '$address', '$contact_no', '$dob', '$password')";


if (mysqli_query($conn, $sql)) {
    echo "Registration successful. You can now log in.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
