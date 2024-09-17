<?php
include_once('header.html');
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="regform">
        <form method="post" action="CusRegister.php">
            <fieldset>
                <legend>Customer Information</legend>
                <label>Name</label>
                <input type="text" name="name" required><br>
                <label>Flat/House No</label>
                <input type="text" name="HouseNo" required><br>
                <label>Street</label>
                <input type="text" name="street" required><br>
                <label>City</label>
                <input type="text" name="city" required><br>
                <label>Country</label>
                <input type="text" name="country" required><br>
                <label>Date of Birth</label>
                <input type="date" name="DOB" required><br>
                <label>ID Number</label>
                <input type="text" name="ID" required><br>
                <label>E-mail</label>
                <input type="email" name="email" required><br>
                <label>Telephone</label>
                <input type="text" name="telephone" required><br>
                <label>Credit Card Number</label>
                <input type="text" name="ccNumber" required><br>
                <label>Expiration Date</label>
                <input type="date" name="ccExp" required><br>
                <label>Name on Card</label>
                <input type="text" name="ccName" required><br>
                <label>Bank Issued</label>
                <input type="text" name="ccBank" required><br>
                <button type="submit">Next</button>
            </fieldset>
        </form>
    </div>
</body>
</html>
';
include_once('footer.html');
?>
