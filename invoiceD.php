<?php
session_start();
require_once('db.php.inc.php');
include_once('header.html');
include_once('nav.php');

// Check if all the required session variables are set
if (isset($_SESSION['model']) && 
    isset($_SESSION['carmake']) && 
    isset($_SESSION['cartype']) &&
    isset($_SESSION['location']) && 
    isset($_SESSION['desc']) && 
    isset($_SESSION['fuel']) &&
    isset($_SESSION['babyseat']) &&
    isset($_SESSION['fromdate']) &&
    isset($_SESSION['todate'])&&
    isset( $_SESSION['ID'])&&
    isset($_SESSION['name'])&&
    isset($_SESSION['country'])&&
    isset($_SESSION['telephone'])&&
    isset($_SESSION['city'])){

    $cusID = $_SESSION['ID'];
    $cusname = $_SESSION['name'];
    $cusAddress = $_SESSION['country'];
    $cusCity = $_SESSION['city'];
    $cusTel = $_SESSION['telephone'];
    $model = $_SESSION['model'];
    $carmake = $_SESSION['carmake'];
    $cartype = $_SESSION['cartype'];
    $location = $_SESSION['location'];
    $desc = $_SESSION['desc'];
    $fuel = $_SESSION['fuel'];
    $babyseat = $_SESSION['babyseat'];
    $fromdate = $_SESSION['fromdate'];
    $todate = $_SESSION['todate'];

    
} else {
    error_message("Some required session variables are not set");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form method="post" action="cridtdetails.php">
    <h3>Car Info:</h3>
    <label>Car Model: <?php echo $model; ?></label><br>
    <label>Car Make: <?php echo $carmake; ?></label><br>
    <label>Car Type: <?php echo $cartype; ?></label><br>
    <label>Location: <?php echo $location; ?></label><br>
    <label>Description: <?php echo $desc; ?></label><br>
    <label>Fuel: <?php echo $fuel; ?></label><br>
    <label>Baby Seat: <?php echo $babyseat; ?></label><br>
    <label>From Date: <?php echo $fromdate; ?></label><br>
    <label>To Date: <?php echo $todate; ?></label><br>

    <h3>Customer Info:</h3>
    <label>Name: <?php echo $cusname; ?></label><br>
    <label>Country: <?php echo $cusAddress; ?></label><br>
    <label>City: <?php echo $cusCity; ?></label><br>
    <label>Telephone: <?php echo $cusTel; ?></label><br>

    <button type="submit">Proceed to Invoice</button>
</form>
</body>
</html>
<?php include_once('footer.html');?>
