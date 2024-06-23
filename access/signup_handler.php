<?php
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

// Check if POST data is set
if (isset($_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['birthDate'], $_POST['phoneNumber'], $_POST['email'], $_POST['password'])) {
    // Retrieve and sanitize form data
    $first_name = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middleName']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastName']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birthDate']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_input = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format."); window.location.href = "registration.html";</script>';
        exit();
    }

    // Hash the password
    $password_hashed = password_hash($password_input, PASSWORD_DEFAULT);

    // Prepare and bind statement using prepared statement to prevent SQL injection
    $sql = "INSERT INTO users (first_name, middle_name, last_name, birth_date, phone_number, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $middle_name, $last_name, $birth_date, $phone_number, $email, $password_hashed);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Account Created. Please Log In"); window.location.href = "login.html";</script>';
        } else {
            echo '<script>alert("Error: ' . mysqli_stmt_error($stmt) . '"); window.location.href = "registration.html";</script>';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo '<script>alert("Error preparing statement: ' . mysqli_error($conn) . '"); window.location.href = "registration.html";</script>';
    }

    // Close the connection
    mysqli_close($conn);

} else {
    echo '<script>alert("Required fields are missing."); window.location.href = "registration.html";</script>';
    exit();
}

