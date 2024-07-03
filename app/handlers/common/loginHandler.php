<?php
// Establish database connection (Replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "tms";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input to prevent SQL injection
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Query to fetch user details based on username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User found, fetch user data
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start session and store user data
            session_start();
            unset($_GET['login']['page']);
            $_SESSION['user_id'] = $user['user_ID'];
            $_SESSION['role'] = $user['userRole'];

            // Redirect based on user role
            if ($user['userRole'] == 'Admin') {
                header("Location: ../../index.php?dashboard[role]=admin.dashboard");
                exit();
            } else if ($user['userRole'] == 'Manager' ) {
                header("Location: ../../index.php?dashboard[role]=manager.dashboard");
                exit();
            } else if ($user['userRole'] == 'Tenant') {
                header("Location: ../../index.php?dashboard[role]=tenant.dashboard");
                exit();
            } else {
                echo "Unknown user role.";
            }
        } else {
            // Password is incorrect
            echo '<script>alert("Password is incorrect. Please try again."); window.location.href = "../../views/common/login.php?index[page]=login.formInput";</script>';
        }
    } else {
        // User not found
        echo '<script>alert("User not found. Please try again."); window.location.href = "../../views/common/login.php?index[page]=login.formInput";</script>';
    }
} else {
    // Redirect to login page if accessed directly without POST data
    header("Location: ../../views/common/login.php?index[page]=login.formInput");
    exit();
}

$conn->close();
?>
