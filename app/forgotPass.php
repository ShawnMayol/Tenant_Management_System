<?php

session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection (Replace with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "tms";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize input to prevent SQL injection
    $emailForgot = $conn->real_escape_string($_POST['emailForgot']);

    // Check if the email exists in the database
    $sql = "SELECT * FROM tenant WHERE emailAddress = '$emailForgot'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email exists, show the new password form
        $_SESSION['emailForgot'] = $emailForgot;
        echo '<script>showNotification("Email exists. Redirecting to new password form.", "success");</script>';
        header("Location: login.php?login[page]=form.newpass");
        exit(); // Ensure no further script execution
    } else {
        // Email does not exist, redirect back with error
        $_SESSION['error'] = "Email does not exist.";
        echo '<script>showNotification("Email does not exist.", "danger");</script>';
        header("Location: login.php?login[page]=form.forgot");
        exit(); // Ensure no further script execution
    }

    $conn->close();
}
?>
