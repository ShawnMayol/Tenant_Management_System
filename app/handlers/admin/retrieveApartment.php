<?php

include ('../../core/database.php');

// SQL query to fetch clients
$sql = "SELECT apartmentNumber, apartmentType, rentPerMonth, maxOccupants, apartmentStatus 
FROM apartment WHERE apartmentNumber = ? AND apartmentStatus = 'Available' ";  // Adjust the table name if necessary

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt) {
    // Bind the parameter
    $apartmentId = $_GET['apartmentId'];  // Or however you're getting this value
    $stmt->bind_param("i", $apartmentId);  // 'i' stands for integer

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    $apartment = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $apartment[] = $row;
        }
    }

    // Output the JSON-encoded result
    echo json_encode($apartment);

    // Close the statement
    $stmt->close();
} else {
    // Handle the error
    echo json_encode(["error" => "Error preparing statement: " . $conn->error]);
}

// Close the connection
$conn->close();

