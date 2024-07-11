<?php
header('Content-Type: application/json');

// Assuming JSON input is correctly formatted and contains all necessary fields
$input = json_decode(file_get_contents('php://input'), true);

// Extract variables from JSON input
$firstName = $input['firstName'];
$lastName = $input['lastName'];
$middleName = $input['middleName'];
$dateOfBirth = $input['dateOfBirth'];
$phoneNumber = $input['phoneNum'];
$emailAddress = $input['email'];
$deposit = $input['deposit']; 
$requestId = $input['reqID'];

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
    // Get the last inserted tenant ID
    $tenantId = $conn->insert_id;
    
    // Update request status to 'Approved'
    $stmtUpdate = $conn->prepare("UPDATE request SET requestStatus = 'Approved' WHERE request_ID = ?");
    $stmtUpdate->bind_param("i", $requestId); // Assuming request_ID is numeric
    
    // Execute the update query
    if ($stmtUpdate->execute()) {
        // Close the update statement
        $stmtUpdate->close();
        
        // Return success JSON response
        echo json_encode(['success' => true, 'tenant_id' => $tenantId]);
    } else {
        // Handle update query failure
        echo json_encode(['success' => false, 'message' => 'Failed to update request status']);
    }
    
    // Close the insert statement
    $stmt->close();
} else {
    // Handle insert query failure
    echo json_encode(['success' => false, 'message' => 'Failed to add tenant']);
    $stmt->close();
}

// Close database connection
$conn->close();

