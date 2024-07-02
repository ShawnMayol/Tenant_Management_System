<?php
header('Content-Type: application/json');

// Database connection
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

// SQL query to fetch clients
$sql = "SELECT CONCAT(first_name,' ',last_name) AS 'Name', 
birth_date, email, phone_number, id_attachment,id FROM clients";  // Adjust the table name if necessary
$result = $conn->query($sql);

$clients = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Use the file path as the base URL
        $base_url = "/TMSv3/database/uploads/";
        $row['id_attachment'] = $base_url . $row['id_attachment'];
        $clients[] = $row;
    }
}

echo json_encode($clients);

$conn->close();

