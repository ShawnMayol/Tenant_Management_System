<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input (optional but recommended)
    $paymentProofID = $_POST['paymentProofID'];
    $status = $_POST['status']; // Should be either 'accepted' or 'declined'
    $staffID = $_POST['staffID']; // Get the staffID from the form

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE paymentProof SET status = ?, staff_ID = ? WHERE paymentProof_ID = ?");
    if ($stmt === false) {
        die('Error: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sii", $status, $staffID, $paymentProofID);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Success message
        echo "Payment status and staff ID updated successfully";
    } else {
        // Error message
        echo "Error updating payment status and staff ID: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
