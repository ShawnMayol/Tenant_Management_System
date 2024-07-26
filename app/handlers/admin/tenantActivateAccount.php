<?php
session_start();

// Include database connection file
include('../../core/database.php');

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_POST['tenant_id'])) {
    $tenant_id = $_POST['tenant_id'];
    // echo $tenant_id;

    // Update the userStatus to 'Deactivated' in the user table
    $updateUserStatusSql = "UPDATE user SET userStatus = 'Offline' WHERE tenant_ID = ?";
    $updateUserStatusStmt = $conn->prepare($updateUserStatusSql);
    $updateUserStatusStmt->bind_param("i", $tenant_id);
    if ($updateUserStatusStmt->execute()) {
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
