<?php
include ('core/database.php');

$loggedInUserID = $_SESSION['user_id'] ?? null;

// Check if user ID is set and valid
if (!$loggedInUserID) {
    die("User ID not set or invalid.");
}

// SQL query to retrieve payment history
$sql = "SELECT p.*, CONCAT(s.firstName,' ',s.lastName) AS Staff
        FROM payments p
        JOIN bill b ON b.bill_ID = p.bill_ID
        JOIN lease l ON l.lease_ID = b.lease_ID
        JOIN tenant t ON t.lease_ID = b.lease_ID
        LEFT JOIN staff s ON s.staff_ID = p.receivedBy
        JOIN user us ON us.tenant_ID = t.tenant_ID
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

