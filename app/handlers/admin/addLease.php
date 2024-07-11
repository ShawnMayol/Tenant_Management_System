<?php
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming JSON input is correctly formatted and contains all necessary fields
$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    die();
}

// Extract variables from JSON input
$startDate = $input['startDate'];
$endDate = $input['endDate'];
$billPeriod = $input['billPeriod'];
$apartmentNumber = $input['apartmentNum'];
$tenantID = $input['tenant_ID'];

// Include database connection file
include('../../core/database.php');

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO lease (tenant_ID, apartmentNumber, startDate, endDate, billingPeriod) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error]);
    die();
}

// Bind parameters
$stmt->bind_param("iisss", $tenantID, $apartmentNumber, $startDate, $endDate, $billPeriod);

// Execute the insert query
if ($stmt->execute()) {
    // Get lease ID
    $leaseID = $conn->insert_id;
    // Close the statement after execution
    $stmt->close();
    echo json_encode(['success' => true, 'lease_ID' => $leaseID]);
} else {
    // Handle insert query failure
    echo json_encode(['success' => false, 'message' => 'Failed to add lease: ' . $stmt->error]);
    $stmt->close();
}

// Close database connection
$conn->close();

