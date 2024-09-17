<?php
session_start(); // Start the session

// Check if form is submitted using POST method and 'rentcar' button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rentcar'])) {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: login.php');
        exit();
    }
    else{
    if (
        isset($_POST['model']) && isset($_POST['carmake']) && isset($_POST['cartype']) &&
        isset($_POST['year']) && isset($_POST['desc']) && isset($_POST['fuel']) &&
        isset($_POST['price']) && isset($_POST['peoplecapacity']) && isset($_POST['suitcapacity']) &&
        isset($_POST['color']) && isset($_POST['avgP']) && isset($_POST['horsepower']) &&
        isset($_POST['length']) && isset($_POST['width']) && isset($_POST['photo1']) &&
        isset($_POST['photo2']) && isset($_POST['photo3']) && isset($_POST['plateNumber'])
    ) {
        // Store form data in session variables for use in other pages or processing
        $_SESSION['model'] = $_POST['model'];
        $_SESSION['carmake'] = $_POST['carmake'];
        $_SESSION['cartype'] = $_POST['cartype'];
        $_SESSION['year'] = $_POST['year'];
        $_SESSION['desc'] = $_POST['desc'];
        $_SESSION['fuel'] = $_POST['fuel'];
        $_SESSION['price'] = $_POST['price'];
        $_SESSION['peoplecapacity'] = $_POST['peoplecapacity'];
        $_SESSION['suitcapacity'] = $_POST['suitcapacity'];
        $_SESSION['color'] = $_POST['color'];
        $_SESSION['avgP'] = $_POST['avgP'];
        $_SESSION['horsepower'] = $_POST['horsepower'];
        $_SESSION['length'] = $_POST['length'];
        $_SESSION['width'] = $_POST['width'];
        $_SESSION['photo1'] = $_POST['photo1'];
        $_SESSION['photo2'] = $_POST['photo2'];
        $_SESSION['photo3'] = $_POST['photo3'];
        $_SESSION['plateNumber'] = $_POST['plateNumber'];

        // Redirect to another page or display a success message
        header('Location: displayCarDetails.php'); // Replace with your desired page
        exit();
    }
     else {
        echo "All form fields are required.";
    }
}
}
?>
