<?php
session_start();
require_once('db.php.inc.php');
include_once('header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_SESSION['name']) && isset($_SESSION['HouseNo']) && isset($_SESSION['street'])
        && isset($_SESSION['city']) && isset($_SESSION['country']) && isset($_SESSION['DOB'])
        && isset($_SESSION['ID']) && isset($_SESSION['email']) && isset($_SESSION['telephone'])
        && isset($_SESSION['ccNumber']) && isset($_SESSION['ccExp']) && isset($_SESSION['ccName'])
        && isset($_SESSION['ccBank']) && isset($_SESSION['username']) && isset($_SESSION['password'])
    ) {
        $pdo = db_connect();
        $sql = "INSERT INTO user_info (name, ID, HouseNo, street, city, country, DOB, email, telephone,ccNumber,ccExp,ccName,ccBank,username,password,type )
                VALUES (:name, :ID, :HouseNo, :street, :city, :country, :DOB, :email, :telephone, :ccNumber, :ccExp,:ccName,:ccBank,:username,md5(:password),:type)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':name', $_SESSION['name']);
        $statement->bindValue(':ID', $_SESSION['ID']);
        $statement->bindValue(':HouseNo', $_SESSION['HouseNo']);
        $statement->bindValue(':street', $_SESSION['street']);
        $statement->bindValue(':city', $_SESSION['city']);
        $statement->bindValue(':country', $_SESSION['country']);
        $statement->bindValue(':DOB', $_SESSION['DOB']);
        $statement->bindValue(':email', $_SESSION['email']);
        $statement->bindValue(':telephone', $_SESSION['telephone']);
        $statement->bindValue(':ccNumber', $_SESSION['ccNumber']);
        $statement->bindValue(':ccExp', $_SESSION['ccExp']);
        $statement->bindValue(':ccName', $_SESSION['ccName']);
        $statement->bindValue(':ccBank', $_SESSION['ccBank']);
        $statement->bindValue(':username', $_SESSION['username']);
        $statement->bindValue(':password', $_SESSION['password']);
        $statement->bindValue(':type', 'customer');

        $statement->execute();
        $success_message = "Account created successfully!";
    } else {
        $error_message = "No Data to confirm";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Step 3</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if (isset($success_message)) : ?>
        <p class="success-message"><?php echo $success_message; ?></p>
        <p><a href="login.php">Go to Login Page</a></p>
    <?php elseif (isset($error_message)) : ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <fieldset>
            <legend>Confirm Your Information</legend>
            <p>Name: <?php echo ($_SESSION['name']); ?></p>
            <p>Username: <?php echo ($_SESSION['username']); ?></p>
            <p>Address: <?php echo ' House Number: ' . ($_SESSION['HouseNo']) . ' Street: ' . ($_SESSION['street']) . ' City: ' . ($_SESSION['city']) . ' Country: ' . ($_SESSION['country']); ?></p>
            <p>Date of Birth: <?php echo ($_SESSION['DOB']); ?></p>
            <p>ID Number: <?php echo ($_SESSION['ID']); ?></p>
            <p>Email: <?php echo ($_SESSION['email']); ?></p>
            <p>Telephone: <?php echo ($_SESSION['telephone']); ?></p>
            <p>Credit Card: <?php echo 'Number: ' . ($_SESSION['ccNumber']) . ' Expiration Date: ' . ($_SESSION['ccExp']) . ' Name: ' . ($_SESSION['ccName']) . ' Bank: ' . ($_SESSION['ccBank']); ?></p>
            <button type="submit">Confirm</button>
        </fieldset>
    </form>
</body>
</html>

<?php include_once('footer.html'); ?>

