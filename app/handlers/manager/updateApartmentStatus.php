<?php
// Start the session
session_start();

// Check if apartment number and status were provided in the URL and POST request
if (isset($_GET['apartment']) && isset($_POST['statusSelect'])) {
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

    $apartmentNumber = $_GET['apartment'];
    $newStatus = $_POST['statusSelect'];
    $availableBy = isset($_POST['availableBy']) ? $_POST['availableBy'] : null;
    $staffID = $_SESSION['staff_id'];

    if ($newStatus == 'Maintenance' && empty($availableBy)) {
        echo "Available by date must be provided for maintenance status.";
        exit();
    }

    // Prepare SQL update statement
    if ($newStatus == 'Maintenance') {
        $sql = "UPDATE apartment SET apartmentStatus = ?, availableBy = ? WHERE apartmentNumber = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $newStatus, $availableBy, $apartmentNumber);
    } else {
        $sql = "UPDATE apartment SET apartmentStatus = ?, availableBy = NULL WHERE apartmentNumber = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $newStatus, $apartmentNumber);
    }

    if ($stmt->execute()) {
        // Log the activity
        $activityDescription = sprintf("Changed apartment %d status to %s", $apartmentNumber, $newStatus ? $newStatus : 'N/A');
        $activitySql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $activityStmt = $conn->prepare($activitySql);
        $activityStmt->bind_param('is', $staffID, $activityDescription);
        $activityStmt->execute();
        $activityStmt->close();

        // Redirect back to manager.viewApartment page with apartment number as query parameter
        header('Location: ../../index.php?page=manager.viewApartment&apartment=' . $apartmentNumber);
        exit();
    } else {
        // Handle error
        echo "Error updating apartment status: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle case where apartment number or statusSelect was not provided
    echo "Apartment number or statusSelect not specified.";
}
?>
