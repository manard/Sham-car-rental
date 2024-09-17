<?php
require_once('db.php.inc.php');
include_once('header.html');
include_once('nav.php');
include_once('page.php');
$pdo = db_connect();
$sql = "SELECT * FROM cars";
$statement = $pdo->prepare($sql);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

function searchForm($rows) {
    $currentDate = date('Y-m-d');
    // Calculate the date after adding three days
    $datePlusThree = date('Y-m-d', strtotime('+3 days'));

    echo <<<EOD
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Car</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="searchform">
            <form action="searchresult.php" method="post">
                <fieldset>
                    <label>From Date</label>
                    <input type="date" name="fromDate" value="$currentDate"><br>
                    <label>To Date</label>
                    <input type="date" name="toDate" value="$datePlusThree"><br>
                    <label>Car type</label>
                    <input type="text" name="carType" value="sedan"><br>
                    <label>Pick up Location</label>
                    <input type="text" name="pickUp" value="Birzeit"><br>
                    <label>Price</label>
                    <input type="number" name="price" min="200" max="1000"><br>
                    <input type="submit" name="search" value="Search">
                </fieldset>
            </form>
        </div>
    </body>
    </html>
    EOD;
}

searchForm($rows);
include_once('footer.html');
?>
