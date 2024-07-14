<?php
session_start();

// Include database connection file
include('../../core/database.php');

// Check if the admin is logged in and if the user_ID is provided
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_POST['user_ID'])) {
    $user_ID = $_POST['user_ID'];

    // Delete user from the database
    $deleteUserSql = "DELETE FROM user WHERE user_ID = ?";
    $deleteUserStmt = $conn->prepare($deleteUserSql);
    $deleteUserStmt->bind_param("i", $user_ID);

    if ($deleteUserStmt->execute()) {
        // Redirect to admin dashboard with success message
        header("Location: ../../index.php?page=admin.staff");
        exit();
    } else {
        // Redirect to admin dashboard with error message
        header("Location: ../../index.php?page=admin.staff");
        exit();
    }
} else {
    // Invalid request
    echo "Invalid request.";
    exit();
}
?>
