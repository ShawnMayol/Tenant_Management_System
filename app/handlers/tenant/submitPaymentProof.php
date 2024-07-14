<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Get form data
    $invoice_ID = $_POST['invoice_ID'];
    $paymentMethod = $_POST['paymentMethod'];
    $uploadDate = date('Y-m-d H:i:s'); // Current date and time
    $status = 'pending'; // Initial status

    // File upload handling
    $targetDir = "../../uploads/paymentProof/"; // Directory for file uploads

    // Check if the directory exists, if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = basename($_FILES["proofFile"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["proofFile"]["tmp_name"], $targetFilePath)) {
            // Insert file path into database
            $stmt = $conn->prepare("INSERT INTO paymentproof (invoice_ID, paymentMethod, imageProof, uploadDate, status) VALUES (?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die('MySQL prepare error: ' . $conn->error);
            }

            $stmt->bind_param("issss", $invoice_ID, $paymentMethod, $targetFilePath, $uploadDate, $status);
            if ($stmt->execute()) {
                // Success
                echo "Comment and proof of payment uploaded successfully.";
                // Redirect or show success message as needed
            } else {
                // Error
                echo "Error uploading comment: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.";
    }

    // Close database connection
    $conn->close();

} else {
    // If form was not submitted
    echo "Form submission error.";
}
?>
