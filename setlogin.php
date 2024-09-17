<?php
session_start();
include_once('header.html');
require_once('db.php.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and store the e-account data in session
    if (
        !empty($_POST['username']) &&
        !empty($_POST['password']) &&
        !empty($_POST['confirmPassword']) &&
        $_POST['password'] == $_POST['confirmPassword']
    ) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['confirmPassword'] = $_POST['confirmPassword'];
        header('Location: confirmation.php');
        exit;
    } else {
       error_message("Wrong data");
    }

    echo '

    
    ';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="post" action="">
        <fieldset>
            <legend>E-Account Creation</legend>
            <label>Username</label>
            <input type="text" name="username" minlength="6" maxlength="13" required><br>
            <label>Password</label>
            <input type="password" name="password" minlength="8" maxlength="12" required><br>
            <label>Confirm Password</label>
            <input type="password" name="confirmPassword" minlength="8" maxlength="12" required><br>
            <button type="submit">Next</button>
        </fieldset>
    </form>
</body>
</html>
<?php include_once('footer.html');?>

