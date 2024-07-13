<?php
session_start();
// Include database connection file
include('../../core/database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $announcementID = $_POST['editAnnouncementID'];
    $announcementTarget = $_POST['announcementTarget'];
    $announcementTitle = $_POST['announcementTitle'];
    $announcementContent = $_POST['announcementContent'];
    $staff_id = $_SESSION['staff_id']; // Assume you have the staff ID stored in the session

    // Prepare the SQL update statement
    $sql = "UPDATE announcement SET target = ?, title = ?, content = ? WHERE announcement_ID = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssi", $announcementTarget, $announcementTitle, $announcementContent, $announcementID);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Log the activity
            $activityDescription = "Edit announcement " . $announcementID;
            $logSql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
            $logStmt = $conn->prepare($logSql);
            $logStmt->bind_param("is", $staff_id, $activityDescription);
            $logStmt->execute();
            $logStmt->close();

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
