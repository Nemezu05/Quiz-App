<?php
$host = "sql308.infinityfree.com";
$user = "if0_40249397";
$password = "Nemezu2810";
$dbname = "if0_40249397_Quiz_app";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
