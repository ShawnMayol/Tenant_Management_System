<?php
include ('../../core/database.php');
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "tms";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// SQL query to fetch clients
$sql = "SELECT CONCAT(firstName,' ',lastName) AS 'Name', 
dateOfBirth, emailAddress, phoneNumber, requestBin,request_ID, requestDate FROM request";  // Adjust the table name if necessary
$result = $conn->query($sql);

$request = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        // Use the file path as the base URL
        $base_url = "";

        // Assuming id_attachment is stored as a comma-separated string in database
        $attachments = explode(',', $row['requestBin']);

        // $row['id_attachment'] = $base_url . $row['id_attachment']; DEFAULT(OLD)

        // Format each attachment URL with base URL
        $formatted_attachments = array_map(function ($att) use ($base_url) {
            return $base_url . trim($att);
        }, $attachments);

        // Add formatted attachments to the row
        $row['requestBin'] = $formatted_attachments;


        $request[] = $row;
    }
}

echo json_encode($request);

$conn->close();

