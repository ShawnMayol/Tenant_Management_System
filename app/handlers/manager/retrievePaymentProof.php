<?php 
include('core/database.php');

$loggedInUserID = $_SESSION['user_id'] ?? null;

// Retrieve payment proof records along with invoice and fees data
$sql = "SELECT p.*, CONCAT(t.firstName,' ',t.lastName) AS 'Name'
        FROM payments p
        JOIN bill b ON b.bill_ID = p.bill_ID
        JOIN tenant t ON t.lease_ID = b.lease_ID
        WHERE p.paymentStatus = 'Pending' AND t.tenantType = 'Lessee'";
$result = $conn->query($sql);

if (!$result) {
    echo "Error executing query: " . $conn->error;
    exit;
}

// Retrieve staff ID for the logged-in user
$staffID = null;
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
