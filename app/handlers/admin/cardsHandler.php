<?php
    include ('core/database.php');

    // Fetch total number of available apartments
    $availableCount = 0;
    $sql = "SELECT COUNT(*) as availableCount FROM apartment WHERE apartmentStatus = 'available'";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result($availableCount);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Fetch total number of active tenants
    $totalTenantsCount = 0;
    $sql = "SELECT COUNT(*) as totalTenantsCount FROM tenant WHERE tenantStatus = 'active'";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result($totalTenantsCount);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }


    // Fetch total number of pending requests
    $totalRequestsPending = 0;
    $sql = "SELECT COUNT(*) as totalRequestsPending FROM request WHERE requestStatus = 'Pending'";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result($totalRequestsPending);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }