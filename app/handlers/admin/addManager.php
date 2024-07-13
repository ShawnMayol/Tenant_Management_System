<?php
include '../../core/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];
    $emailAddress = $_POST['emailAddress'];

    // Insert into staff table
    $sql = "INSERT INTO staff (firstName, middleName, lastName, dateOfBirth, phoneNumber, emailAddress, staffStatus, staffRole)
            VALUES (?, ?, ?, ?, ?, ?, 'Inactive', 'Manager')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $middleName, $lastName, $dateOfBirth, $phoneNumber, $emailAddress);

    if ($stmt->execute()) {
        $staff_ID = $stmt->insert_id;

        // Create user account
        $username = $firstName . $lastName . $staff_ID;
        $password = password_hash($firstName . $lastName . $staff_ID, PASSWORD_DEFAULT);
        $userRole = 'Manager';

        $sql = "INSERT INTO user (staff_ID, username, password, userRole, picDirectory) VALUES (?, ?, ?, ?, '../../uploads/staff/placeholder.jpg')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $staff_ID, $username, $password, $userRole);

        if ($stmt->execute()) {
            // Insert activity record
            $activityDescription = 'Account created';
            $sql = "INSERT INTO activity (staff_ID, activityDescription) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $staff_ID, $activityDescription);
            $stmt->execute();
            
            header("Location: ../../index.php?page=admin.staff");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
