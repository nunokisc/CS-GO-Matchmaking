<?php
$servername = "localhost";
$username = "matchmaking";
$password = "Backstabd1234.";
$dbname = "matchmaking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>