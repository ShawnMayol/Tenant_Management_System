<?php
session_start();
// Include database connection
include('../../core/database.php');

$staff_id = $_SESSION['staff_id']; // Replace with actual staff ID from session or authentication

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs (assuming they are required and not empty)
    $announcementTarget = $_POST['announcementTarget'];
    $announcementTitle = $_POST['announcementTitle'];
    $announcementContent = $_POST['announcementContent'];

    // Insert announcement into database
    $sql = "INSERT INTO announcement (target, title, content, created_at, staff_id) VALUES (?, ?, ?, current_timestamp(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $announcementTarget, $announcementTitle, $announcementContent, $staff_id);

    if ($stmt->execute()) {
        // Announcement successfully posted
        $announcementID = $stmt->insert_id; // Get the ID of the inserted announcement
        $stmt->close();

        // Log the activity
        $activityDescription = "Post announcement " . $announcementID;
        $logSql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("is", $staff_id, $activityDescription);
        $logStmt->execute();
        $logStmt->close();

        $conn->close();
        
        // Redirect back to the page
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        // Error inserting announcement
        $stmt->close();
        $conn->close();
        
        // Redirect with error message (if needed)
        header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Error posting announcement'));
        exit;
    }
} else {
    // Handle case where form was not submitted via POST
    header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Invalid request method'));
    exit;
}
?>
