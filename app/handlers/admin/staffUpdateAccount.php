<?php
session_start();
include('../../core/database.php');

// Function to sanitize input to prevent SQL injection
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loggedInUserID = $_SESSION['user_id'];

    // Handle profile picture upload
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../../uploads/staff/";
        $fileName = basename($_FILES["profilePic"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)) {
                // Update file path in database
                $updatePicQuery = "UPDATE user SET picDirectory = '$targetFilePath' WHERE user_ID = $loggedInUserID";
                if ($conn->query($updatePicQuery) === TRUE) {
                    $_SESSION['picDirectory'] = $targetFilePath; // Update session variable
                } else {
                    echo "Error updating profile picture: " . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
        }
    }

    // Get and update other form fields
    if (isset($_POST['username'])) {
        $newUsername = sanitizeInput($_POST['username']);
        $updateUsernameQuery = "UPDATE user SET username = '$newUsername' WHERE user_ID = $loggedInUserID";
        if ($conn->query($updateUsernameQuery) !== TRUE) {
            echo "Error updating username: " . $conn->error;
        }
    }

    if (isset($_POST['phoneNumber'])) {
        $newPhoneNumber = sanitizeInput($_POST['phoneNumber']);
        $updatePhoneNumberQuery = "UPDATE staff SET phoneNumber = '$newPhoneNumber' WHERE staff_ID IN (SELECT staff_ID FROM user WHERE user_ID = $loggedInUserID)";
        if ($conn->query($updatePhoneNumberQuery) !== TRUE) {
            echo "Error updating phone number: " . $conn->error;
        }
    }

    if (isset($_POST['emailAddress'])) {
        $newEmail = sanitizeInput($_POST['emailAddress']);
        $updateEmailQuery = "UPDATE staff SET emailAddress = '$newEmail' WHERE staff_ID IN (SELECT staff_ID FROM user WHERE user_ID = $loggedInUserID)";
        if ($conn->query($updateEmailQuery) !== TRUE) {
            echo "Error updating email address: " . $conn->error;
        }
    }

    // Redirect user based on role after update
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
            echo 'error';
    }
}

$conn->close();
?>
