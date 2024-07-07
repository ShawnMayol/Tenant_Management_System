<?php
header('Content-Type: application/json');


// Assuming JSON input is correctly formatted and contains all necessary fields
$input = json_decode(file_get_contents('php://input'), true);

// Extract variables from JSON input
$firstName = $input['firstName'];
$lastName = $input['lastName'];
$middleName = $input['middleName'];
$dateOfBirth = $input['dateOfBirth'];
$phoneNumber = $input['phoneNumber'];
$emailAddress = $input['emailAddress'];
$deposit = $input['depositNum']; // Assuming 'depositNum' is the correct field name from your JSON input
$requestId = $input['requestId'];

// Include database connection file
include('../../core/database.php');

// Set the default timezone to Hong Kong
date_default_timezone_set('Asia/Hong_Kong');
$dateOfBirthFormatted = date('Y-m-d', strtotime($dateOfBirth));


// Insert into tenant table
$stmt = $conn->prepare("INSERT INTO tenant (firstName, lastName, middleName, dateOfBirth, phoneNumber, emailAddress, deposit, request_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssdi", $firstName, $lastName, $middleName, $dateOfBirthFormatted, $phoneNumber, $emailAddress, $deposit, $requestId);

// Execute the insert query
if ($stmt->execute()) {
    // Close the statement after execution
    $stmt->close();
    
    // Update request status to 'Approved'
    $stmtUpdate = $conn->prepare("UPDATE request SET requestStatus = 'Approved' WHERE request_ID = ?");
    $stmtUpdate->bind_param("d", $requestId); // Assuming request_ID is numeric
    
    // Execute the update query
    if ($stmtUpdate->execute()) {
        // Close the update statement
        $stmtUpdate->close();
        
        // Return success JSON response
        echo json_encode(['success' => true]);
    } else {
        // Handle update query failure
        echo json_encode(['success' => false, 'message' => 'Failed to update request status']);
    }
    
    // Close database connection
    $conn->close();
} else {
    // Handle insert query failure
    echo json_encode(['success' => false, 'message' => 'Failed to add tenant']);
    $stmt->close();
    $conn->close();
}

