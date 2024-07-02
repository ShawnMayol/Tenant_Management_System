<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms_v2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $middleName = $conn->real_escape_string($_POST['middleName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $birthDate = $conn->real_escape_string($_POST['birthDate']);
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
    $email = $conn->real_escape_string($_POST['email']);

    // Handling file upload
    if (isset($_FILES['formFileMultiple']) && $_FILES['formFileMultiple']['error'][0] == UPLOAD_ERR_OK) {
        $target_dir = "../../database/uploads/";
        $file_names = [];
        foreach ($_FILES['formFileMultiple']['name'] as $key => $name) {
            $target_file = $target_dir . basename($name);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file size
            if ($_FILES['formFileMultiple']['size'][$key] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES['formFileMultiple']['tmp_name'][$key], $target_file)) {
                    $file_names[] = $target_file;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        $idAttachment = implode(',', $file_names);

        // Insert data into database
        $sql = "INSERT INTO clients (first_name, middle_name, last_name, birth_date, phone_number, email, id_attachment)
                VALUES ('$firstName', '$middleName', '$lastName', '$birthDate', '$phoneNumber', '$email', '$idAttachment')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No file uploaded or file upload error.";
    }

    $conn->close();
}
