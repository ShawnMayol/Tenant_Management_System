<?php
session_start();
// Ensure that request_id and current_status are received
if (isset($_GET['request_id'], $_GET['current_status'])) {
    $requestID = $_GET['request_id'];
    $currentStatus = $_GET['current_status'];

    // Staff id
    $staffID = $_SESSION['staff_id'];

    // Determine the new status
    $newStatus = ($currentStatus === 'Pinned') ? 'Pending' : 'Pinned';
    $activityDescription = ($newStatus === 'Pinned') ? "Pinned request $requestID" : "Unpinned request $requestID";

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

    // Prepare and execute SQL update query for request status
    $sql = "UPDATE `request` SET `requestStatus` = ? WHERE `request_ID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $requestID);

    if ($stmt->execute() === TRUE) {
        // Prepare and execute SQL insert query for activity log
        $sqlActivity = "INSERT INTO `activity` (`staff_ID`, `activityDescription`) VALUES (?, ?)";
        $stmtActivity = $conn->prepare($sqlActivity);
        $stmtActivity->bind_param("is", $staffID, $activityDescription);

        if ($stmtActivity->execute() === TRUE) {
            echo "Status updated and activity logged successfully";
        } else {
            echo "Error logging activity: " . $stmtActivity->error;
        }
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $stmtActivity->close();
    $conn->close();

    // Redirect back to the previous page (optional)
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    echo "Invalid request";
}
?>
