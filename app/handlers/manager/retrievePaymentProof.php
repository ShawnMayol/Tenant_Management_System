<?php 
include ('core/database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loggedInUserID = $_SESSION['user_id'] ?? null;

// Retrieve payment proof records
$sql = "SELECT *
        FROM paymentproof
        ORDER BY 
            CASE 
                WHEN status = 'pending' THEN 1
                ELSE 2
            END,
            uploadDate DESC";
$result = $conn->query($sql);

if (!$result) {
    echo "Error executing query: " . $conn->error;
    exit;
}

// Retrieve staff ID for the logged-in user
if ($loggedInUserID) {
    $staffQuery = "SELECT st.staff_ID
                   FROM user us
                   JOIN staff st ON us.staff_ID = st.staff_ID
                   WHERE us.user_ID = ?";
    $stmt = $conn->prepare($staffQuery);
    $stmt->bind_param("i", $loggedInUserID);
    $stmt->execute();
    $stmt->bind_result($staffID);
    $stmt->fetch();
    $stmt->close();
}
?>
