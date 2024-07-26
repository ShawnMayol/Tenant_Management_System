<?php
// Initialize the session
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Get the user ID from session
    $user_id = $_SESSION['user_id'];

    // Include the database connection
    include('../../core/database.php'); // Adjust path as needed

    // Set the user's status to Offline
    $updateUserStatusSql = "UPDATE user SET userStatus = 'Offline' WHERE user_ID = ?";
    $updateUserStatusStmt = $conn->prepare($updateUserStatusSql);
    $updateUserStatusStmt->bind_param("i", $user_id);
    $updateUserStatusStmt->execute();

    // Fetch staff ID from user table
    $fetchStaffIdSql = "SELECT staff_ID FROM user WHERE user_ID = ?";
    $fetchStaffIdStmt = $conn->prepare($fetchStaffIdSql);
    $fetchStaffIdStmt->bind_param("i", $user_id);
    $fetchStaffIdStmt->execute();
    $fetchStaffIdResult = $fetchStaffIdStmt->get_result();

    // Fetch staff ID from user table if staff_id is not NULL
    $fetchStaffIdSql = "SELECT staff_ID FROM user WHERE user_ID = ? AND staff_ID IS NOT NULL";
    $fetchStaffIdStmt = $conn->prepare($fetchStaffIdSql);
    $fetchStaffIdStmt->bind_param("i", $user_id);
    $fetchStaffIdStmt->execute();
    $fetchStaffIdResult = $fetchStaffIdStmt->get_result();

    // Check if the user is a staff member
    if($fetchStaffIdResult->num_rows === 1) {
        $user = $fetchStaffIdResult->fetch_assoc();
        $staff_id = $user['staff_ID'];

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
header("Location: ../../views/common/landing.php");
exit;
?>
