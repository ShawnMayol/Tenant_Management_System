<?php
include ('../../core/database.php');

// SQL query to fetch clients
$sql = "SELECT CONCAT(firstName,' ',lastName) AS 'Name', 
dateOfBirth, emailAddress, phoneNumber, requestBin,request_ID, 
requestDate,  apartmentNumber, termsOfStay, startDate, endDate, 
note, firstName, lastName, middleName FROM request WHERE requestStatus = 'Pending'" ;  // Adjust the table name if necessary
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

