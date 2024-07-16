<?php
session_start();
include '../../core/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $managerPassword = $_POST['managerPassword'];
    $requestID = $_POST['requestID'];

    // Fetch manager's password from the database
    $userID = $_SESSION['user_id'];
    $sql = "SELECT staff_ID, password, userRole FROM user WHERE user_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($staffID, $hashedPassword, $userRole);
    $stmt->fetch();
    $stmt->close();

    // Verify the manager's password
    if (password_verify($managerPassword, $hashedPassword)) {
        // Update the request status to 'Rejected'
        $updateSql = "UPDATE request SET requestStatus = 'Rejected' WHERE request_ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $requestID);
        $result = $updateStmt->execute();
        $updateStmt->close();

        if ($result) {
            // Log activity in the activity table
            $activityDescription = "Rejected request $requestID";
            $insertActivitySql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
            $insertActivityStmt = $conn->prepare($insertActivitySql);
            $insertActivityStmt->bind_param("is", $staffID, $activityDescription);
            $insertActivityStmt->execute();
            $insertActivityStmt->close();

            // Determine the redirection URL based on userRole
            $redirectUrl = ($userRole === 'admin') ? '../../index.php?page=admin.requests' : '../../index.php?page=manager.requests';
?>
            <script>
                window.location.href = '<?php echo $redirectUrl; ?>';
            </script>
<?php
        } else {
?>
            <script>
                alert("Failed to reject the request.");
            </script>
<?php
        }
    } else {
?>
        <script>
            alert("Invalid password. Please try again.");
        </script>
<?php
    }
} else {
?>
    <script>
        alert("Invalid request method.");
    </script>
<?php
}

$conn->close();
?>
