<?php
session_start(); // Start the session
require_once('db.php.inc.php'); // Assuming this file contains your db connection function
include_once('header.html');
include_once('nav.php');

// Check if all required session variables are set
if (
    isset($_SESSION['model'], $_SESSION['carmake'], $_SESSION['cartype'], $_SESSION['location'],
          $_SESSION['desc'], $_SESSION['fuel'], $_SESSION['babyseat'], $_SESSION['fromdate'],
          $_SESSION['todate'], $_SESSION['ID'], $_SESSION['name'], $_SESSION['country'],
          $_SESSION['telephone'], $_SESSION['city'], $_SESSION['card_number'],
          $_SESSION['expiration_date'], $_SESSION['holder_name'], $_SESSION['bank_issued'],
          $_SESSION['card_type'], $_SESSION['plateNumber'])
) {
    try {
        // Retrieve all session variables
        $model = $_SESSION['model'];
        $carmake = $_SESSION['carmake'];
        $cartype = $_SESSION['cartype'];
        $location = $_SESSION['location'];
        $desc = $_SESSION['desc'];
        $fuel = $_SESSION['fuel'];
        $babyseat = $_SESSION['babyseat'];
        $fromdate = $_SESSION['fromdate'];
        $todate = $_SESSION['todate'];
        $ID = $_SESSION['ID'];
        $name = $_SESSION['name'];
        $country = $_SESSION['country'];
        $telephone = $_SESSION['telephone'];
        $city = $_SESSION['city'];
        $cardNumber = $_SESSION['card_number'];
        $expirationDate = $_SESSION['expiration_date'];
        $holderName = $_SESSION['holder_name'];
        $bankIssued = $_SESSION['bank_issued'];
        $cardType = $_SESSION['card_type'];
        $plateNumber = $_SESSION['plateNumber']; // Added plateNumber session variable

        // Calculate the rental status
        $current_date = date('Y-m-d');
        $statuses = ($fromdate > $current_date) ? 'future' : (($todate >= $current_date) ? 'current' : 'past');

        // Store status in session for use in invoiceD.php or further processing
        $_SESSION['statuses'] = $statuses;

        // Generate an invoice ID (10-digit number)
        $invoiceID = rand(1000000000, 9999999999);
        $_SESSION['invoice_id'] = $invoiceID;

        // Establish database connection
        $pdo = db_connect();

        // Prepare the SQL statement to retrieve the car ID based on plateNumber
        $getCarIDStmt = $pdo->prepare("SELECT id FROM cars WHERE plateNumber = :plateNumber");
        $getCarIDStmt->bindValue(':plateNumber', $plateNumber);
        $getCarIDStmt->execute();

        // Fetch the car ID
        $car = $getCarIDStmt->fetch(PDO::FETCH_ASSOC);
        if ($car) {
            $carID = $car['id'];

            // Prepare the SQL statement with named parameters for inserting rental info
            $stmt = $pdo->prepare("INSERT INTO rentinfo 
                                    (model, carmake, cartype, location, description, fuel, babyseat, fromdate, todate, ID, name, country, telephone, city, card_number, expiration_date, holder_name, bank_issued, card_type, invoice_id, statuses)
                                    VALUES 
                                    (:model, :carmake, :cartype, :location, :description, :fuel, :babyseat, :fromdate, :todate, :ID, :name, :country, :telephone, :city, :card_number, :expiration_date, :holder_name, :bank_issued, :card_type, :invoice_id, :statuses)");

            // Bind values to named parameters
            $stmt->bindValue(':model', $model);
            $stmt->bindValue(':carmake', $carmake);
            $stmt->bindValue(':cartype', $cartype);
            $stmt->bindValue(':location', $location);
            $stmt->bindValue(':description', $desc);
            $stmt->bindValue(':fuel', $fuel);
            $stmt->bindValue(':babyseat', $babyseat);
            $stmt->bindValue(':fromdate', $fromdate);
            $stmt->bindValue(':todate', $todate);
            $stmt->bindValue(':ID', $ID);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':country', $country);
            $stmt->bindValue(':telephone', $telephone);
            $stmt->bindValue(':city', $city);
            $stmt->bindValue(':card_number', $cardNumber);
            $stmt->bindValue(':expiration_date', $expirationDate);
            $stmt->bindValue(':holder_name', $holderName);
            $stmt->bindValue(':bank_issued', $bankIssued);
            $stmt->bindValue(':card_type', $cardType);
            $stmt->bindValue(':invoice_id', $invoiceID);
            $stmt->bindValue(':statuses', $statuses);

            // Execute the statement
            $stmt->execute();

            // Check if the query was successful
            if ($stmt->rowCount() > 0) {
                // Update car status to 'rented'
                $updateStmt = $pdo->prepare("UPDATE cars SET status = 'rented' WHERE id = :id");
                $updateStmt->bindValue(':id', $carID);
                $updateStmt->execute();

                if ($updateStmt->rowCount() > 0) {
                    $confirmationMessage = "$name, thank you for renting the $model. Your rental has been confirmed.\n";
                    $confirmationMessage .= "Invoice ID: $invoiceID\n";
                } else {
                    $error_message = "Failed to update car status. Please try again later.";
                }
            } else {
                $error_message = "Failed to confirm rental. Please try again later.";
            }
        } else {
            $error_message = "Car not found for plate number: $plateNumber. Please check and try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // If any required session variables are missing or if the confirm_rent button wasn't pressed
    echo 'Error: Missing required session variables or confirm_rent not set.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Confirmation</title>
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
    else if(isset($confirmationMessage)){
        echo "<p class='success-message'>$confirmationMessage</p>";
        include_once('footer.html');
        exit();
    }
    ?>
</body>
</html>
<?php include_once('footer.html');?>
