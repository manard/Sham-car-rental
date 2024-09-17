<?php
session_start(); // Start the session
include_once('header.html');
include_once('nav.php');

// Initialize errors array
$errors = [];

// Validate and process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_rent'])) {
    
    // Credit card number validation
    if (!isset($_POST['card_number']) || !preg_match('/^\d{9}$/', $_POST['card_number'])) {
        $errors[] = "Invalid credit card number. It should consist of 9 digits.";
    }
    
    // Expiration date validation (for example, check if it's a future date)
    $currentDate = date('Y-m-d');
    $expirationDate = $_POST['expiration_date'];
    if (!isset($expirationDate) || $expirationDate < $currentDate) {
        $errors[] = "Expiration date should be a future date.";
    }
    
    // Validate other fields as needed (holder name, bank-issued)
    // Assuming basic validation for holder name and bank-issued

    // If no errors, save data into session variables and redirect
    if (empty($errors)) {
        $_SESSION['card_number'] = $_POST['card_number'];
        $_SESSION['expiration_date'] = $_POST['expiration_date'];
        $_SESSION['holder_name'] = $_POST['holder_name'];
        $_SESSION['bank_issued'] = $_POST['bank_issued'];
        $_SESSION['card_type'] = $_POST['card_type'];
        
        // Redirect to confirmation page
        header('Location: confirmationRent.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <h3>Enter Credit Card Details</h3>
        <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <label for="card_number">Credit Card Number:</label>
        <input type="text" id="card_number" name="card_number" required><br><br>
        
        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date" required><br><br>
        
        <label for="holder_name">Holder Name:</label>
        <input type="text" id="holder_name" name="holder_name" required><br><br>
        
        <label for="bank_issued">Bank Issued:</label>
        <input type="text" id="bank_issued" name="bank_issued" required><br><br>
        
        <label>Select Credit Card Type:</label><br>
        
        <input type="radio" id="visa" name="card_type" value="Visa" checked>
        <label for="visa">Visa</label><br>
        
        <input type="radio" id="mastercard" name="card_type" value="MasterCard">
        <label for="mastercard">MasterCard</label><br><br>
        
        <label>
            <input type="checkbox" id="accept_terms" name="accept_terms" required>
            I accept the terms and conditions
        </label><br><br>
        
        <button type="submit" name="confirm_rent">Confirm Rent</button>
    </form>
</body>
</html>
<?php include_once('footer.html'); ?>
