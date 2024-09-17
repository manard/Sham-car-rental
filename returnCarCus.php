<?php
session_start(); // Start the session
require_once('db.php.inc.php'); // Assuming this file contains your db connection function
include_once('header.html');
include_once('nav.php');

// Check if user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1 && isset($_SESSION['ID'])) {
    $ID = $_SESSION['ID'];
    $name = $_SESSION['name'];

    try {
        // Establish database connection
        $pdo = db_connect();

        // Query to get cars rented by the customer
        $query = "SELECT model, carmake, cartype, location, fromdate, todate, invoice_id FROM rentinfo WHERE ID = :ID";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':ID', $ID);
        $stmt->execute();
        $rentedCars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Handle return action
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['invoice_id'])) {
            $invoiceID = $_POST['invoice_id'];

            // Fetch car details to get carID
            $getCarStmt = $pdo->prepare("SELECT id FROM cars WHERE model = :model AND carmake = :carmake AND cartype = :cartype");
            $getCarStmt->bindValue(':model', $_POST['model']); // Adjust according to how you're posting model, carmake, cartype
            $getCarStmt->bindValue(':carmake', $_POST['carmake']);
            $getCarStmt->bindValue(':cartype', $_POST['cartype']);
            $getCarStmt->execute();
            $car = $getCarStmt->fetch(PDO::FETCH_ASSOC);

            if ($car) {
                $carID = $car['id'];

                // Update car status to 'returning'
                $updateStmt = $pdo->prepare("UPDATE cars SET status = 'returning' WHERE id = :id");
                $updateStmt->bindValue(':id', $carID);
               // $updateStmt->bindValue(':return_location', $return_location); // Provide the return location here
                $updateStmt->execute();
            } else {
                echo "Error: Car not found for model: {$_POST['model']}, carmake: {$_POST['carmake']}, cartype: {$_POST['cartype']}";
            }
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo 'Error: User not logged in or missing user ID.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rented Cars</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Model</th>
                <th>Make</th>
                <th>Type</th>
                <th>Location</th>
                <th>From</th>
                <th>To</th>
                <th>Invoice ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($rentedCars) {
            foreach ($rentedCars as $car) {
                echo "<tr>";
                echo "<td>" . ($car['model']) . "</td>";
                echo "<td>" . ($car['carmake']) . "</td>";
                echo "<td>" . ($car['cartype']) . "</td>";
                echo "<td>" . ($car['location']) . "</td>";
                echo "<td>" . ($car['fromdate']) . "</td>";
                echo "<td>" . ($car['todate']) . "</td>";
                echo "<td>" . ($car['invoice_id']) . "</td>";
                echo "<td>
                    <form action='" . ($_SERVER['PHP_SELF']) . "' method='post' class='update-form';'>
                        <input type='hidden' name='model' value='" . ($car['model']) . "'>
                        <input type='hidden' name='carmake' value='" . ($car['carmake']) . "'>
                        <input type='hidden' name='cartype' value='" . ($car['cartype']) . "'>
                        <input type='hidden' name='invoice_id' value='" . ($car['invoice_id']) . "'>
                        <button type='submit'>Return</button>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>You have not rented any cars.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>
<?php include_once('footer.html'); ?>
