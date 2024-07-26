<?php
session_start();
include '../../core/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminPassword = $_POST['adminPassword'];
    $managerID = $_POST['staff_id']; // Assuming you pass manager's ID via POST
    $adminID = $_SESSION['staff_id']; // Assuming you have admin's ID stored in session

    // Validate admin password
    $sql = "SELECT password FROM user WHERE staff_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $adminID);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the admin's password
    if (password_verify($adminPassword, $hashedPassword)) {
        // Update manager's status to Fired
        $status = 'Fired';
        $updateSql = "UPDATE staff SET staffStatus = ? WHERE staff_ID = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $status, $managerID); // Use $managerID for manager's ID
        $stmt->execute();
        $stmt->close();

        // Log activity in the activity table
        $activityDescription = "Fired manager ID $managerID"; // Corrected to use $managerID
        $insertActivitySql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $insertActivityStmt = $conn->prepare($insertActivitySql);
        $insertActivityStmt->bind_param("is", $adminID, $activityDescription); // Use $adminID for admin's ID
        $insertActivityStmt->execute();
        $insertActivityStmt->close();

        // Log activity in the activity table
        $managerDescription = "Account deactivated"; // Corrected to use $managerID
        $insertManagerSql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $insertManagerStmt = $conn->prepare($insertManagerSql);
        $insertManagerStmt->bind_param("is", $managerID, $managerDescription);
        $insertManagerStmt->execute();
        $insertManagerStmt->close();

        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        echo "Invalid admin password. Please try again.";
        // You can redirect or display an error message as needed
    }
} else {
    echo "Invalid request method.";
    // Handle invalid request method
}

$conn->close();
?>
