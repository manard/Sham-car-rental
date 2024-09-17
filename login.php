<?php
session_start();
require_once('db.php.inc.php');
include_once('header.html');

$PHP_SELF = $_SERVER['PHP_SELF'];
do_authentication();

function do_authentication() {
    global $PHP_SELF;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];

        $username = $_POST['username'];
        $userpassword = $_POST['password'];

        $pdo = db_connect();
        if (!$pdo) {
            error_message("Null PDO Object");
        }

        $query = "SELECT username, password FROM user_info WHERE username = :username AND password = :password";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $userpassword); // Still using md5 here because of original code
        $statement->execute();

        if ($statement->fetchColumn() == 0) {
            unset($_SESSION['username']);
            unset($_SESSION['password']);
            echo "Authorization failed. You must enter a valid username and password combo. Click on the following link to try again.<br>";
            echo "<a href=\"$PHP_SELF\">Login</a><br>";
            echo "If you're not a member yet, click on the following link to register.<br>";
            echo "<a href=\"register.php\">Membership</a>";
            exit;
        } else {
            $_SESSION['logged_in'] = true;
            $_SESSION['visits'] = 0;
            // Redirect or display welcome message after successful login
            header("Location: index.php"); // Redirect to welcome page
            exit();
        }
    } else {
        login_form();
    }
}

function login_form() {
    global $PHP_SELF;

    echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="login-form-container">
    <form method="post" action="$PHP_SELF">
        <fieldset>
            <legend>Log in</legend>
            <label>User Name: </label>
            <input type="text" name="username" required><br>
            <label>Password: </label>
            <input type="password" name="password" required><br>
            <input type="submit" name="submit" value="Login">
        </fieldset>
    </form>
</div>
EOD;

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        echo "<div class='welcome-message'>Welcome Back!</div>";
    }

    echo <<<EOD
</body>
</html>
EOD;
}
?>
<?php include_once('footer.html');?>
