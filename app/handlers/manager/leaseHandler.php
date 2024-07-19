<?php
session_start();
include '../../core/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $managerPassword = $_POST['managerPassword'];
    if(isset($_POST['requestID'])) {
        $requestID = $_POST['requestID'];
    } else {
        $requestID = '';
    }

    $apartmentNumber = $_POST['apartmentNumber'];
    //$rentPerMonth = $_POST['rentPerMonth'];         
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $billingPeriod = $_POST['billingPeriod'];
    $advanceDeposit = $_POST['advDeposit'];       
    $securityDeposit = $_POST['securityDeposit'];
    $leaseStatus = 'Active';

    $lesseeFirstName = $_POST['lesseeFirstName'];
    $lesseeMiddleName = $_POST['lesseeMiddleName'];
    $lesseeLastName = $_POST['lesseeLastName'];
    $lesseeDOB = $_POST['lesseeDOB'];
    $lesseeGender = $_POST['lesseeGender'];
    $lesseePhone = $_POST['lesseePhone'];
    $lesseeEmail = $_POST['lesseeEmail'];

    $occupantFirstName = $_POST['occFirstName'];
    $occupantMiddleName = $_POST['occMiddleName'];
    $occupantLastName = $_POST['occLastName'];
    $occupantDOB = $_POST['occDOB'];
    $occupantGender = $_POST['occGender'];
    $occupantPhone = $_POST['occPhone'];
    $occupantEmail = $_POST['occEmail'];

    // Fetch manager's password hash from the database
    $userID = $_SESSION['user_id'];
    $sql = "SELECT staff_ID, password, userRole FROM user WHERE user_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($staffID, $hashedPassword, $role);
    $stmt->fetch();
    $stmt->close();

    $redirectPage = '';
    if ($role == 'Admin') {
        $redirectPage = '../../index.php?page=admin.requests';
    } elseif ($role == 'Manager') {
        $redirectPage = '../../index.php?page=manager.requests';
    } else {
        $redirectPage = '../../index.php';
    }

    // Verify the manager's password
    if (password_verify($managerPassword, $hashedPassword)) {
        // Update request status to Approved
        if(isset($_POST['requestID'])) {
            $status = 'Approved';
            $stmt = $conn->prepare("UPDATE request SET requestStatus = ? WHERE request_ID = ?");
            $stmt->bind_param("si", $status, $requestID);
            $stmt->execute();
            $stmt->close();
        }

        // Insert lease information
        $stmt = $conn->prepare("INSERT INTO lease (apartmentNumber, startDate, endDate, billingPeriod, securityDeposit, reviewedBy, rentalDeposit) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdid", $apartmentNumber, $startDate, $endDate, $billingPeriod, $securityDeposit, $staffID, $advanceDeposit);
        $stmt->execute();
        $leaseID = $stmt->insert_id; // Get the auto-generated lease ID
        $stmt->close();

        // // Generate monthly bills
        // $startDateTime = new DateTime($startDate);
        // $dueDate = clone $startDateTime; // Start from the lease start date
        // $dueDate->modify('+1 month'); // First bill due date is one month after the start date
        // $endDateTime = new DateTime($endDate);

        // $stmt = $conn->prepare("INSERT INTO bill (lease_ID, amountDue, dueDate) VALUES (?, ?, ?)");
        // $stmt->bind_param("iss", $leaseID, $rentPerMonth, $dueDateStr);

        // while ($dueDate <= $endDateTime) {
        //     $dueDateStr = $dueDate->format('Y-m-d');
        //     $stmt->execute();
        //     // Capture the first bill ID
        //     if ($dueDate == clone $startDateTime->modify('+1 month')) {
        //         $firstBillID = $stmt->insert_id;
        //     }
        //     $dueDate->modify('+1 month');
        // }
        // $stmt->close();
        
        // $stmt = $conn->prepare("INSERT INTO payments (bill_ID, paymentAmount, receivedBy, paymentDate, paymentStatus) VALUES (?, ?, ?, NOW(), 'Received')");
        // $stmt->bind_param("isi", $firstBillID, $rentalDeposit, $staffID);
        // $stmt->execute();
        // $stmt->close();

        // Update apartment status to 'Occupied' and set availableBy to end date of lease
        $stmt = $conn->prepare("UPDATE apartment SET apartmentStatus = 'Occupied', availableBy = ? WHERE apartmentNumber = ?");
        $stmt->bind_param("si", $endDate, $apartmentNumber);
        $stmt->execute();
        $stmt->close();

        // Insert lessee information
        $stmt = $conn->prepare("INSERT INTO tenant (lease_ID, firstName, lastName, middleName, dateOfBirth, gender, phoneNumber, emailAddress, tenantType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Lessee')");
        $stmt->bind_param("isssssss", $leaseID, $lesseeFirstName, $lesseeLastName, $lesseeMiddleName, $lesseeDOB, $lesseeGender, $lesseePhone, $lesseeEmail);
        $stmt->execute();
        $lesseeTenantID = $stmt->insert_id; // Get the auto-generated tenant ID for the lessee
        $stmt->close();

        // Prepare default values
        $username = $lesseeFirstName . $lesseeLastName . $requestID; // Assuming requestID is available
        $password = password_hash($lesseeFirstName . $lesseeLastName . $requestID, PASSWORD_DEFAULT); // Assuming requestID is available

        // Insert user 
        $sql = "INSERT INTO user (tenant_ID, username, password, userRole, picDirectory)
                VALUES (?, ?, ?, 'Tenant', '../../uploads/tenant/placeholder.jpg')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $lesseeTenantID, $username, $password);
        $stmt->execute();
        $stmt->close();

        // Insert occupants information
        $numOccupants = count($occupantFirstName); // Number of occupants
        for ($i = 0; $i < $numOccupants; $i++) {
            $stmt = $conn->prepare("INSERT INTO tenant (lease_ID, firstName, lastName, middleName, dateOfBirth, gender, phoneNumber, emailAddress, tenantType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Occupant')");
            $stmt->bind_param("isssssss", $leaseID, $occupantFirstName[$i], $occupantLastName[$i], $occupantMiddleName[$i], $occupantDOB[$i], $occupantGender[$i], $occupantPhone[$i], $occupantEmail[$i]);
            $stmt->execute();
            $stmt->close();
        }

        // Log activity in the activity table
        $activityDescription = "Approved lease $leaseID";
        $insertActivitySql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
        $insertActivityStmt = $conn->prepare($insertActivitySql);
        $insertActivityStmt->bind_param("is", $staffID, $activityDescription);
        $insertActivityStmt->execute();
        $insertActivityStmt->close();
?>
        <script>
            alert("Lease has been successfully finalized.");
            window.location.href = '<?php echo $redirectPage; ?>';
        </script>
<?php
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
