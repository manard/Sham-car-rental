<?php
require_once('db.php.inc.php');
include_once('header.html');
include_once('nav.php');
//include_once('page.php');
$pdo = db_connect();

// Initialize the SQL query to fetch all cars with status 'available'
$sql = "SELECT * FROM cars WHERE status = 'available'";


// Check if the form is submitted and build the query accordingly
if (isset($_POST['price']) && isset($_POST['carType'])) {
    $price = $_POST['price'];
    $cartype = $_POST['carType'];

    // Append additional conditions to the SQL query
    $sql .= " AND cartype = '$cartype' AND price = '$price'";
}

// Execute the SQL query
$statement = $pdo->query($sql);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

// Check if the form is submitted
if (isset($_POST['filter'])) {
    // Retrieve checked checkboxes (car IDs)
    $checkedCars = isset($_POST['check']) ? $_POST['check'] : [];

    if (!empty($checkedCars)) {
        // Create a placeholder string for car IDs
      

        // Append condition to SQL query to filter by checked car IDs
        $sql .= " AND id IN ($cars)";
        $params = $checkedCars;
    }
}

// Prepare and execute the SQL statement
$statement = $pdo->prepare($sql);
$statement->execute($params);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Information</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="formres">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th><button type="submit" name="filter">Filter</button></th>
                    <th>Price per day</th>
                    <th>Car Type</th>
                    <th>Fuel type</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><input type="checkbox" name="check[]" value="<?= $row['id']; ?>"></td>
                        <td><?= $row['price']; ?></td>
                        <td><?= $row['cartype']; ?></td>
                        <td><?= $row['fuel']; ?></td>
                        <td><img src="carsImages/<?= $row['photo1']; ?>" width="140"></td>
                        <td><a href="viewTorent.php?id=<?= $row['id']; ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>
</body>
</html>


<?php include_once('footer.html');?>
