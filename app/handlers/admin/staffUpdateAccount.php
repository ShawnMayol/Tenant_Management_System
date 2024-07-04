<?php
session_start();

include('../../core/database.php');


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

        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../../index.php?page=admin.dashboard");
                break;
            case 'manager':
                header("Location: ../../index.php?page=manager.dashboard");
                break;
            case 'tenant':
                header("Location: ../../index.php?page=tenant.dashboard");
                break;
            default:
                echo('error');
        }

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
    $updatePhoneNumberQuery = "UPDATE staff SET phoneNumber = '$newPhoneNumber' WHERE staff_ID IN (SELECT staff_ID FROM user WHERE user_ID = $loggedInUserID)";

    if ($conn->query($updatePhoneNumberQuery) === TRUE) {
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../../index.php?page=admin.dashboard");
                break;
            case 'manager':
                header("Location: ../../index.php?page=manager.dashboard");
                break;
            case 'tenant':
                header("Location: ../../index.php?page=tenant.dashboard");
                break;
            default:
                echo('error');
        }
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
    $updateEmailAddressQuery = "UPDATE staff SET emailAddress = '$newEmail' WHERE staff_ID IN (SELECT staff_ID FROM user WHERE user_ID = $loggedInUserID)";

    if ($conn->query($updateEmailAddressQuery) === TRUE) {
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../../index.php?page=admin.dashboard");
                break;
            case 'manager':
                header("Location: ../../index.php?page=manager.dashboard");
                break;
            case 'tenant':
                header("Location: ../../index.php?page=tenant.dashboard");
                break;
            default:
                echo('error');
        }
    } else {
        echo "Error updating phone number: " . $conn->error;
    }
}


$conn->close();
?>
