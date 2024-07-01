<?php
session_start();

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

// Function to sanitize input to prevent SQL injection
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from session
    $loggedInUserID = $_SESSION['user_id'];

    // Get old password, new password, and confirm password from form
    $oldPassword = sanitizeInput($_POST['oldPassword']);
    $newPassword = sanitizeInput($_POST['newPassword']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);

    // Query to fetch current password from database
    $query = "SELECT password FROM user WHERE user_ID = $loggedInUserID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentPassword = $row['password'];

        // Verify old password
        if (password_verify($oldPassword, $currentPassword)) {
            // Validate new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Hash new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update password in the database
                $updateQuery = "UPDATE user SET password = '$hashedPassword' WHERE user_ID = $loggedInUserID";

                if ($conn->query($updateQuery) === TRUE) {
                    echo '<script>alert("Password updated successfully."); window.location.href = "index.php";</script>';
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo '<script>alert("New password and confirm password do not match."); window.location.href = "index.php";</script>';
            }
        } else {
            echo '<script>alert("Incorrect old password."); window.location.href = "index.php";</script>';
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
