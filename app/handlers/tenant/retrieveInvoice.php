<?php
include ('core/database.php'); // Ensure this file includes your database connection

// Validate session user ID
$loggedInUserID = $_SESSION['user_id'] ?? null;

// Query to fetch invoices with associated apartment details and bill items based on user ID
$sql = "SELECT  *
        FROM invoice i
        JOIN fees f ON i.fee_ID = f.fee_ID
        JOIN lease l ON f.lease_ID = l.lease_ID
        JOIN apartment a ON l.apartmentNumber = a.apartmentNumber
        JOIN tenant t ON l.tenant_ID = t.tenant_ID
        JOIN user u ON t.tenant_ID = u.tenant_ID
        WHERE u.user_ID = $loggedInUserID
        ORDER BY i.dueDate DESC";

$result = $conn->query($sql);

$invoice = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $invoice[] = $row;
    }
} else {
    $invoice = [];
}

$sql = "SELECT *
        FROM bill bi
        JOIN invoice inv ON bi.invoice_ID = bi.invoice_ID
        JOIN fees fe ON inv.fee_ID = fe.fee_ID
        JOIN lease le ON fe.lease_ID = le.lease_ID
        JOIN tenant te ON le.tenant_ID = te.tenant_ID
        JOIN user us ON te.tenant_ID = us.tenant_ID
        WHERE us.user_ID = $loggedInUserID
        ";
$result = $conn->query($sql);

$billItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $billItems[] = $row;
    }
} else {
    $billItems = [];
}

$conn->close();
