<?php
// db.php - اتصال قاعدة البيانات

$servername = "localhost";
$username = "root";
$password = "778838336";
$dbname = "Custody_sergeant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>