<?php
session_start(); // Start the session
include_once('header.html');
include_once('nav.php');
require_once('db.php.inc.php'); // Adjust path as necessary

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
}

// Display error message if set
if (isset($error_message)) {
    echo "<p class='error-message'>$error_message</p>";
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>error</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        
    </body>
    </html>
    ';
} else {
    // Display the form for adding a car
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insert Car</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="addcar">
            <form method="post" action="addCar.php">
                <fieldset>
                    <legend>Add Car</legend>
                    <label>Model:</label>
                    <input type="text" name="model"><br>
                    
                    <label>Car Make:</label>
                    <select name="carmake">
                        <option value="bmw">BMW</option>
                        <option value="volvo">Volvo</option>
                        <option value="honda">Honda</option>
                        <option value="toyota">Toyota</option>
                        <option value="tesla">Tesla</option>
                    </select><br>

                    <label>Car Type:</label>
                    <select name="cartype">
                        <option value="van">Van</option>
                        <option value="minivan">Minivan</option>
                        <option value="estate">Estate</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                    </select><br>

                    <label>Registration Year:</label>
                    <input type="number" name="year"><br>

                    <label>Brief Description:</label>
                    <input type="text" name="desc"><br>

                    <label>Price per Day:</label>
                    <input type="number" name="price"><br>

                    <label>People Capacity:</label>
                    <input type="number" name="peoplecapacity"><br>

                    <label>Suitcases Capacity:</label>
                    <input type="number" name="suitcapacity"><br>

                    <label>Fuel Type:</label>
                    <input type="text" name="fuel"><br>

                    <label>Colors:</label>
                    <input type="color" name="color"><br>

                    <label>Avg Petroleum per 100K:</label>
                    <input type="number" name="avgP"><br>

                    <label>Horsepower:</label>
                    <input type="number" name="horsepower"><br>

                    <label>Plate Number:</label>
                    <input type="number" name="plateNumber"><br>

                    <label>Length:</label>
                    <input type="number" name="length"><br>

                    <label>Width:</label>
                    <input type="number" name="width"><br>

                    <label>First Photo:</label>
                    <input type="file" name="photo1"><br>

                    <label>Second Photo:</label>
                    <input type="file" name="photo2"><br>

                    <label>Third Photo:</label>
                    <input type="file" name="photo3"><br>

                    <input type="submit" name="submit">
                </fieldset>
            </form>
        </div>
    </body>
    </html>
    <?php
}

include_once('footer.html');
?>
