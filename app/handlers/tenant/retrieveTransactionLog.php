<?php
// Database connection
include ('core/database.php');

$loggedInUserID = $_SESSION['user_id'] ?? null;

// SQL query to retrieve payment history
$sql = "SELECT bi.bill_ID, bi.paymentMethod, bi.amountPaid, bi.overpayment, bi.paymentDate 
        FROM bill bi, user us, transactionlog tr
        WHERE   us.user_ID = $loggedInUserID
                AND us.user_ID = tr.user_ID
                AND tr.bill_ID = bi.bill_ID
        ORDER BY bi.paymentDate DESC";
$result = $conn->query($sql);

$paymentHistory = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $paymentHistory[] = $row;
    }
} else {
    $paymentHistory = [];
}

$conn->close();
?>
