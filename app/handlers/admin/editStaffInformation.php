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
    $staff_ID = $_POST['staff_ID'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];

    // Prepare update statement
    $updateSql = "UPDATE staff SET firstName=?, middleName=?, lastName=?, dateOfBirth=? WHERE staff_ID=?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssi", $firstName, $middleName, $lastName, $dateOfBirth, $staff_ID);

    // Execute update statement
    if ($updateStmt->execute()) {
        // Redirect back to previous page with success message
        header("Location: {$_SERVER['HTTP_REFERER']}?success=" . urlencode('Staff information updated successfully.'));
    } else {
        // Redirect back to previous page with error message
        header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Error updating staff information.'));
    }

    // Close connection
    $conn->close();
} else {
    // Handle invalid request
    header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Invalid request.'));
}
?>
