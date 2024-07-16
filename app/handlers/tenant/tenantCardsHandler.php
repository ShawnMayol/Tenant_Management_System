<?php
    include ('core/database.php');
    
    $loggedInUserID = $_SESSION['user_id'] ?? null;

    // Fetch total number of available apartments
    // $availableCount = 0;
    // $sql = "SELECT COUNT(*) as availableCount FROM apartment WHERE apartmentStatus = 'available'";
    // if ($stmt = $conn->prepare($sql)) {
    //     $stmt->execute();
    //     $stmt->bind_result($availableCount);
    //     $stmt->fetch();
    //     $stmt->close();
    // } else {
    //     echo "Error: " . $conn->error;
    // }
    
    // $amountApartment = 0;
    // $sql = "SELECT COUNT(*) as amountApartment 
    //         FROM lease le JOIN user us ON le.tenant_ID = us.tenant_ID
    //         WHERE us.user_ID = $loggedInUserID";
    // if ($stmt = $conn->prepare($sql)) {
    //     $stmt->execute();
    //     $stmt->bind_result($amountApartment);
    //     $stmt->fetch();
    //     $stmt->close();
    // } else {
    //     echo "Error: " . $conn->error;
    // }
?>