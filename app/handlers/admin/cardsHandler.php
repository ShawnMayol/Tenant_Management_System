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

    // Fetch total number of users whose leases are active
    $totalUsers = 0;
    $sql = "SELECT COUNT(*) as totalUsers 
            FROM user u
            INNER JOIN tenant t ON u.tenant_ID = t.tenant_ID
            INNER JOIN lease l ON t.lease_ID = l.lease_ID
            WHERE l.leaseStatus = 'active'";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result($totalUsers);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }



    // Fetch total number of pending requests
    $totalRequestsPending = 0;
    $sql = "SELECT COUNT(*) as totalRequestsPending FROM request WHERE requestStatus IN ('Pending', 'Pinned')";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result($totalRequestsPending);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Fetch total number of active managers
    $activeManagersCount = 0;
    $sql = "SELECT COUNT(*) as activeManagersCount FROM staff WHERE staffRole = 'Manager' AND staffStatus = 'Active'";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $stmt->bind_result($activeManagersCount);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }