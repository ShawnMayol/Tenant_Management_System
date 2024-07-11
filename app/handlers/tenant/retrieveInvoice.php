<?php
include ('core/database.php'); // Ensure this file includes your database connection

// Validate session user ID
$loggedInUserID = $_SESSION['user_id'] ?? null;
if (!$loggedInUserID) {
    die("Session user ID not found.");
}

// Query to fetch invoices with associated apartment details based on user ID
$sql = "SELECT  i.invoice_ID, f.rent, f.tax, f.maintenance, f.totalAmount, i.dueDate, l.apartmentNumber, a.apartmentAddress, 
                t.phoneNumber, t.emailAddress, t.firstName, t.middleName, t.lastName, ROUND(((f.rent + f.maintenance) * 0.05), 2) AS legitTax, i.dateIssued
        FROM invoice i
        JOIN fees f ON i.fee_ID = f.fee_ID
        JOIN lease l ON f.lease_ID = l.lease_ID
        JOIN apartment a ON l.apartmentNumber = a.apartmentNumber
        JOIN tenant t ON l.tenant_ID = t.tenant_ID
        JOIN user u ON t.tenant_ID = u.tenant_ID
        WHERE u.user_ID = $loggedInUserID
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
