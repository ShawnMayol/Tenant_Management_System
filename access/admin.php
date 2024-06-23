<?php
// Use to create admin profile

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms_v2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Generate hashed password for admin
$password = 'admin';  // Replace with your desired admin password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert admin user into database
$sql = "INSERT INTO users (email, password) VALUES ('admin', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
    echo "Admin user added successfully!";
} else {
    echo "Error adding admin user: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);

