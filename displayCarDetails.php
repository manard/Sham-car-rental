<?php
session_start(); // Start the session
include_once('header.html');
include_once('nav.php');

// Check if session variables are set from RentCar.php or any other source
if (
    isset($_SESSION['model']) && isset($_SESSION['carmake']) && isset($_SESSION['cartype']) &&
    isset($_SESSION['year']) && isset($_SESSION['desc']) && isset($_SESSION['fuel']) &&
    isset($_SESSION['price']) && isset($_SESSION['peoplecapacity']) && isset($_SESSION['suitcapacity']) &&
    isset($_SESSION['color']) && isset($_SESSION['avgP']) && isset($_SESSION['horsepower']) &&
    isset($_SESSION['length']) && isset($_SESSION['width']) && isset($_SESSION['photo1']) &&
    isset($_SESSION['photo2']) && isset($_SESSION['photo3']) && isset($_SESSION['plateNumber'])
) {
    // Store session data in local variables for easier use
    $model = $_SESSION['model'];
    $carmake = $_SESSION['carmake'];
    $cartype = $_SESSION['cartype'];
    $year = $_SESSION['year'];
    $desc = $_SESSION['desc'];
    $fuel = $_SESSION['fuel'];
    $price = $_SESSION['price'];
    $peoplecapacity = $_SESSION['peoplecapacity'];
    $suitcapacity = $_SESSION['suitcapacity'];
    $color = $_SESSION['color'];
    $avgP = $_SESSION['avgP'];
    $horsepower = $_SESSION['horsepower'];
    $length = $_SESSION['length'];
    $width = $_SESSION['width'];
    $photo1 = $_SESSION['photo1'];
    $photo2 = $_SESSION['photo2'];
    $photo3 = $_SESSION['photo3'];
    $plateNumber = $_SESSION['plateNumber'];
    
   
} else {
    // Redirect or handle the case where session data is missing
   // header('Location: index.php'); // Redirect to index.php or appropriate page
    exit();
}

// Handle form submission for confirming rental
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_rental'])) {
    $fromDate = $_POST['from_date'];
    $toDate = $_POST['to_date'];
    $location = $_POST['location'];
    $babySeat = $_POST['baby_seat'];
    $_SESSION['babyseat'] = $babySeat;
    $_SESSION['fromdate'] = $fromDate;
    $_SESSION['todate'] = $toDate;
    $_SESSION['location'] = $location;
    // You can redirect to a confirmation page or process further based on the collected data
    echo "Rental Confirmed for $model from $fromDate to $toDate at $location with Baby Seat: $babySeat";
    header("location: invoiceD.php");
    //$pdo = db_connect();
   // $sql = "INSERT INTO rentedcar ";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="displaycardet">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label>Add Baby Seat</label>
            <input type="checkbox" id="baby_seat" name="baby_seat"><br><br>
            <label>From Date:</label>
            <input type="date" id="from_date" name="from_date" required><br><br>
            <label>To Date:</label>
            <input type="date" id="to_date" name="to_date" required><br><br>
            <label>Location:</label>
            <input type="text" id="location" name="location" required><br><br>
            <!-- Hidden inputs -->
            <input type="hidden" name="model" value="<?php echo $model; ?>">
            <input type="hidden" name="carmake" value="<?php echo $carmake; ?>">
            <!-- Add more hidden inputs as needed -->

            <button type="submit" name="confirm_rental">Confirm Rent</button>
        </form>
    </div>
</body>
</html>
<?php include_once('footer.html'); ?>
