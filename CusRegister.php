<?php
session_start();
require_once('db.php.inc.php');
include_once('User.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        !empty($_POST['name']) &&
        !empty($_POST['HouseNo']) &&
        !empty($_POST['street']) &&
        !empty($_POST['city']) &&
        !empty($_POST['country']) &&
        !empty($_POST['DOB']) &&
        !empty($_POST['ID']) &&
        !empty($_POST['email']) &&
        !empty($_POST['telephone']) &&
        !empty($_POST['ccNumber']) &&
        !empty($_POST['ccExp']) &&
        !empty($_POST['ccName']) &&
        !empty($_POST['ccBank'])
    ) {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['HouseNo'] = $_POST['HouseNo'];
    $_SESSION['street'] = $_POST['street'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['country'] = $_POST['country'];
    $_SESSION['DOB'] = $_POST['DOB'];
    $_SESSION['ID'] = $_POST['ID'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['telephone'] = $_POST['telephone'];
    $_SESSION['ccNumber'] = $_POST['ccNumber'];
    $_SESSION['ccExp'] = $_POST['ccExp'];
    $_SESSION['ccName'] = $_POST['ccName'];
    $_SESSION['ccBank'] = $_POST['ccBank'];
    $_SESSION['type'] = 'customer';
    header('Location: setlogin.php');
    exit();
}
else {
    error_message("Wrong data input");
}
}
 

?>
