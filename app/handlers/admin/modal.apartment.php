<?php
// Include database connection
include 'core/database.php';

// Check if apartmentNumber is set and numeric
if (isset($_GET['apartment']) && is_numeric($_GET['apartment'])) {
    $apartmentNumber = $_GET['apartment'];

    // Fetch apartment details from database
    $sql = "SELECT apartmentType, rentPerMonth, apartmentDimensions, apartmentAddress, maxOccupants, apartmentDescription
        FROM apartment
        WHERE apartmentNumber = ?";

    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $apartmentNumber);
    $stmt->execute();
    $stmt->store_result();
    
    // Bind result variables
    $stmt->bind_result($apartmentType, $rentPerMonth, $apartmentDimensions, $apartmentAddress, $maxOccupants, $apartmentDescription);
    
    // Fetch apartment details
    if ($stmt->fetch()) {
        // Apartment details found, store in array
        $apartmentDetails = [
            'apartmentType' => $apartmentType,
            'rentPerMonth' => $rentPerMonth,
            'apartmentDimensions' => $apartmentDimensions,
            'apartmentAddress' => $apartmentAddress,
            'maxOccupants' => $maxOccupants,
            'apartmentDescription' => $apartmentDescription
        ];
    } else {
        // No apartment found with the given ID
        // Handle error or redirect back
        exit('Apartment not found');
    }
    
    $stmt->close();
} else {
    // Redirect or handle invalid apartmentNumber
    exit('Invalid apartment number');
}
