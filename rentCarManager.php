<?php
session_start(); // Start the session
require_once('db.php.inc.php'); // Assuming this file contains your db connection function
// Include header and navigation after processing PHP logic
include_once('header.html');
include_once('nav.php');
// Check if user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1 && isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Replace with actual username or retrieve from session

    try {
        // Establish database connection
        $pdo = db_connect();

        // Prepare SQL statement to retrieve user type
        $sqlUserType = "SELECT type FROM user_info WHERE username = :username";
        $stmtUserType = $pdo->prepare($sqlUserType);
        $stmtUserType->execute([':username' => $username]);

        // Fetch user type
        $user = $stmtUserType->fetch(PDO::FETCH_ASSOC);
        if ($user && $user['type'] == 'manager') {
            // Query to get cars marked as 'returning' with relevant details
            $query = "SELECT c.id, c.model, c.carmake, c.cartype, r.location, r.fromdate, r.todate, r.name AS customer_name, r.invoice_id, c.status
                      FROM cars AS c
                      INNER JOIN rentinfo AS r ON c.cartype = r.cartype
                      WHERE c.status = 'returning'";
            
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $returningCars = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Handle form submission for updating car status
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['model']) && isset($_POST['carmake']) && isset($_POST['cartype'])) {
                $model = $_POST['model'];
                $carmake = $_POST['carmake'];
                $cartype = $_POST['cartype'];
                $carStatus = $_POST['car_status'];

                // Fetch car ID based on model, carmake, and cartype
                $getCarStmt = $pdo->prepare("SELECT id FROM cars WHERE model = :model AND carmake = :carmake AND cartype = :cartype");
                $getCarStmt->bindValue(':model', $model);
                $getCarStmt->bindValue(':carmake', $carmake);
                $getCarStmt->bindValue(':cartype', $cartype);
                $getCarStmt->execute();
                $car = $getCarStmt->fetch(PDO::FETCH_ASSOC);

                if ($car) {
                    $carID = $car['id'];

                    // Update car status and pickup location in the 'cars' table
                    $updateStmt = $pdo->prepare("UPDATE cars SET status = :car_status WHERE id = :id");
                    $updateStmt->bindValue(':car_status', $carStatus);
                    $updateStmt->bindValue(':id', $carID);
                    $updateStmt->execute();
                } else {
                    $error_message = "Error: Car not found for model: $model, carmake: $carmake, cartype: $cartype";
                }
            }

        } else {
            $error_message = "Only Manager can view this page";
        }

    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
} else {
    $error_message = 'Error: Access denied. Only logged-in users can view this page.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager View - Returning Cars</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <?php
    // Display error message if set
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
        include_once('footer.html');
        exit();
    }
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Model</th>
                <th>Make</th>
                <th>Type</th>
                <th>Location</th>
                <th>From</th>
                <th>To</th>
                <th>Customer Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (isset($returningCars) && !empty($returningCars)) {
            foreach ($returningCars as $car) {
                echo "<tr>";
                echo "<td>" . ($car['model']) . "</td>";
                echo "<td>" . ($car['carmake']) . "</td>";
                echo "<td>" . ($car['cartype']) . "</td>";
                echo "<td>" . ($car['location']) . "</td>";
                echo "<td>" . ($car['fromdate']) . "</td>";
                echo "<td>" . ($car['todate']) . "</td>";
                echo "<td>" . ($car['customer_name']) . "</td>";
                echo "<td>" . ($car['status']) . "</td>";
                echo "<td>
                        <form action='" . $_SERVER['PHP_SELF'] . "' method='post' class='update-form';>
                            <input type='hidden' name='model' value='" . ($car['model']) . "'>
                            <input type='hidden' name='carmake' value='" . ($car['carmake']) . "'>
                            <input type='hidden' name='cartype' value='" . ($car['cartype']) . "'>
                            <input type='hidden' name='invoice_id' value='" . ($car['invoice_id']) . "'>
                            <div class='returnform'>
                                <select name='car_status' required>
                                    <option value='available' " . ($car['status'] == 'available' ? 'selected' : '') . ">Available</option>
                                    <option value='damaged' " . ($car['status'] == 'damaged' ? 'selected' : '') . ">Damaged</option>
                                    <option value='repair' " . ($car['status'] == 'repair' ? 'selected' : '') . ">In Repair</option>
                                </select>
                                <button type='submit'>Update Status</button>
                                </div>
                           
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No cars are marked as returning.</td></tr>";
        }
        ?>
        </tbody>
    </table>

<?php include_once('footer.html');?>
</body>
</html>
