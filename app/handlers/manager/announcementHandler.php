<?php
session_start();
include('../../core/database.php');

$staff_id = $_SESSION['staff_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $announcementTarget = $_POST['announcementTarget'];
    $announcementTitle = $_POST['announcementTitle'];
    $announcementContent = $_POST['announcementContent'];

    $sql = "INSERT INTO announcement (target, title, content, created_at, staff_id) VALUES (?, ?, ?, current_timestamp(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $announcementTarget, $announcementTitle, $announcementContent, $staff_id);

    if ($stmt->execute()) {
        $announcementID = $stmt->insert_id;
        $stmt->close();

        // Log the activity
        $activityDescription = "Post announcement " . $announcementID;
        $logSql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("is", $staff_id, $activityDescription);
        $logStmt->execute();
        $logStmt->close();

        $conn->close();
        
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        $stmt->close();
        $conn->close();
        
        header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Error posting announcement'));
        exit;
    }
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Invalid request method'));
    exit;
}
?>
