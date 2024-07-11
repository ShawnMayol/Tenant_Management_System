<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $apartmentNumber = $conn->real_escape_string($_POST['apartment-num']);
    $requestDate = $conn->real_escape_string($_POST['reqDate']);
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $middleName = $conn->real_escape_string($_POST['middleName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $birthDate = $conn->real_escape_string($_POST['birthDate']);
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
    $email = $conn->real_escape_string($_POST['email']);

    // Check if the apartment number exists in the apartments table
    $check_apartment = "SELECT apartmentNumber FROM apartment WHERE apartmentNumber = '$apartmentNumber'";
    $result = $conn->query($check_apartment);

    if ($result->num_rows == 0) {
        die("Error: Apartment number does not exist.");
    }

    // Handling file upload
    $uploadOk = 1;
    $file_names = [];

    if (isset($_FILES['formFileMultiple'])) {
        $fileCount = count($_FILES['formFileMultiple']['name']);

        // Limit to only 2 files
        if ($fileCount > 2) {
            echo "You can only upload a maximum of 2 files.";
            $uploadOk = 0;
        } else {
            $target_dir = "../../TMSv6/App/uploads/request/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            foreach ($_FILES['formFileMultiple']['name'] as $key => $name) {
                if ($_FILES['formFileMultiple']['error'][$key] == UPLOAD_ERR_OK) {
                    $target_file = $target_dir . basename($name);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check file size
                    if ($_FILES['formFileMultiple']['size'][$key] > 500000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 1) {
                        if (move_uploaded_file($_FILES['formFileMultiple']['tmp_name'][$key], $target_file)) {
                            $file_names[] = $target_file;
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                            $uploadOk = 0;
                        }
                    }
                } else {
                    echo "File upload error: " . $_FILES['formFileMultiple']['error'][$key];
                    $uploadOk = 0;
                }
            }

            if ($uploadOk == 1) {
                $idAttachment = implode(',', $file_names);

                // Insert data into database
                $sql = "INSERT INTO request (apartmentNumber, firstName, middleName, lastName, dateOfBirth, phoneNumber, emailAddress, requestBin, requestDate)
                         VALUES ('$apartmentNumber', '$firstName', '$middleName', '$lastName', '$birthDate', '$phoneNumber', '$email', '$idAttachment','$requestDate')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                    // Redirect to pending.php
                    header("Location: ../../views/common/req_pending.php");
                    exit(); // Ensure that no further code is executed after the redirect
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } else {
        echo "No file uploaded or file upload error.";
    }

    $conn->close();
}

