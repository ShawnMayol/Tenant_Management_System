<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$loggedInUserID = $_SESSION['user_id'] ?? null;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentProofID = $_POST['paymentProofID'];
    $amountPaid = $_POST['amountPaid'];
    $rejectComment = $_POST['rejectComment'] ?? null; // If reject comment is not set, it will be null

    // Validate and sanitize input
    $paymentProofID = intval($paymentProofID);
    $amountPaid = floatval($amountPaid);

    // Fetch invoice details to get fee information and paymentProof uploadDate
    $query = "SELECT *
              FROM paymentproof pp
              LEFT JOIN invoice i ON pp.invoice_ID = i.invoice_ID
              LEFT JOIN fees fe ON i.fee_ID = fe.fee_ID
              LEFT JOIN bill b ON i.invoice_ID = b.invoice_ID
              WHERE pp.paymentProof_ID = ?";

    // Prepare the statement to fetch invoice and fee details
    if ($stmt1 = $conn->prepare($query)) {
        $stmt1->bind_param("i", $paymentProofID);
        $stmt1->execute();
        $result = $stmt1->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            $invoiceID = $data['invoice_ID'];
            $feeID = $data['fee_ID'];
            $totalAmount = $data['totalAmount'];
            $paymentMethod = $data['paymentMethod'];
            $uploadDate = $data['uploadDate']; // Get uploadDate from paymentProof

            // Calculate overpayment and outstanding balance
            $overpayment = max(0, $amountPaid - $totalAmount);
            $outstandingBalance = max(0, $totalAmount - $amountPaid);

            // Prepare the statement to insert into the bill table
            $insertBillQuery = "INSERT INTO bill (invoice_ID, paymentMethod, amountPaid, overpayment, outstandingBalance, paymentDate)
                                VALUES (?, ?, ?, ?, ?, ?)";

            if ($stmt2 = $conn->prepare($insertBillQuery)) {
                $stmt2->bind_param("isddds", $invoiceID, $paymentMethod, $amountPaid, $overpayment, $outstandingBalance, $uploadDate);
                if ($stmt2->execute()) {
                    // Retrieve the auto-generated bill_ID
                    $billID = $stmt2->insert_id;

                    // Prepare the statement to update totalAmount in fees table
                    $updateFeesQuery = "UPDATE fees
                                        SET totalAmount = totalAmount - ?
                                        WHERE fee_ID = ?";

                    if ($stmt3 = $conn->prepare($updateFeesQuery)) {
                        $stmt3->bind_param("di", $amountPaid, $feeID);
                        if ($stmt3->execute()) {
                            $tenantUserIDQuery = "SELECT *
                                                  FROM transactionLog tr
                                                  JOIN ";
                            if ($stmt = $conn->prepare($tenantUserIDQuery)) {
                                $stmt->execute();
                                $stmt->bind_result($tenantUserID);
                                $stmt->fetch();
                                $stmt->close();
                            }

                            if (isset($staffID)) {
                                // Prepare the statement to insert into the transactionlog table
                                $insertTransactionLogQuery = "INSERT INTO transactionlog (bill_ID, user_ID, receivedBy, transactionStatus)
                                                              VALUES (?, ?, ?, 'received')";

                                if ($stmt4 = $conn->prepare($insertTransactionLogQuery)) {
                                    // Set the user_ID and receivedBy values based on your application's logic
                                    $userID = $tenantUserID;
                                    $receivedBy = $loggedInUserID;

                                    $stmt4->bind_param("iii", $billID, $userID, $receivedBy);
                                    if ($stmt4->execute()) {
                                        echo "Bill inserted successfully. Fees updated successfully.";
                                    } else {
                                        echo "Failed to insert transaction log: " . $stmt4->error;
                                    }

                                    $stmt4->close(); // Close the transaction log statement
                                } else {
                                    echo "Error preparing transaction log statement: " . $conn->error;
                                }
                            } else {
                                echo "Staff ID not found.";
                            }
                        } else {
                            echo "Failed to update fees: " . $stmt3->error;
                        }

                        $stmt3->close(); // Close the fees update statement
                    } else {
                        echo "Error preparing fees update statement: " . $conn->error;
                    }
                } else {
                    echo "Failed to insert bill: " . $stmt2->error;
                }

                $stmt2->close(); // Close the bill statement
            } else {
                echo "Error preparing insert bill statement: " . $conn->error;
            }
        } else {
            echo "Invoice details not found for paymentProof_ID: $paymentProofID";
        }

        $stmt1->close(); // Close the fetch statement
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close(); // Close the database connection
?>
