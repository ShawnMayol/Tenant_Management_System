<?php
include ('core/database.php');

// Fetch announcements
function fetchAnnouncements($conn) {
    $sql = "SELECT a.title, a.content, a.created_at, CONCAT(s.firstName, ' ', s.lastName) as staff_name 
            FROM announcement a
            JOIN staff s ON a.staff_id = s.staff_ID
            ORDER BY a.created_at DESC";
    $result = $conn->query($sql);

    $announcements = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $announcements[] = $row;
        }
    }
    return $announcements;
}

$announcements = fetchAnnouncements($conn);

$conn->close();
?>
