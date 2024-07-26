<?php
session_start();
include '../../core/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Check if a file has been uploaded
if (isset($_FILES['proofOfPayment']) && $_FILES['proofOfPayment']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['proofOfPayment']['tmp_name'];
    $fileName = $_FILES['proofOfPayment']['name'];
    $fileSize = $_FILES['proofOfPayment']['size'];
    $fileType = $_FILES['proofOfPayment']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'pdf');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $uploadDir = '../../uploads/payment/';
        $dest_path = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {

            // Query bills associated with the lease
            $billSql = "SELECT b.* 
            FROM bill b
            JOIN tenant t ON t.lease_ID = b.lease_ID
            JOIN user us ON us.tenant_ID = t.tenant_ID
            WHERE us.user_ID = ? AND b.billStatus = 'Pending'
            ORDER BY b.bill_ID DESC
            LIMIT 1";

            $retbillStmt = $conn->prepare($billSql);
            $retbillStmt->bind_param("i", $user_id);
            $retbillStmt->execute();
            $billResult = $retbillStmt->get_result();

            $retBill = null;
            if ($billResult->num_rows > 0) {
                $retBill = $billResult->fetch_assoc();
            }

            $retbillStmt->close();
            $bill_ID = $retBill['bill_ID'];
            $totalAmount = $retBill['amountDue'] + $retBill['lateFees'];

            // File uploaded successfully
            // Save file information to the database
            $sql = "INSERT INTO payments (bill_ID,paymentAmount,proofOfPayment,paymentDate) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ids",$bill_ID,$totalAmount,$dest_path);

            if ($stmt->execute()) {
                echo "File is successfully uploaded and saved to database.";
            } else {
                echo "There was an error saving the file information to the database.";
            }

            $stmt->close();
        } else {
            echo "There was an error moving the uploaded file.";
        }
    } else {
        echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
    }
} else {
    echo "No file uploaded or there was an upload error.";
}

$conn->close();

