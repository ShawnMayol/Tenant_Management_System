<?php
include ('core/database.php'); // Adjust the path as necessary

// Retrieve tenant ID from the session
$loggedInUserID = $_SESSION['user_id'] ?? null;

$apartment = null;

if ($loggedInUserID) {
    // Fetch apartment data for the logged-in user
    $sql = "
        SELECT *
        FROM user us 
        JOIN tenant te ON us.tenant_ID = te.tenant_ID
        JOIN lease le ON te.tenant_ID = le.tenant_ID
        JOIN apartment a ON le.apartmentNumber = a.apartmentNumber
        WHERE us.user_ID = $loggedInUserID
        LIMIT 1
    ";
    $result = $conn->query($sql);

    // Fetch the apartment information
    if ($result->num_rows > 0) {
        $apartment = $result->fetch_assoc();
    } else {
        error_log("No apartment found for user ID $loggedInUserID");
    }

    $result->close();
} else {
    error_log("User ID not found in session");
}
$conn->close();
?>
