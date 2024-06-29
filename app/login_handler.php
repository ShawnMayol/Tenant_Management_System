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

// Check if POST data is set
if (isset($_POST['email'], $_POST['password'])) {
    // Retrieve and sanitize form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_input = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare and execute the SQL statement to retrieve the hashed password and user details
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "s", $email);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Store the result
        mysqli_stmt_store_result($stmt);

        // Check if email exists
        if (mysqli_stmt_num_rows($stmt) == 1) {
            // Bind the result variables
            mysqli_stmt_bind_result($stmt, $user_id, $email, $password_hashed);

            // Fetch the result
            mysqli_stmt_fetch($stmt);

            // Verify the password
            if (password_verify($password_input, $password_hashed)) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;

                // Check if user is admin (assuming admin ID is 1)
                if ($user_id == 1) {
                    $_SESSION['is_admin'] = true;
                } else {
                    $_SESSION['is_admin'] = false;
                }

                // Redirect based on role
                if ($_SESSION['is_admin']) {
                    header("Location: index.php");
                } else {
                    header("Location: index.php");  // merged for now
                }
                exit();
            } else {
                // Incorrect password
                echo '<script>alert("Incorrect password. Please try again."); window.location.href = "login.php";</script>';
            }
        } else {
            // Email not found
            echo '<script>alert("Email not found. Please try again."); window.location.href = "login.php";</script>';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error preparing statement
        echo '<script>alert("Error preparing statement: ' . mysqli_error($conn) . '"); window.location.href = "login.php";</script>';
    }

    // Close the connection
    mysqli_close($conn);

} else {
    // Required fields are missing
    echo '<script>alert("Required fields are missing."); window.location.href = "login.php";</script>';
    exit();
}
