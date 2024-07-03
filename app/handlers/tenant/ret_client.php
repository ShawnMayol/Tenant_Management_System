<?php
header('Content-Type: application/json');

// Establish database connection (Replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "tms";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch clients
$sql = "SELECT CONCAT(first_name,' ',last_name) AS 'Name', 
birth_date, email, phone_number, id_attachment,id FROM clients";  // Adjust the table name if necessary
$result = $conn->query($sql);

$clients = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Use the file path as the base URL
        // C:\xampp\htdocs\webDev\Tenant_Management_System\database\uploads\8tlwrk.jpg
        $base_url = "../database/uploads/";
        $row['id_attachment'] = $base_url . $row['id_attachment'];
        $clients[] = $row;
    }
}

echo json_encode($clients);

$conn->close();

