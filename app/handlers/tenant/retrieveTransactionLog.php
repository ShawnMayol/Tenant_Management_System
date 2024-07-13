<?php
include ('core/database.php');

$loggedInUserID = $_SESSION['user_id'] ?? null;

// Check if user ID is set and valid
if (!$loggedInUserID) {
    die("User ID not set or invalid.");
}

// SQL query to retrieve payment history
$sql = "SELECT *
        FROM bill bi
        JOIN transactionlog tr ON tr.bill_ID = bi.bill_ID
        JOIN user us ON tr.user_ID = us.user_ID
        WHERE us.user_ID = $loggedInUserID
        ORDER BY tr.transaction_ID DESC";
$result = $conn->query($sql);

$bill = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bill[] = $row;
    }
} else {
    $bill = [];
}

$conn->close();
?>
