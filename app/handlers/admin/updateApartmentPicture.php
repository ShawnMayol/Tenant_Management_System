<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$apartmentNumber = $_GET['apartment'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted and file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["apartmentImage"])) {
    // File upload path
    $targetDir = "../../uploads/apartment/";
    $targetFile = $targetDir . basename($_FILES["apartmentImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["apartmentImage"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["apartmentImage"]["size"] > 99999999) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png");
    if (!in_array($imageFileType, $allowedExtensions)) {
        die("Sorry, only JPG, JPEG, & PNG");
        $uploadOk = 0;
    }

    
    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["apartmentImage"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, update database

            // Update SQL query
            $sql = "UPDATE apartment SET apartmentPictures = ? WHERE apartmentNumber = ?";
            
            // Prepare statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $targetFile, $apartmentNumber);
            
            // Execute statement
            if ($stmt->execute()) {
                // Redirect back to the page displaying updated image
                header('Location: ../../index.php?page=admin.viewApartment&apartment=' . $apartmentNumber);
                exit;
            } else {
                echo "Error updating apartment picture: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
