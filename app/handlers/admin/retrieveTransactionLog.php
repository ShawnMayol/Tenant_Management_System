<?php
include ('core/database.php');

$loggedInUserID = $_SESSION['user_id'] ?? null;

// Check if user ID is set and valid
if (!$loggedInUserID) {
    die("User ID not set or invalid.");
}

// SQL query to retrieve payment history
$sql = "SELECT p.*, CONCAT(s.firstName,' ',s.lastName) AS Staff
        FROM payments p,
             user us
        JOIN staff s ON s.staff_ID = us.user_ID
        WHERE us.user_ID = $loggedInUserID
        ORDER BY p.payment_ID DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$paymentsLog = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $paymentsLog[] = $row;
    }
} else {
    $paymentsLog = [];
}

$conn->close();

