<?php
// Database connection details
include 'database.php';

// Data for the staff account
$firstName = 'John';
$lastName = 'Doe';
$middleName = 'Smith';
$dateOfBirth = '1990-01-15'; // Example date of birth
$phoneNumber = '1234567890';
$emailAddress = 'john.doe@example.com';
$staffRole = 'Admin'; // Adjust the role as needed

// Hashed password for the user account
$hashedPassword = password_hash('admin', PASSWORD_DEFAULT); // Hashed password, adjust as needed

// Prepare SQL statement for staff insertion
$sqlStaff = "INSERT INTO staff (firstName, lastName, middleName, dateOfBirth, phoneNumber, emailAddress, staffRole) 
             VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmtStaff = $conn->prepare($sqlStaff);
$stmtStaff->bind_param("sssssss", $firstName, $lastName, $middleName, $dateOfBirth, $phoneNumber, $emailAddress, $staffRole);

// Execute staff insertion and handle errors
if ($stmtStaff->execute()) {
    $staff_id = $stmtStaff->insert_id; // Get the auto-generated staff_ID
    echo "Staff account created successfully with ID: $staff_id<br>";
    
    // Prepare SQL statement for user insertion
    $sqlUser = "INSERT INTO user (tenant_ID, staff_ID, username, password, userStatus, userRole) 
                VALUES (NULL, ?, 'admin', ?, 'Offline', 'Admin')";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("is", $staff_id, $hashedPassword);

    // Execute user insertion and handle errors
    if ($stmtUser->execute()) {
        $user_id = $stmtUser->insert_id; // Get the auto-generated user_ID
        echo "User account created successfully with ID: $user_id";
    } else {
        echo "Error creating user account: " . $stmtUser->error;
    }

    $stmtUser->close();
} else {
    echo "Error creating staff account: " . $stmtStaff->error;
}

$stmtStaff->close();
$conn->close();
?>
