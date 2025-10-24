<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "Quiz_App";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
