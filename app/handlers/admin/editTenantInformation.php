<?php
// Ensure the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection details
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

    // Retrieve and sanitize input data
    $tenant_ID = $_POST['tenant_ID'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];

    // Prepare update statement
    $updateSql = "UPDATE tenant SET firstName=?, middleName=?, lastName=?, dateOfBirth=? WHERE tenant_ID=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssi", $firstName, $middleName, $lastName, $dateOfBirth, $tenant_ID);

    // Execute update statement
    if ($updateStmt->execute()) {
        // Redirect back to previous page with success message
        header("Location: {$_SERVER['HTTP_REFERER']}?success=" . urlencode('Tenant information updated successfully.'));
    } else {
        // Redirect back to previous page with error message
        header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Error updating tenant information.'));
    }

    // Close connection
    $conn->close();
} else {
    // Handle invalid request
    header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Invalid request.'));
}
?>
