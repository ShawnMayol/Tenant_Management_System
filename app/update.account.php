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

// Check if form is submitted for username update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    // Get new username from form
    $newUsername = sanitizeInput($_POST['username']);
    $loggedInUserID = $_SESSION['user_id'];

    // Update username in the database
    $updateUsernameQuery = "UPDATE user SET username = '$newUsername' WHERE user_ID = $loggedInUserID";

    if ($conn->query($updateUsernameQuery) === TRUE) {
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error updating username: " . $conn->error;
    }
}

// Check if form is submitted for phone number update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['phoneNumber'])) {
    // Get new phone number from form
    $newPhoneNumber = sanitizeInput($_POST['phoneNumber']);
    $loggedInUserID = $_SESSION['user_id'];

    // Update phone number in the database
    $updatePhoneNumberQuery = "UPDATE tenant SET phoneNumber = '$newPhoneNumber' WHERE tenant_ID IN (SELECT tenant_ID FROM user WHERE user_ID = $loggedInUserID)";

    if ($conn->query($updatePhoneNumberQuery) === TRUE) {
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error updating phone number: " . $conn->error;
    }
}

// Check if form is submitted for email update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emailAddress'])) {
    // Get email address from form
    $newEmail = sanitizeInput($_POST['emailAddress']);
    $loggedInUserID = $_SESSION['user_id'];

    // Update email in the database
    $updateEmailAddressQuery = "UPDATE tenant SET emailAddress = '$newEmail' WHERE tenant_ID IN (SELECT tenant_ID FROM user WHERE user_ID = $loggedInUserID)";

    if ($conn->query($updateEmailAddressQuery) === TRUE) {
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error updating phone number: " . $conn->error;
    }
}


$conn->close();
?>
