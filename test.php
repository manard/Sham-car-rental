<?php
session_start();
require_once('db.php.inc.php');
include_once('addForm.html');

// Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required fields are set
    if (
        isset($_POST['model']) &&
        isset($_POST['carmake']) &&
        isset($_POST['cartype']) &&
        isset($_POST['year']) &&
        isset($_POST['desc']) &&
        isset($_POST['fuel']) &&
        isset($_POST['price']) &&
        isset($_POST['peoplecapacity']) &&
        isset($_POST['suitcapacity']) &&
        isset($_POST['color']) &&
        isset($_POST['avgP']) &&
        isset($_POST['horsepower']) &&
        isset($_POST['length']) &&
        isset($_POST['width'])&&
        isset($_POST['photo1']) &&
        isset($_POST['photo2']) &&
        isset($_POST['photo3'])&&
        isset($_POST['plateNumber'])
        
    ) {
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

        
        // Establish a database connection
        $pdo = db_connect();
        
        // Prepare the SQL query
        $sql = "INSERT INTO cars (model, carmake, cartype, year, description, price, peoplecapacity, suitcasescapacity, color, avgpet, horsepower, length, width,photo1,photo2,photo3,plateNumber,fuel) 
        VALUES (:model, :carmake, :cartype, :year, :description, :price, :peoplecapacity, :suitcasescapacity, :color, :avgpet, :horsepower, :length, :width,:photo1,:photo2,:photo3,:plateNumber,:fuel)";
        
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':model', $_SESSION['model']);
        $statement->bindValue(':carmake', $_SESSION['carmake']);
        $statement->bindValue(':cartype', $_SESSION['cartype']);
        $statement->bindValue(':year', $_SESSION['year']);
        $statement->bindValue(':description', $_SESSION['desc']);
        $statement->bindValue(':fuel', $_SESSION['fuel']);
        $statement->bindValue(':price', $_SESSION['price']);
        $statement->bindValue(':peoplecapacity', $_SESSION['peoplecapacity']);
        $statement->bindValue(':suitcasescapacity', $_SESSION['suitcapacity']);
        $statement->bindValue(':color', $_SESSION['color']);
        $statement->bindValue(':avgpet', $_SESSION['avgP']);
        $statement->bindValue(':horsepower', $_SESSION['horsepower']);
        $statement->bindValue(':length', $_SESSION['length']);
        $statement->bindValue(':width', $_SESSION['width']);
        $statement->bindValue(':photo1', $_SESSION['photo1']);
        $statement->bindValue(':photo2', $_SESSION['photo2']);
        $statement->bindValue(':photo3', $_SESSION['photo3']);
        $statement->bindValue(':plateNumber', $_SESSION['plateNumber']);
        
        // Execute the query and check for success
        if ($statement->execute()) {
            echo "<p>New car record inserted successfully</p>";
            echo $_SESSION['plateNumber'];
            exit();
        } else {
            echo "<p>Error</p>";
        }
        }
    
}
?>
