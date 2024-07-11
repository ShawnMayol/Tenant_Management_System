<?php
include('core/database.php'); // Include your database connection script

// Validate session user ID (assuming you have session handling)
$loggedInUserID = $_SESSION['user_id'] ?? null;
if (!$loggedInUserID) {
    die("Session user ID not found.");
}

// Query to fetch bills with outstanding balance calculation based on user ID
$sql = "SELECT b.bill_ID, b.invoice_ID, b.paymentMethod, b.amountPaid, b.overpayment, b.paymentDate, b.outstandingBalance
        FROM bill b
        LEFT JOIN invoice i ON b.invoice_ID = i.invoice_ID
        LEFT JOIN fees f ON i.fee_ID = f.fee_ID
        LEFT JOIN lease l ON f.lease_ID = l.lease_ID
        LEFT JOIN tenant t ON l.tenant_ID = t.tenant_ID
        LEFT JOIN user u ON t.tenant_ID = u.tenant_ID
        WHERE u.user_ID = $loggedInUserID";

$result = $conn->query($sql);

$bills = [];
if ($result === false) {
    echo "Error: " . $conn->error;
} elseif ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bills[] = $row;
    }
} else {
    echo "No bills found.";
}

$conn->close();
?>
