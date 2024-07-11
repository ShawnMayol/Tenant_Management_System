<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input data
function sanitize($data) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, $data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = sanitize($_POST['firstName']);
    $middleName = sanitize($_POST['middleName']);
    $lastName = sanitize($_POST['lastName']);
    $dateOfBirth = sanitize($_POST['dateOfBirth']);
    $gender = sanitize($_POST['gender']);
    $emailAddress = sanitize($_POST['emailAddress']);
    $phoneNumber = sanitize($_POST['phoneNumber']);
    $termsOfStay = sanitize($_POST['termsOfStay']);
    $startDate = sanitize($_POST['startDate']);
    $endDate = sanitize($_POST['endDate']);
    $billingPeriod = sanitize($_POST['billingPeriod']);
    $numOccupants = sanitize($_POST['numOccupants']);
    $message = sanitize($_POST['message']);
    $requestDate = date('Y-m-d');
    $requestStatus = 'Pending';
    $apartmentNumber = sanitize($_POST['apartmentNumber']);

    // Handling file upload
    $uploadDir = __DIR__ . '/../../App/uploads/request/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it does not exist
    }

    $uploadFile = $uploadDir . basename($_FILES['documentImage']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if file is an actual image
    $check = getimagesize($_FILES['documentImage']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (5MB max)
    if ($_FILES['documentImage']['size'] > 5000000) {
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
        if (move_uploaded_file($_FILES['documentImage']['tmp_name'], $uploadFile)) {
            $requestBin = $uploadFile;

            // Insert data into database
            $sql = "INSERT INTO request (apartmentNumber, firstName, middleName, lastName, dateOfBirth, phoneNumber, emailAddress, requestDate, requestBin, requestStatus, termsOfStay, startDate, endDate, billingPeriod, occupants, note, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("isssssssssssssiss", $apartmentNumber, $firstName, $middleName, $lastName, $dateOfBirth, $phoneNumber, $emailAddress, $requestDate, $requestBin, $requestStatus, $termsOfStay, $startDate, $endDate, $billingPeriod, $numOccupants, $message, $gender);

                if ($stmt->execute()) {
                    echo "Request submitted successfully.";
                    // Redirect to the apartment details page
                    header("Location: ../../views/tenant/requestPending.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();

