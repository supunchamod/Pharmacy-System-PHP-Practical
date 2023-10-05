<?php
session_start();
require('config.php');

// Check if the user is logged in as a pharmacy user
if (!isset($_SESSION['user_id'])) {
    header('Location: pharmacy_login.php');
    exit();
}

// Check if the prescription ID is provided as a query parameter
if (isset($_GET['id'])) {
    $prescriptionId = $_GET['id'];

    // Retrieve prescription details
    $sql = "SELECT * FROM prescriptions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $prescriptionId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the prescription exists
    if ($result->num_rows === 0) {
        echo "Prescription not found.";
        exit();
    }

    $row = $result->fetch_assoc();
} else {
    echo "Prescription ID is missing.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row text-center" style="margin-bottom: 30px;">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1>View Prescription</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Prescription ID: <?php echo $row['id']; ?></h5>
                    <p class="card-text">User ID: <?php echo $row['user_id']; ?></p>
                    <p class="card-text">Note: <?php echo $row['note']; ?></p>
                    <p class="card-text">Delivery Address: <?php echo $row['delivery_address']; ?></p>
                    <p class="card-text">Delivery Time Slot: <?php echo $row['delivery_time']; ?></p>
                    <h6 class="card-subtitle mb-2 text-muted">Images:</h6>
                    <div class="row">
                        <?php
                        $images = explode(',', $row['images']);
                        foreach ($images as $image) {
                            echo "<div class='col-md-4'><img src='images/$image' class='img-thumbnail'></div>";
                        }
                        ?>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted">Drug Details:</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Drug</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="drug-list">
                            <!-- Existing drug details rows -->
                            <tr>
                                <td>Amoxicillin 250mg</td>
                                <td>5</td>
                                <td>50.00</td>
                            </tr>
                            <tr>
                                <td>Paracetamol 500mg</td>
                                <td>5</td>
                                <td>25.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td id="total-amount">75.00</td>
                            </tr>
                        </tfoot>
                    </table>
                    <h6 class="card-subtitle mb-2 text-muted">Add Drug:</h6>
                    <div class="input-group" style=" margin-bottom: 30px; ">
                        <input type="text" id="new-drug-name" class="form-control" placeholder="Drug Name">
                        <input type="number" id="new-quantity" class="form-control" placeholder="Quantity">
                        <button type="button" class="btn btn-primary" id="add-drug">Add</button>
                    </div>

                    <a href="generate_quotation.php"<button type="button" class="btn btn-primary" id="add-drug" style="text-align: right;">Send Quotation</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    document.getElementById('add-drug').addEventListener('click', function() {
        const drugNameInput = document.getElementById('new-drug-name');
        const quantityInput = document.getElementById('new-quantity');
        const drugList = document.getElementById('drug-list');
        
        const drugName = drugNameInput.value.trim();
        const quantity = parseInt(quantityInput.value);

        if (drugName === '' || isNaN(quantity) || quantity <= 0) {
            alert('Please enter a valid drug name and quantity.');
            return;
        }

        // Add a new row for the added drug
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${drugName}</td>
            <td>${quantity}</td>
            <td>$${(quantity * 5).toFixed(2)}</td>
        `;

        drugList.appendChild(newRow);

        // Clear input fields
        drugNameInput.value = '';
        quantityInput.value = '';

        // Update the total amount
        updateTotalAmount();
    });

    function updateTotalAmount() {
        const quantityFields = document.querySelectorAll('td:nth-child(2)');
        let totalAmount = 0;
        quantityFields.forEach(function(field) {
            const quantity = parseInt(field.textContent);
            totalAmount += quantity * 5;
        });
        document.getElementById('total-amount').textContent = `$${totalAmount.toFixed(2)}`;
    }
</script>
</body>
</html>
