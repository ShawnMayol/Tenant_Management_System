<?php
include ('core/database.php'); // Ensure this file includes your database connection

// Validate session user ID
$loggedInUserID = $_SESSION['user_id'] ?? null;
if (!$loggedInUserID) {
    die("Session user ID not found.");
}
echo $loggedInUserId;


// Query to fetch invoices
$sql = "SELECT i.invoice_ID, f.rent, f.tax, f.maintenance, f.totalAmount, i.dueDate
        FROM invoice i
        JOIN fees f ON i.fee_ID = f.fee_ID
        JOIN lease l ON f.lease_ID = l.lease_ID
        WHERE l.tenant_ID = $loggedInUserID
        ORDER BY i.dueDate DESC";

$result = $conn->query($sql);

$invoices = [];
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $invoices[] = $row;
        }
    } else {
        echo "No invoices found.";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

// Return invoices array for inclusion in tenant.invoice.php
return $invoices;
?>
