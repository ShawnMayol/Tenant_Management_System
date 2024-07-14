<?php
session_start();

// Include database connection file
include('../../core/database.php');

// Check if the admin is logged in and if the staff_id is provided
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];
    // echo $staff_id;

    // Update the userStatus to 'Deactivated' in the user table
    $updateUserStatusSql = "UPDATE user SET userStatus = 'Offline' WHERE staff_ID = ?";
    $updateUserStatusStmt = $conn->prepare($updateUserStatusSql);
    $updateUserStatusStmt->bind_param("i", $staff_id);
    if ($updateUserStatusStmt->execute()) {
        // Log the deactivation activity
        $activityDescription = "Account Activated";
        $logActivitySql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $logActivityStmt = $conn->prepare($logActivitySql);
        $logActivityStmt->bind_param("is", $staff_id, $activityDescription);
        $logActivityStmt->execute();

        // Redirect to the admin dashboard with a success message
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // Redirect to the admin dashboard with an error message
        header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Error deactivating account'));
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
