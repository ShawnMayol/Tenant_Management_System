<?php
include('../../core/database.php');

// Start the session
session_start();

// Get the logged-in user's ID from the session
$loggedInUserID = $_SESSION['user_id'] ?? null;

// Check if the required POST variables are set
if (isset($_POST['paymentId']) && isset($_POST['status'])) {
    $paymentId = $_POST['paymentId'];
    $status = $_POST['status'];
    $billId = $_POST['billId'];
    $note = isset($_POST['note']) ? $_POST['note'] : null;

    // Validate and sanitize input
    $paymentId = intval($paymentId);
    $status = htmlspecialchars($status);
    $billId = htmlspecialchars($billId);
    $note = $note ? htmlspecialchars($note) : null;

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

    // Prepare the update statement for the payment
    $stmt = $conn->prepare("UPDATE payments SET paymentStatus = ?, receivedBy = ?, note = ? WHERE payment_ID = ?");
    $stmt->bind_param("sisi", $status, $staffID, $note,$paymentId);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo 'Success';
    } else {
        echo 'Error';
    }

    $stmt->close();

    // If the payment status is "Received", update the bill status
    if ($status === 'Received') {
        $stmt = $conn->prepare("UPDATE bill SET billStatus = 'Paid' WHERE bill_ID = ?");
        $stmt->bind_param("i", $billId);

        // Execute the statement and check if it was successful
        if (!$stmt->execute()) {
            echo 'Error updating bill status.';
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo 'Invalid request';
}

