<?php
include ('core/database.php'); // Ensure this file includes your database connection

// Validate session user ID
$loggedInUserID = $_SESSION['user_id'] ?? null;

// Query to fetch invoices with associated apartment details based on user ID
$sql = "SELECT  *, ROUND(((f.rent + f.maintenance) * 0.05), 2) AS legitTax
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
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $invoice[] = $row;
        }
    } else {
        echo "No invoices found.";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

return $invoice;
?>