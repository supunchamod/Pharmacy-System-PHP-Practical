<?php
session_start();
require('config.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $note = $_POST['note'];
    $deliveryAddress = $_POST['deliveryAddress'];
    $deliveryTimeSlot = $_POST['deliveryTimeSlot'];


    $uploadDir = 'images/';
    $uploadedImages = [];
    

    for ($i = 0; $i < min(count($_FILES['images']['name']), 5); $i++) {
        $imageName = $_FILES['images']['name'][$i];
        $targetFilePath = $uploadDir . $imageName;
        
        if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFilePath)) {
            $uploadedImages[] = $imageName;
        }
    }

    $sql = "INSERT INTO prescriptions (user_id, note, delivery_address, delivery_time, images) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issss', $userId, $note, $deliveryAddress, $deliveryTimeSlot, implode(',', $uploadedImages));

    if ($stmt->execute()) {
    
        header('Location: prescription_upload.php?success=1');
        exit();
    } else {
        echo "Prescription upload failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Upload</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme26.css">
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="images/13.png" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <h2>Prescription Upload</span></h2>
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Prescription Upload</h3>
                        <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p style='color: green;'>Prescription uploaded successfully!</p>";
    }
    ?>
    <form method="POST" enctype="multipart/form-data">
    <div class="form-row">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Delivery Address" name="deliveryAddress" required>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="deliveryTimeSlot">Delivery Time Slot:</label>
            <select name="deliveryTimeSlot" id="deliveryTimeSlot" required>
                <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                <option value="2:00 PM - 4:00 PM">2:00 PM - 4:00 PM</option>
                <option value="6:00 PM - 8:00 PM">6:00 PM - 8:00 PM</option>
            </select>
        </div>
    </div>

    <div class="form-row">
    <div class="col">
        
        <input type="file" class="form-control" name="images[]" accept="image/*" multiple required
               onchange="limitFiles(this, 5);">
    </div>
</div>

    <div class="form-row">
        <div class="col">
            <textarea class="form-control" name="note" placeholder="Note..."></textarea>
        </div>
    </div>
    
    <div class="form-button">
        <button id="submit" type="submit" class="ibtn extra-padding">Send message</button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

function limitFiles(input, maxFiles) {
    if (input.files.length > maxFiles) {
        alert("You can only upload a maximum of " + maxFiles + " images.");
        input.value = ''; 
    }
}
</script>


</body>


</html>

