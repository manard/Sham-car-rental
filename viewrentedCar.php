<?php
session_start(); // Start the session
require_once('db.php.inc.php'); // Assuming this file contains your db connection function
include_once('header.html');
include_once('nav.php');

try {
    // Establish database connection
    $pdo = db_connect();

    // Query to fetch rented car information sorted by statuses (future, current, past)
    $stmt = $pdo->prepare("SELECT invoice_id, fromdate, todate, location, model, cartype, statuses 
                           FROM rentinfo 
                           ORDER BY CASE 
                                      WHEN statuses = 'future' THEN 1 
                                      WHEN statuses = 'current' THEN 2 
                                      WHEN statuses = 'past' THEN 3 
                                      ELSE 4 
                                   END, fromdate DESC");
    $stmt->execute();
    $rentedCars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rented Cars</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Invoice Date</th>
                <th>Car Type</th>
                <th>Car Model</th>
                <th>Pick-up Date</th>
                <th>Pick-up Location</th>
                <th>Return Date</th>
                <th>Return Location</th>
                <th>uses Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rentedCars as $car): ?>
                <tr class="<?php echo strtolower($car['statuses']); ?>">
                    <td><?php echo $car['invoice_id']; ?></td>
                    <td><?php echo $car['fromdate']; ?></td>
                    <td><?php echo $car['cartype']; ?></td>
                    <td><?php echo $car['model']; ?></td>
                    <td><?php echo $car['fromdate']; ?></td>
                    <td><?php echo $car['location']; ?></td>
                    <td><?php echo $car['todate']; ?></td>
                    <td><?php echo $car['location']; ?></td>
                    <td><?php echo $car['statuses']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php include_once('footer.html');?>


