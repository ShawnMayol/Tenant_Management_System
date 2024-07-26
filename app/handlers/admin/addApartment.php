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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $apartmentType = $_POST['apartmentType'];
    $rentPerMonth = $_POST['rentPerMonth'];
    $apartmentDimensions = $_POST['apartmentDimensions'];
    $apartmentAddress = $_POST['apartmentAddress'];
    $maxOccupants = $_POST['maxOccupants'];
    $apartmentStatus = $_POST['apartmentStatus'];
    $apartmentDescription = $_POST['apartmentDescription'];

    // Handle file upload
    $targetDir = "../../uploads/apartment/";
    $targetFile = $targetDir . basename($_FILES["apartmentImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["apartmentImage"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
        die("File is not an image.");
    }

    // Check file size
    if ($_FILES["apartmentImage"]["size"] > 99999999) {
        $uploadOk = 0;
        die("Sorry, your file is too large.");
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png");
    if (!in_array($imageFileType, $allowedExtensions)) {
        $uploadOk = 0;
        die("Sorry, only JPG, JPEG, & PNG");
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        die("Sorry, your file was not uploaded.");
    } else {
        if (move_uploaded_file($_FILES["apartmentImage"]["tmp_name"], $targetFile)) {
            $apartmentPictures = $targetFile;

            // Insert data into database
            $sql = "INSERT INTO apartment (apartmentType, rentPerMonth, apartmentDimensions, apartmentAddress, maxOccupants, apartmentStatus, apartmentPictures, apartmentDescription) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare statement
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bind_param("sdssisss", $apartmentType, $rentPerMonth, $apartmentDimensions, $apartmentAddress, $maxOccupants, $apartmentStatus, $apartmentPictures, $apartmentDescription);

            // Execute statement
            if ($stmt->execute()) {
                header("Location: ../../index.php?page=admin.apartments");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }
}

?>
