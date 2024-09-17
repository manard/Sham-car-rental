<?php
$connString = 'mysql:host=localhost:3307;dbname=webPro';
$user = 'root';
$password = '';

function html_header(){
    ?>
    <html>
    <head>
        <title>User Record Viewer</title>
    </head>
    <body>
    <?php
}

function html_footer() {
    ?>
    </body>
    </html>
    <?php
}

function db_connect($dbname = 'webpro', $username = 'root', $password = '') {
    global $connString;  // Use the global connection string
    try {
        // Create the PDO object with the correct connection string and credentials
        $pdo = new PDO($connString, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ensure exceptions on error
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

function error_message($msg) {
    echo "<p><em>Error: $msg</em></p>";
    exit;
}

function enum_options($field, $pdo) {
    $query = "SHOW COLUMNS FROM user LIKE '". $field ."'";
    $result = $pdo->query($query);
    $query_data = $result->fetch();

    $match = [];

    if (preg_match("/'([^']+)'/", $query_data["Type"], $match)) {
        $enum_str = str_replace("'", "", $match[0]);
        $enum_options = explode(',', $enum_str);
        return $enum_options;
    }

    return 0;
}
?>
