<?php
// Include database connection
include '../../core/database.php';

// Check if form was submitted and handle POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs (add more validation as needed)
    $apartmentNumber = $_POST['apartmentNumber'];
    $apartmentType = $_POST['apartmentType'];
    $rentPerMonth = $_POST['rentPerMonth'];
    $apartmentDimensions = $_POST['apartmentDimensions'];
    $apartmentAddress = $_POST['apartmentAddress'];
    $maxOccupants = $_POST['maxOccupants'];
    $apartmentDescription = $_POST['apartmentDescription'];
    
    // Update query
    $sql = "UPDATE apartment 
        SET apartmentType = ?, rentPerMonth = ?, apartmentDimensions = ?, apartmentAddress = ?, maxOccupants = ?, apartmentDescription = ?
        WHERE apartmentNumber = ?";

    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo 'Prepare statement error: ' . $conn->error;
        exit;
    }
    
    // Bind parameters
    $stmt->bind_param('sdsdsdi', $apartmentType, $rentPerMonth, $apartmentDimensions, $apartmentAddress, $maxOccupants, $apartmentDescription, $apartmentNumber);
    
    // Execute statement
    if ($stmt->execute()) {
        // Success: Redirect or handle success message
        header('Location: ../../index.php?page=admin.viewApartment&apartment=' . $apartmentNumber);
        exit;
    } else {
        // Error: Handle error message
        echo 'Error updating apartment: ' . $stmt->error;
    }
    
    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect or handle invalid form submission
    header('Location: ../../index.php?page=admin.viewApartment&apartment=' . $apartmentNumber);
    exit;
}
?>
