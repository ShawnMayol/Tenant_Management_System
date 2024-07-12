<?php 
    include ('core/database.php');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve payment proof records
    $sql = "SELECT * FROM paymentproof";
    $result = $conn->query($sql);
?>