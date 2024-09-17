<?php
session_start(); // Start the session
include_once('header.html');
include_once('nav.php');

// Check if the user is logged in (uncomment if you want to enforce login)
// if (!isset($_SESSION['username'])) {
//     header('Location: login.php'); // Redirect to login page if not logged in
//     exit();
// }

require_once('db.php.inc.php'); // Replace with your database connection function

// Assuming you have a function to connect to the database
try {
    // Connect to database
    $pdo = db_connect(); // Replace with your database connection function

    // Retrieve user type from the database based on the logged-in user
    // $username = $_SESSION['username'];
    $username = $_SESSION['username']; // Replace with actual username or retrieve from session

    // Prepare SQL statement to retrieve user type
    $sqlUserType = "SELECT type FROM user_info WHERE username = :username";
    $stmtUserType = $pdo->prepare($sqlUserType);
    $stmtUserType->execute([':username' => $username]);

    // Fetch user type
    $user = $stmtUserType->fetch(PDO::FETCH_ASSOC);
    if (!$user || $user['type'] !== 'manager') {
        // Handle unauthorized access
        $error_message = "Only Manager can view this page";
    }

    // Proceed with location insertion if user is authorized
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $user['type'] == 'manager') {
        // Validate and sanitize inputs
        $name = $_POST['name'];
        $property_number = $_POST['property_number']; // corrected from 'propertynumber'
        $street_name = $_POST['street_name']; // corrected from 'streetname'
        $city = $_POST['city'];
        $postal_code = $_POST['postal_code']; // corrected from 'postalcode'
        $country = $_POST['country'];
        $telephone = $_POST['telephone']; // corrected from 'telnumber'

        // Prepare SQL statement to insert location
        $sqlInsert = "INSERT INTO location (name, propertynumber, streetname, city, postalcode, country, telnumber)
                      VALUES (:name, :property_number, :street_name, :city, :postal_code, :country, :telephone)";
        
        // Prepare and execute the statement
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            ':name' => $name,
            ':property_number' => $property_number,
            ':street_name' => $street_name,
            ':city' => $city,
            ':postal_code' => $postal_code,
            ':country' => $country,
            ':telephone' => $telephone
        ]);

        // Check if insertion was successful
        if ($stmtInsert->rowCount() > 0) {
            $message = "Location added successfully!";
        } else {
            $error = "Failed to add location. Please try again.";
        }
    }
} catch (PDOException $e) {
    // Handle database connection or query error
    $error = "Database Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Location</title>
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
    <?php if (isset($message)): ?>
        <p class="success-message"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <div class="locationform">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="property_number">Property Number:</label>
            <input type="text" id="property_number" name="property_number" required><br><br>
            
            <label for="street_name">Street Name:</label>
            <input type="text" id="street_name" name="street_name" required><br><br>
            
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br><br>
            
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required><br><br>
            
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required><br><br>
            
            <label for="telephone">Telephone:</label>
            <input type="tel" id="telephone" name="telephone" required><br><br>
            
            <button type="submit" name="submit">Add Location</button>
        </form>
    </div>

    <?php include_once('footer.html'); ?>
</body>
</html>
