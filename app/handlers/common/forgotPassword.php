<?php

session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../../core/database.php');

    // Sanitize input to prevent SQL injection
    $emailForgot = $conn->real_escape_string($_POST['emailForgot']);

    // Check if the email exists in the database
    $sql = "SELECT * FROM tenant WHERE emailAddress = '$emailForgot'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email exists, show the new password form
        $_SESSION['emailForgot'] = $emailForgot;
        header("Location: ../../views/common/login.php?login[page]=login.newPassword");
        exit(); // Ensure no further script execution
    } else {
        // Email does not exist, redirect back with error
        $_SESSION['error'] = "Email does not exist.";
        header("Location: ../../views/common/login.php?login[page]=login.forgotPassword");
        exit(); // Ensure no further script execution
    }

    $conn->close();
}
?>
