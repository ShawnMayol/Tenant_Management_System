<?php

include('../../core/database.php');

session_start();

if (!isset($_SESSION['tenant_id'])) {
    echo "Tenant not authenticated.";
    exit;
}

$tenant_id = $_SESSION['tenant_id'];
$apartmentNumber = isset($_POST['apartmentNumber']) ? intval($_POST['apartmentNumber']) : null;
$maintenanceType = isset($_POST['maintenanceType']) ? trim($_POST['maintenanceType']) : null;
$description = isset($_POST['description']) ? trim($_POST['description']) : null;

if ($apartmentNumber === null || $maintenanceType === null || $description === null) {
    echo "All fields are required.";
    exit;
}

$sql = "INSERT INTO maintenancerequests (tenant_ID, apartmentNumber, maintenanceType, description, requestDate, status)
        VALUES (?, ?, ?, ?, NOW(), 'Pending')";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Error preparing the statement: " . $conn->error;
    exit;
}

$stmt->bind_param("iiss", $tenant_id, $apartmentNumber, $maintenanceType, $description);

if ($stmt->execute()) {
    header("Location: ../../index.php?page=tenant.maintenance");
    exit;
} else {
    echo "Error executing the statement: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>
