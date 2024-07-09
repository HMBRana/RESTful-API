Step 2: Database Connection (db.php)
Create a file named db.php to handle the database connection.


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_list";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
