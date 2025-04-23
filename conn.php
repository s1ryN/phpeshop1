<?php
//MySQLi konektor pro navázání spojení s DB

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sphere_base";

$conn = new mysqli($servername, $username, $password, $dbname);

// Spuštění session
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
