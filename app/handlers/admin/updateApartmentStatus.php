<?php
// Check if apartment number and status were provided in the URL and POST request
if (isset($_GET['apartment']) && isset($_POST['statusSelect'])) {
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

    $apartmentNumber = $_GET['apartment'];
    $newStatus = $_POST['statusSelect'];

    // Prepare and execute SQL update statement
    $sql = "UPDATE apartment SET apartmentStatus = ? WHERE apartmentNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $newStatus, $apartmentNumber);

    if ($stmt->execute()) {
        // Redirect back to admin.apartments page with apartment number as query parameter
        header('Location: ../../index.php?page=admin.viewApartment&apartment=' . $apartmentNumber);
        exit();
    } else {
        // Handle error
        echo "Error updating apartment status: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle case where apartment number or statusSelect was not provided
    echo "Apartment number or statusSelect not specified.";
}
?>
