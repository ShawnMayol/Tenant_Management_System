<?php
session_start();

// Check if the email is set in session
if (!isset($_SESSION['emailForgot'])) {
    header("Location: ../../views/common/login.php?login[page]=login.forgotPassword");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../../core/database.php');

    // Function to safely escape input
    function sanitize_input($conn, $input) {
        return $conn->real_escape_string($input);
    }

    // Sanitize input to prevent SQL injection
    $newPassword = sanitize_input($conn, $_POST['newPassword']);
    $confirmPassword = sanitize_input($conn, $_POST['confirmPassword']);

    // Check if passwords match
    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in the database
        $emailForgot = $_SESSION['emailForgot'];
        $sql = "UPDATE user SET password = '$hashedPassword' WHERE tenant_ID = (SELECT tenant_ID FROM tenant WHERE emailAddress = '$emailForgot')";
        
        if ($conn->query($sql) === TRUE) {
            // Password updated successfully, redirect to login with success message
            $_SESSION['success'] = "Password has been changed successfully.";
            header("Location: ../../views/common/login.php?login[page]=login.formInput");
            exit();
        } else {
            // Error updating password
            $_SESSION['error'] = "Error updating password.";
            header("Location: ../../views/common/login.php?login[page]=login.newPassword");
            exit();
        }
    } else {
        // Passwords do not match
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../../views/common/login.php?login[page]=login.newPassword");
        exit();
    }
}

