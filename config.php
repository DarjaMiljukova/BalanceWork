<?php
$servername = "localhost"; // Your database server
$username = "darja";         // Your database username
$password = "2203";             // Your database password
$dbname = "balancemil";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
