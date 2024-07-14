<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_ID'])) {
    $user_ID = $_POST['user_ID'];

    // Fetch user details
    $userSql = "SELECT * FROM user WHERE user_ID = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("i", $user_ID);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    if ($user) {
        $firstName = '';
        $lastName = '';

        // Fetch tenant details if the user is associated with a tenant
        if (!empty($user['tenant_ID'])) {
            $tenantSql = "SELECT * FROM tenant WHERE tenant_ID = ?";
            $tenantStmt = $conn->prepare($tenantSql);
            $tenantStmt->bind_param("i", $user['tenant_ID']);
            $tenantStmt->execute();
            $tenantResult = $tenantStmt->get_result();
            $tenant = $tenantResult->fetch_assoc();

            if ($tenant) {
                $firstName = $tenant['firstName'];
                $lastName = $tenant['lastName'];
            } else {
                echo "Tenant not found.";
                exit;
            }
        } elseif (!empty($user['staff_ID'])) {
            // Fetch staff details if the user is associated with a staff
            $staffSql = "SELECT * FROM staff WHERE staff_ID = ?";
            $staffStmt = $conn->prepare($staffSql);
            $staffStmt->bind_param("i", $user['staff_ID']);
            $staffStmt->execute();
            $staffResult = $staffStmt->get_result();
            $staff = $staffResult->fetch_assoc();

            if ($staff) {
                $firstName = $staff['firstName'];
                $lastName = $staff['lastName'];
            } else {
                echo "Staff not found.";
                exit;
            }
        } else {
            echo "User is not associated with any tenant or staff.";
            exit;
        }

        // Set default username and password
        $defaultUsername = $firstName . $lastName . $user_ID;
        $defaultPassword = password_hash($firstName . $lastName . $user_ID, PASSWORD_DEFAULT);

        // Update user details
        $updateSql = "UPDATE user SET username = ?, password = ? WHERE user_ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssi", $defaultUsername, $defaultPassword, $user_ID);

        if ($updateStmt->execute()) {
            // echo "Account reset successfully.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        } else {
            // echo "Error updating record: " . $conn->error;
            header("Location: {$_SERVER['HTTP_REFERER']}?error=" . urlencode('Error resetting account'));
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
