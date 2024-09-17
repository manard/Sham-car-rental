<?php
session_start(); // Start the session

include_once('header.html');
include_once('nav.php');
require_once('db.php.inc.php');



// Check if user is logged in and is a manager
if (!isset($_SESSION['username'])) {
    $error_message = "You must be logged in to access this page";
} else {
    $username = $_SESSION['username']; // Replace with actual username or retrieve from session

    // Connect to database
    $pdo = db_connect(); // Replace with your database connection function

    // Retrieve user type from the database based on the logged-in user
    $sqlUserType = "SELECT type FROM user_info WHERE username = :username";
    $stmtUserType = $pdo->prepare($sqlUserType);
    $stmtUserType->execute([':username' => $username]);
    $user = $stmtUserType->fetch(PDO::FETCH_ASSOC);

    if (!$user || $user['type'] !== 'manager') {
        $error_message = "Only Manager can view this page";
    } 
        // Form processing logic
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user['type'] !== 'manager') {
            // Check if all required fields are set
            if (
                isset($_POST['model']) &&
                isset($_POST['carmake']) &&
                isset($_POST['cartype']) &&
                isset($_POST['year']) &&
                isset($_POST['desc']) &&
                isset($_POST['fuel']) &&
                isset($_POST['price']) &&
                isset($_POST['peoplecapacity']) &&
                isset($_POST['suitcapacity']) &&
                isset($_POST['color']) &&
                isset($_POST['avgP']) &&
                isset($_POST['horsepower']) &&
                isset($_POST['length']) &&
                isset($_POST['width']) &&
                isset($_POST['photo1']) &&
                isset($_POST['photo2']) &&
                isset($_POST['photo3']) &&
                isset($_POST['plateNumber'])
            ) {
                $model = $_POST['model'];
                $carmake = $_POST['carmake'];
                $cartype = $_POST['cartype'];
                $year = $_POST['year'];
                $desc = $_POST['desc'];
                $fuel = $_POST['fuel'];
                $price = $_POST['price'];
                $peoplecapacity = $_POST['peoplecapacity'];
                $suitcapacity = $_POST['suitcapacity'];
                $color = $_POST['color'];
                $avgP = $_POST['avgP'];
                $horsepower = $_POST['horsepower'];
                $length = $_POST['length'];
                $width = $_POST['width'];
                $photo1 = $_POST['photo1'];
                $photo2 = $_POST['photo2'];
                $photo3 = $_POST['photo3'];
                $plateNumber = $_POST['plateNumber'];
                $status = 'available';

                // Prepare the SQL query
                $sql = "INSERT INTO cars (model, carmake, cartype, year, description, price, peoplecapacity, suitcasescapacity, color, avgpet, horsepower, length, width, photo1, photo2, photo3, plateNumber, fuel, status) 
                        VALUES (:model, :carmake, :cartype, :year, :description, :price, :peoplecapacity, :suitcasescapacity, :color, :avgpet, :horsepower, :length, :width, :photo1, :photo2, :photo3, :plateNumber, :fuel, :status)";

                $statement = $pdo->prepare($sql);
                $statement->bindValue(':model', $model);
                $statement->bindValue(':carmake', $carmake);
                $statement->bindValue(':cartype', $cartype);
                $statement->bindValue(':year', $year);
                $statement->bindValue(':description', $desc);
                $statement->bindValue(':fuel', $fuel);
                $statement->bindValue(':price', $price);
                $statement->bindValue(':peoplecapacity', $peoplecapacity);
                $statement->bindValue(':suitcasescapacity', $suitcapacity);
                $statement->bindValue(':color', $color);
                $statement->bindValue(':avgpet', $avgP);
                $statement->bindValue(':horsepower', $horsepower);
                $statement->bindValue(':length', $length);
                $statement->bindValue(':width', $width);
                $statement->bindValue(':photo1', $photo1);
                $statement->bindValue(':photo2', $photo2);
                $statement->bindValue(':photo3', $photo3);
                $statement->bindValue(':plateNumber', $plateNumber);
                $statement->bindValue(':status', $status);

                // Execute the query and check for success
                if ($statement->execute()) {
                    $success_message = "New car record inserted successfully!";
                } else {
                    $error_message = "Error inserting car record";
                }
            }
        }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Insert Car</title>
</head>
<body>
    <?php
    // Display error message if set
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>
    <!-- Example output of success message -->
    <?php if (isset($success_message)) : ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php endif; ?>
</body>
</html>
<?php include_once('footer.html'); ?>
