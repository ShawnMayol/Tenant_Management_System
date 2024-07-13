<?php
session_start();
// Include database connection file
include('../../core/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the announcement ID and staff ID from the form
    $announcementID = $_POST['announcementID'];
    $staffID = $_SESSION['staff_id']; // Assuming staffID is stored in session after login

    // Prepare the SQL delete statement
    $sql = "DELETE FROM announcement WHERE announcement_ID = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the announcement ID to the prepared statement as a parameter
        $stmt->bind_param("i", $announcementID);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Log the activity
            $activityDescription = "Delete announcement " . $announcementID;
            $logSql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
            
            if ($logStmt = $conn->prepare($logSql)) {
                $logStmt->bind_param("is", $staffID, $activityDescription);
                $logStmt->execute();
                $logStmt->close();
            }

            // Redirect to the announcements page with a success message
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            // Redirect to the announcements page with an error message
            header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Error posting announcement'));
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect to the announcements page with an error message if the statement couldn't be prepared
        header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Invalid request method'));
        exit();
    }
}

// Close the database connection
$conn->close();
?>
