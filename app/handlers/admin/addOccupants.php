<?php

include('../../core/database.php');

// Check if 'occupants' key exists in $_POST and decode JSON data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['occupants']) || !is_array($data['occupants'])) {
    die("Error: No valid occupants data received.");
}

$occupants = $data['occupants'];

// Process each occupant
foreach ($occupants as $occupant) {
    $leaseID = intval($occupant['lease_ID']);
    $firstName = htmlspecialchars($occupant['firstName']);
    $middleName = htmlspecialchars($occupant['middleName']);
    $lastName = htmlspecialchars($occupant['lastName']);
    $gender = htmlspecialchars($occupant['gender']);
    $phone = htmlspecialchars($occupant['phone']);
    $email = htmlspecialchars($occupant['email']);

    // Perform database insertion or other operations with $firstName, $middleName, etc.
    // Example: Insert into database
    // $sql = "INSERT INTO occupants (firstName, middleName, lastName, gender, phone, email) VALUES ('$firstName', '$middleName', '$lastName', '$gender', '$phone', '$email')";
    // Execute SQL statement

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO occupants (lease_ID, firstName, middleName, lastName, gender, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("issssss", $leaseID, $firstName, $middleName, $lastName, $gender, $phone, $email);
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();


// Send a response back to the client
$response = [
    'success' => true,
    'message' => 'Occupants data received and processed successfully'
];

header('Content-Type: application/json');
echo json_encode($response);
