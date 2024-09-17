<?php
session_start();
require_once('db.php.inc.php');
include_once('header.html');
include_once('nav.php');

// Check if user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1 && isset($_SESSION['ID'])) {
    $ID = $_SESSION['ID'];
    $name = $_SESSION['name'];

    try {
        // Establish database connection
        $pdo = db_connect();

        // If the form is submitted, update the user information
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
            $updatedName = $_POST['name'];
            $updatedCountry = $_POST['country'];
            $updatedTelephone = $_POST['telephone'];
            $updatedCity = $_POST['city'];

            // Update user information in the database
            $updateStmt = $pdo->prepare("UPDATE user_info SET name = :name, country = :country, telephone = :telephone, city = :city WHERE ID = :ID");
            $updateStmt->bindValue(':name', $updatedName);
            $updateStmt->bindValue(':country', $updatedCountry);
            $updateStmt->bindValue(':telephone', $updatedTelephone);
            $updateStmt->bindValue(':city', $updatedCity);
            $updateStmt->bindValue(':ID', $ID);
            $updateStmt->execute();

            // Update session variables
            $_SESSION['name'] = $updatedName;
            $sucmsg = "Profile updated successfully";
        }

        // Retrieve the user information from the database
        $query = "SELECT * FROM user_info WHERE ID = :ID";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':ID', $ID);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Update Profile</title>
                <link rel="stylesheet" href="styles.css">
            </head>
            <body>
                <?php
                if (isset($sucmsg)) {
                    echo "<p class='success-message'>$sucmsg</p>";
                }
                ?>
                <div class="profileform">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <label for="ID">Customer ID:</label>
                        <input type="text" id="ID" name="ID" value="<?php echo htmlspecialchars($user['ID']); ?>" readonly><br>

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

                        <label for="country">Country:</label>
                        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" required><br>

                        <label for="telephone">Telephone:</label>
                        <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['telephone']); ?>" required><br>

                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required><br>

                        <button type="submit" name="update_profile">Update Profile</button>
                    </form>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "<p class='error-message'>Error: User not found.</p>";
            include_once('footer.html');
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo 'Error: User not logged in or missing user ID.';
    exit();
}
include_once('footer.html');
?>