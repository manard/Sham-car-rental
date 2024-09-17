<?php
session_start();
require_once('db.php.inc.php');  // Include the database connection script
require_once('car.php');  // Include the Car class definition
include_once('header.html');
include_once('nav.php');

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View To rent</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
</body>
</html>
';
// Establish database connection
$pdo = db_connect();

if(isset($_GET['id'])) {
    $pid = $_GET['id'];  // Get car ID from URL parameter
    $sql = "SELECT * FROM cars WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $pid);
    $statement->execute();

    $carData = $statement->fetch(PDO::FETCH_ASSOC);  // Fetch the car data

    if ($carData) {
        $car = new Car($carData);  // Create a new Car object with fetched data
        echo $car->displayCarPage();  // Display the car details
    } else {
        echo "Car not found";
    }
} else {
    echo "No car ID provided";
}
?>


<?php include_once('footer.html');?>
