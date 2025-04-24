<?php
$host = 'localhost';
$user = 'root';
$pass = '3323';
$db = 'air_quality';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed", "details" => $conn->connect_error]));
}
?>