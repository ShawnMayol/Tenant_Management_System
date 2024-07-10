<?php
// Initialize the session
session_start();

// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    // Get the user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch staff ID from user table
    include('../../core/database.php'); // Adjust path as needed
    $fetchStaffIdSql = "SELECT staff_ID FROM user WHERE user_ID = ?";
    $fetchStaffIdStmt = $conn->prepare($fetchStaffIdSql);
    $fetchStaffIdStmt->bind_param("i", $user_id);
    $fetchStaffIdStmt->execute();
    $fetchStaffIdResult = $fetchStaffIdStmt->get_result();

    if($fetchStaffIdResult->num_rows === 1) {
        $user = $fetchStaffIdResult->fetch_assoc();
        $staff_id = $user['staff_ID'];

        // Update staffStatus to 'Inactive' in the staff table
        $updateStatusSql = "UPDATE staff SET staffStatus = 'Inactive' WHERE staff_ID = ?";
        $updateStatusStmt = $conn->prepare($updateStatusSql);
        $updateStatusStmt->bind_param("i", $staff_id);
        $updateStatusStmt->execute();

        // Log the logout activity
        $activityDescription = "Logout";
        $logActivitySql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $logActivityStmt = $conn->prepare($logActivitySql);
        $logActivityStmt->bind_param("is", $staff_id, $activityDescription);
        $logActivityStmt->execute();
    }

    // Close connection
    $conn->close();
}

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to landing page
header("location: ../../views/common/landing.php");
exit;
?>