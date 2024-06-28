<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Database connection
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

// Get input data
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'];
$email = $input['email'];

// Update user email
$sql = "UPDATE users SET email=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $email, $id);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = $stmt->error;
}

echo json_encode($response);

$stmt->close();
$conn->close();

