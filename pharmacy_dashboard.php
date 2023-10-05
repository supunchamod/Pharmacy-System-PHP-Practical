<?php
session_start();
require('config.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: pharmacy_login.php');
    exit();
}


$pharmacyUserId = $_SESSION['user_id'];
$sql = "SELECT * FROM prescriptions WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $pharmacyUserId);
$stmt->execute();
$result = $stmt->get_result();

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacy Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>

  <div class="container">
    <div class="row text-center" style="margin-bottom: 100px;">
        <div class="col-lg-12 col-md-12 col-sm-12">
        <h1>Welcome, Pharmacy User!</h1>
        <h2>Uploaded Prescriptions</h2>
        </div>
    </div>
    <div class="row">
        
    <table  class="table">
        <thead>
            <tr>
                <th scope="col">Prescription ID</th>
                <th scope="col">User ID</th>
                <th scope="col">Note</th>
                <th scope="col">Delivery Address</th>
                <th scope="col">Delivery Time Slot</th>
                <th scope="col">Images</th>
                <th scope="col">action</th>

            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['note']; ?></td>
                    <td><?php echo $row['delivery_address']; ?></td>
                    <td><?php echo $row['delivery_time']; ?></td>
                    <td>
                        <?php
                        $images = explode(',', $row['images']);
                        foreach ($images as $image) {
                            echo "<img src='images/$image' width='100' height='100'>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="view_prescription.php?id=<?php echo $row['id']; ?>">
                            <button class="btn btn-success">View</button>
                        </a>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>

    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>