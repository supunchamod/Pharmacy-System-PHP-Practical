<?php
session_start();
require('config.php');

// Check if the user is logged in as a pharmacy user
if (!isset($_SESSION['user_id'])) {
    header('Location: pharmacy_login.php');
    exit();
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract prescription data from the form
    $user_id = $_SESSION['user_id'];
    $note = $_POST['note'];
    $delivery_address = $_POST['delivery_address'];
    $delivery_time = $_POST['delivery_time'];
    $images = implode(',', $_POST['images']); // Assuming images is an array of filenames

    // Insert prescription data into the 'prescriptions' table
    $sql = "INSERT INTO prescriptions (user_id, note, delivery_address, delivery_time, images)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issss', $user_id, $note, $delivery_address, $delivery_time, $images);

    if ($stmt->execute()) {
        $prescription_id = $stmt->insert_id; // Get the generated prescription ID

        // Insert drug details into the 'prescription_details' table
        foreach ($_POST['drug'] as $key => $drug) {
            $quantity = $_POST['quantity'][$key];
            $amount = $quantity * 5.00; // Assuming a fixed amount per unit

            $sql = "INSERT INTO prescription_details (prescription_id, drug_name, quantity, amount)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isdd', $prescription_id, $drug, $quantity, $amount);
            $stmt->execute();
        }

        // Calculate the total amount and update it in the 'prescriptions' table
        $sql = "UPDATE prescriptions SET total_amount = (
                SELECT SUM(amount) FROM prescription_details WHERE prescription_id = ?
            ) WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $prescription_id, $prescription_id);
        $stmt->execute();

        // Redirect to a success page
        header('Location: success_page.php');
        exit();
    } else {
        // Error occurred while saving data
        echo "Error: " . $stmt->error;
    }
}
?>
<!-- Your HTML form goes here -->
